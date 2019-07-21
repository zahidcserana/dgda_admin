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

class OrderController extends Controller
{
    /**
     * order List
     */
    public function index()
    {
        $data = array();
        $data['title'] = 'Order';

        return view('orders.index', $data);
    }

    /**
     * Ajax request for listing
     * @param Request $request
     */
    public function orderList(Request $request)
    {
        $user = Auth::user();
        $userType = $user->user_type ?? 'DGDA';
        $query = $request->query('query');

        $conditions = array();

        if (isset($query['invoice']) && !empty($query['invoice'])) {
            $conditions = array_merge(array(['invoice', 'LIKE', '%' . $query['invoice'] . '%']), $conditions);
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
        $orders = DB::table('orders')->where($conditions)->orderBy('id', 'desc')->get();

        foreach ($orders as $order) {
            $order->order_id = '<a href="/orders/' . $order->id . '">' . $order->id . '</a>';
            $orderId = $order->id;
            if ($userType == 'DGDA') {
                $order->actions = '
               <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">
                   Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                 <li><a href="/orders/' . $orderId . '/details">Details</a></li>
                  </ul>
                </div>
					';
            } else {
                $order->actions = '
               <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">
                   Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="/orders/' . $orderId . '">Process</a></li>
                    <li><a onclick="return confirm(\'Are you sure?\')" href="/orders/' . $orderId . '/delete">Delete</a></li>
                  </ul>
                </div>
					';
            }
        }
        $data['orders'] = $orders;

        echo json_encode($orders);
    }

    /**
     * Invoice
     *
     * @return void
     */
    public function invoices()
    {
        $data = array();
        $data['title'] = 'Order';

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
            $conditions = array_merge(array(['invoice', 'LIKE', '%' . $query['invoice'] . '%']), $conditions);
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
        $orders = Order::where($conditions)
        ->orderBy('id', 'desc')
        ->get();
       
            $data = array();
        foreach ($orders as $order) {
            $aData = array();
            $aData['invoice'] = $order->company_invoice;
            $aData['created_at'] =  date("d F, Y", strtotime($order->created_at));
            $pharmacyBranch = $order->PharmacyBranch;

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

    public function orderItems()
    {
        $data = array();
        $data['title'] = 'Order';
        $medicine_company = DB::table('medicine_companies')->orderBy('company_name', 'ASC')->get();
        $data['medicine_company'] = $medicine_company;

        return view('orders.item_list', $data);
    }

    public function companyView()
    {
        $data = array();
        $data['title'] = 'Company';

        return view('orders.company_list', $data);
    }

    public function medicineView()
    {
        $data = array();
        $data['title'] = 'Medicine';

        return view('orders.medicine_list', $data);
    }

    //for Ajax Call
    public function companyList()
    {
        $companies = DB::table('order_items')->select('company_id', DB::raw('count(*) as total'))->groupBy('company_id')->get();
        $company_lists = [];
        foreach ($companies as $company) :
            $company_info = DB::table('medicine_companies')->where('id', $company->company_id)->get();
            if (count($company_info)) {
                $company_lists[] = $company_info[0];
            }
        endforeach;
        echo json_encode($company_lists);
    }

    public function medicineList()
    {
        $medicine = DB::table('order_items')->select('medicine_id', DB::raw('count(*) as total'))->groupBy('medicine_id')->get();
        $medicine_lists = [];
        foreach ($medicine as $item) :
            $medicine_info = DB::table('medicines')->where('id', $item->medicine_id)->get();
            if (count($medicine_info)) {
                $medicine_lists[] = $medicine_info[0];
            }
        endforeach;
        echo json_encode($medicine_lists);
    }

    public function _getItemList($where)
    {
        $query = Order::where($where);
        $orders = $query
            //            ->orderBy('id', 'desc')
            ->get();
        $orderData = array();
        foreach ($orders as $order) {
            $items = $order->items()->get();
            foreach ($items as $item) {
                $aData = array();
                $aData['id'] = $item->id;
                $aData['order_id'] = $item->order_id;

                $company = $item->company;
                $aData['company'] = $company->company_name;

                $aData['company_invoice'] = $order->company_invoice;

                $pharmacyBranch = $order->PharmacyBranch;
                $aData['pharmacy_branch'] = $pharmacyBranch->branch_name;

                $medicine = $item->medicine;
                $aData['medicine'] = $medicine->brand_name;

                $aData['exp_date'] = $this->_getExpStatus($item->exp_date);
                $aData['mfg_date'] = date("F, Y", strtotime($item->mfg_date));;
                $aData['batch_no'] = $item->batch_no;
                $aData['quantity'] = $item->quantity;
                $aData['status'] = $item->status;

                $orderData[] = $aData;
            }
        }

        return $orderData;
    }

    private function _getExpStatus($date)
    {
        $expDate = date("F, Y", strtotime($date));

        $today = date('Y-m-d');
        $exp1M = date('Y-m-d', strtotime("+1 months", strtotime(date('Y-m-d'))));
        $exp3M = date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d'))));
        if ($date < $today) {
            return '<blink><span class="m-badge  m-badge--danger m-badge--wide">' . $expDate . '</span></blink>';
        } else if ($date >= $today && $date <= $exp1M) {
            return '<blink><span class="m-badge  m-badge--warning m-badge--wide">' . $expDate . '</span></blink>';
        } else if ($date > $exp1M && $date <= $exp3M) {
            return '<blink><span class="m-badge  m-badge--month3 m-badge--wide">' . $expDate . '</span></blink>';
        } else {
            return '<span class="m-badge  m-badge--metal m-badge--wide">' . $expDate . '</span>';
        }
    }

    public function itemList(Request $request)
    {
        $query = $request->query('query');

        $pageNo = $request->query('page_no') ?? 1;
        // $limit = $request->query('limit') ?? 100;
        // $offset = (($pageNo - 1) * $limit);
        $where = array();
        $where = array_merge(array(['orders.is_manual', true]), $where);


        if (!empty($query['pharmacy_licence_no'])) {
            $where = array_merge(array(['pharmacies.pharmacy_shop_licence_no', 'LIKE', '%' . $query['pharmacy_licence_no'] . '%']), $where);
        }
        if (!empty($query['pharmacy'])) {
            $where = array_merge(array(['pharmacy_branches.branch_name', 'LIKE', '%' . $query['pharmacy'] . '%']), $where);
        }
        if (!empty($query['company_id'])) {
            $where = array_merge(array(['order_items.company_id', $query['company_id']]), $where);
        }
        if (!empty($query['batch_no'])) {
            $where = array_merge(array(['order_items.batch_no', 'LIKE', '%' . $query['batch_no'] . '%']), $where);
        }
        if (!empty($query['branch_city'])) {
            $where = array_merge(array(['pharmacy_branches.branch_city', 'LIKE', '%' . $query['branch_city'] . '%']), $where);
        }
        if (!empty($query['branch_area'])) {
            $where = array_merge(array(['pharmacy_branches.branch_area', 'LIKE', '%' . $query['branch_area'] . '%']), $where);
        }
        if (!empty($query['medicine_name'])) {
            $where = array_merge(array(['medicines.brand_name', 'LIKE', '%' . $query['medicine_name'] . '%']), $where);
        }
        if (!empty($query['exp_type'])) {
            $where = $this->_getExpCondition($where, $query['exp_type']);
        }
        if (!empty($query['company_id'])) {
            $company_id = $query['company_id'];
        } else {
            $company_id = 0;
        }

        $query = Order::where($where)
            // ->when($company_id, function ($dbquery) use ($company_id) {
            //     return $dbquery->where('orders.company_id', $company_id);
            // })
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('medicines', 'order_items.medicine_id', '=', 'medicines.id')
            ->join('pharmacy_branches', 'orders.pharmacy_branch_id', '=', 'pharmacy_branches.id')
            ->join('pharmacies', 'orders.pharmacy_id', '=', 'pharmacies.id');
            
        $total = $query->count();
        $orders = $query
            //->offset($offset)
            //->limit($limit)
            ->get();
        $orderData = array();
        foreach ($orders as $item) {
            //$items = $order->items()->get();

            $aData = array();
            $aData['id'] = $item->id;
            $aData['order_id'] = $item->order_id;

            $company = MedicineCompany::findOrFail($item->company_id);
            $aData['company'] = $company->company_name;

            $aData['pharmacy_branch'] = $item->branch_name .'<br>(LN# '.$item->pharmacy_shop_licence_no.')';
            $aData['pharmacy_licence_no'] = $item->pharmacy_shop_licence_no;

            $aData['company_invoice'] = $item->company_invoice;

            $medicine = Medicine::findOrFail($item->medicine_id);
            $aData['medicine'] = $medicine->brand_name;

            $aData['exp_date'] = $this->_getExpStatus($item->exp_date);
            $aData['mfg_date'] = date("F, Y", strtotime($item->mfg_date));

            //$aData['mfg_date'] = $item->mfg_date;
            $aData['batch_no'] = $item->batch_no;
            $aData['quantity'] = $item->quantity;
            $aData['status'] = $item->status;

            $orderData[] = $aData;
        }

        $data = array(
            'total' => $total,
            'data' => $orderData,
            'page_no' => $pageNo,
            // 'limit' => $limit,
        );
        echo json_encode($orderData);
    }
    private function _getExpCondition($where, $expTpe)
    {
        $today = date('Y-m-d');
        $exp1M = date('Y-m-d', strtotime("+1 months", strtotime(date('Y-m-d'))));
        $exp3M = date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d'))));
        if ($expTpe == 2) {
            $where = array_merge(array(
                ['order_items.exp_date', '>', $today],
                ['order_items.exp_date', '<', $exp1M]
            ), $where);
        } else if ($expTpe == 3) {
            $where = array_merge(array(
                ['order_items.exp_date', '>', $exp1M],
                ['order_items.exp_date', '<', $exp3M]
            ), $where);
        } else if ($expTpe == 1) {
            $where = array_merge(array(
                ['order_items.exp_date', '>', $exp3M]
            ), $where);
        } else if ($expTpe == 4) {
            $where = array_merge(array(['order_items.exp_date', '<', $today]), $where);
        }
        return $where;
    }

    public function itemList_old(Request $request)
    {
        $user = Auth::user();
        $userType = $user->user_type ?? 'DGDA';
        $query = $request->query('query');

        $conditions = array();

        if (isset($query['company_invoice']) && !empty($query['company_invoice'])) {
            $conditions = array_merge(array(['company_invoice', 'LIKE', '%' . $query['company_invoice'] . '%']), $conditions);
        }
        if (isset($query['status']) && !empty($query['status'])) {
            $conditions = array_merge(array(['status', 'LIKE', '%' . $query['status'] . '%']), $conditions);
        }
        if (isset($query['medicine']) && !empty($query['medicine'])) {
            $medicine = new Medicine();
            $medicineData = $medicine->where('brand_name', 'like', $query['medicine'])->first();
            $conditions = array_merge(array('medicine_id' => $medicineData->id), $conditions);
        }
        if (isset($query['mobile']) && !empty($query['mobile'])) {
            $conditions = array_merge(array(['mobile', 'LIKE', '%' . $query['mobile'] . '%']), $conditions);
        }
        if (isset($query['id']) && !empty($query['id'])) {
            $conditions = array_merge(array('id' => $query['id']), $conditions);
        }

        $orders = $this->_getItemList($conditions);

        echo json_encode($orders);
    }

    /**
     * Order view
     * @param $id
     * @return order
     */
    public function view($id)
    {
        $orderModel = new Order();

        $order = $orderModel::findOrFail($id);
        if (empty($order)) {
            return redirect()->route('orders');
        }
        $order = $orderModel->getOrderDetails($id);
        $data['order'] = $order;
        return view('orders.view', $data);
    }

    /**
     * Order view
     * @param $id
     * @return order
     */
    public function details($id)
    {
        $orderModel = new Order();

        $order = $orderModel::findOrFail($id);
        if (empty($order)) {
            return redirect()->route('orders');
        }
        $order = $orderModel->getOrderDetails($id);
        $data['order'] = $order;
        return view('orders.view', $data);
    }

    /**
     * Delete a order
     */
    public function delete($id)
    {
        DB::table('orders')->where('id', $id)->delete();
        DB::table('order_items')->where('order_id', $id)->delete();
        return redirect()->route('orders');
    }

    /*
     * Edit Order
     */
    public function edit($id, Request $request)
    {
        return redirect()->route('orders');
    }
}
