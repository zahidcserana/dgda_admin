<?php

namespace App\Http\Controllers;

use App\Model\Order;
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

        return view('customers.index', $data);
    }

    /**
     * Ajax request for listing
     * @param Request $request
     */
    public function orderList(Request $request)
    {
        $user = Auth::user();
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
        $customers = DB::table('orders')->where($conditions)->orderBy('id', 'desc')->get();

        foreach ($customers as $customer) {
            $customer->order_id = '<a href="/orders/' . $customer->id . '">' . $customer->id . '</a>';
            $customerId = $customer->id;
            if ($user->user_type == 'DGDA') {
                $customer->actions = '
               <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">
                   Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                 <li><a href="/orders/' . $customerId . '/details">Details</a></li>
                  </ul>
                </div>
					';
            } else {
                $customer->actions = '
               <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">
                   Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="/orders/' . $customerId . '">Process</a></li>
                    <li><a onclick="return confirm(\'Are you sure?\')" href="/orders/' . $customerId . '/delete">Delete</a></li>
                  </ul>
                </div>
					';
            }

        }
        $data['customers'] = $customers;

        echo json_encode($customers);
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

    /** *** *** *** */

    /*
     * Customer Form
     */
    public function form()
    {
        $data = array();
        return view('customers.add', $data);
    }

    /*
     * Customer Add
     */
    public function add(Request $request)
    {
        $data = $request->except('_token');

        $rules = [
            'name' => 'required|string|max:100',
            'mobile' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }
        DB::table('customers')->insert($data);
        return redirect()->route('customers');
    }

    /*
     * Edit Customer
     */
    public function edit($id, Request $request)
    {
        return redirect()->route('orders');

        $data = $request->except('_token');
        $rules = [
            'name' => 'required|string|max:100',
            'mobile' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }
        DB::table('customers')->where('id', $id)->update($data);
        return redirect()->route('customers');
    }

    /*
     * customer Image
     */
    public function customerImage(Request $request)
    {
        $status = false;
        if (Input::hasFile('file')) {
            $file = Input::file('file');
            $cropedImage = $request->cropedImageContent;
            $pos = strpos($cropedImage, ',');
            $rest = substr($cropedImage, $pos);
            $data = base64_decode($rest);

            $name = $file->getClientOriginalName();
            $temp = explode('.', $name);
            $extention = array_pop($temp);

            $cropImage = Uuid::generate(1);
            $cropImage = $cropImage . "." . $extention;
            $destinationPath = public_path() . '/image/users';

            file_put_contents($destinationPath . "/" . $cropImage, $data);

            $input = array(
                'image' => $cropImage
            );
            $image = DB::table('customers')->where('id', $request->user_id)->first()->image;
            if (!empty($image) && file_exists($destinationPath . "/" . $image)) {
                unlink($destinationPath . "/" . $image);
            }
            DB::table('customers')->where('id', $request->user_id)->update($input);

            $status = true;
        }
        if ($status) {
            return json_encode(['success' => true, 'message' => 'Your profile picture successfully changed!']);
        } else {
            return json_encode(['success' => false, 'message' => 'Sorry! Your profile picture not changed!']);
        }
    }
}
