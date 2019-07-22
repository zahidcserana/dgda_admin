<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineCompany;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Input;
use File;
use Image;
use Uuid;
use Session;
use App\Models\PharmacyBranch;

class InvoiceController extends Controller
{
    /**
     * Invoice
     *
     * @return void
     */
    public function invoices()
    {
        $data = array();
        $data['title'] = 'Order';

        $data['pharmacy'] = DB::table('pharmacy_branches')->get();
        $data['medicine_company'] = DB::table('medicine_companies')->orderBy('company_name', 'ASC')->get();

        return view('invoices.index', $data);
    }

    /**
     * Ajax request for listing
     * @param Request $request
     */
    public function invoiceList(Request $request)
    {
        $user = Auth::user();
        $userType = $user->user_type ?? 'DGDA';
        $query = $request->query('query');

        $conditions = array();

        if (isset($query['invoice']) && !empty($query['invoice'])) {
            $conditions = array_merge(array(['company_invoice', 'LIKE', '%' . $query['invoice'] . '%']), $conditions);
        }
        if (!empty($query['company_id'])) {
            $conditions = array_merge(array(['company_id', $query['company_id']]), $conditions);
        }
        if (isset($query['status']) && !empty($query['status'])) {
            $conditions = array_merge(array(['status', 'LIKE', '%' . $query['status'] . '%']), $conditions);
        }
        if (isset($query['mobile']) && !empty($query['mobile'])) {
            $conditions = array_merge(array(['mobile', 'LIKE', '%' . $query['mobile'] . '%']), $conditions);
        }
        if (isset($query['id']) && !empty($query['id'])) {
            $conditions = array_merge(array('id' => $query['id']), $conditions);
        }
        if (isset($query['pharmacy_id']) && !empty($query['pharmacy_id'])) {
            $conditions = array_merge(array('pharmacy_branch_id' => $query['pharmacy_id']), $conditions);
        }
        $orders = Order::where($conditions)
        ->orderBy('id', 'desc')
        ->get();

            $data = array();
        foreach ($orders as $order) {
            $aData = array();
            $aData['invoice'] = $order->company_invoice;
            $aData['created_at'] =  date("d F, Y", strtotime($order->created_at));
            $pharmacyBranch = $order->PharmacyBranch;

            $company = DB::table('medicine_companies')->where('id',$order->company_id)->pluck('company_name');
            $aData['company'] = $company;


            $aData['pharmacy_branch'] = $pharmacyBranch->branch_name;
            $aData['status'] = $order->status;
            $order->order_id = '<a href="/orders/' . $order->id . '">' . $order->id . '</a>';
            $orderId = $order->id;
            $aData['actions'] = '
               <div class="btn">
                  <a href="/invoices/' . $orderId . '">Details</a>
                </div>
                    ';

            $data[] = $aData;
        }

        echo json_encode($data);
    }

    /**
     * Invoice details
     * @param $id
     * @return order
     */
    public function invoiceDetails($id)
    {
        $orderModel = new Order();

        $order = $orderModel::findOrFail($id);

        if (empty($order)) {
            return redirect()->route('orders');
        }
        $order = $orderModel->getOrderDetails($id);
        $data['order'] = $order;
        return view('invoices.view', $data);
    }


}