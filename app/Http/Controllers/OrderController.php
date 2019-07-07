<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
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

    public function orderItems()
    {
        $data = array();
        $data['title'] = 'Order';

        return view('orders.item_list', $data);
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

                $aData['invoice'] = $order->invoice;

                $medicine = $item->medicine;
                $aData['medicine'] = $medicine->brand_name;

                $aData['exp_date'] = $this->_getExpStatus($item->exp_date);
                $aData['mfg_date'] = date("F Y", strtotime($item->mfg_date));;
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
        $expDate = date("F Y", strtotime($date));

        $today = date('Y-m-d');
        $exp1M = date('Y-m-d', strtotime("+1 months", strtotime(date('Y-m-d'))));
        $exp2M = date('Y-m-d', strtotime("+2 months", strtotime(date('Y-m-d'))));
        $exp3M = date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d'))));
        if ($date < $today) {
            return '<span class="m-badge  m-badge--danger m-badge--wide.">' . $expDate . '</span>';
        } else if ($date > $exp3M) {
            return '<span class="m-badge  m-badge--info m-badge--wide">' . $expDate . '</span>';
        } else if ($date > $exp2M) {
            return '<span class="m-badge  m-badge--success m-badge--wide">' . $expDate . '</span>';
        } else if ($date > $exp1M) {
            return '<span class="m-badge  m-badge--warning m-badge--wide">' . $expDate . '</span>';
        } else {
            return '<span class="m-badge  m-badge--metal m-badge--wide">' . $expDate . '</span>';
        }
    }

    public function itemList(Request $request)
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
