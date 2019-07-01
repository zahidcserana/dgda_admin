<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Customer;
use Validator;
use DB;
use Input;
use File;
use Image;
use Uuid;
use Session;

class CustomersController extends Controller
{

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
     * customer List
     */
    public function index()
    {
        $data = array();
        $data['title'] = 'Order';

        return view('customers.index', $data);
    }

    /*
     * Ajax request for listing
     */
    public function customersList(Request $request)
    {
        $query = $request->query('query');

        $conditions = array();
        if (isset($query['name']) && !empty($query['name'])) {
            $conditions = array_merge(array(['name', 'LIKE', '%' . $query['name'] . '%']), $conditions);
        }
        if (isset($query['email']) && !empty($query['email'])) {
            $conditions = array_merge(array(['email', 'LIKE', '%' . $query['email'] . '%']), $conditions);
        }
        if (isset($query['mobile']) && !empty($query['mobile'])) {
            $conditions = array_merge(array(['mobile', 'LIKE', '%' . $query['mobile'] . '%']), $conditions);
        }
        if (isset($query['status']) && !empty($query['status'])) {
            $conditions = array_merge(array('status' => $query['status']), $conditions);
        }
        $customers = DB::table('orders')->where($conditions)->get();
        foreach ($customers as $customer) {
            $customer->name = '<a href="/orders/' . $customer->id . '">' . $customer->id . '</a>';
            $customerId = $customer->id;
            $customer->actions = '
               <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">
                   Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="/orders/' . $customerId . '">Edit</a></li>
                    <li><a onclick="return confirm(\'Are you sure?\')" href="/orders/' . $customerId . '/delete">Delete</a></li>
                  </ul>
                </div>
					';
        }
        $data['customers'] = $customers;

        echo json_encode($customers);
    }

    /*
     * View Customer
     */
    public function view($id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
        $data['customer'] = $customer;
        if (empty($customer))
            return redirect()->route('customers');
        return view('customers.view', $data);
    }

    /*
     * Edit Customer
     */
    public function edit($id, Request $request)
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
        DB::table('customers')->where('id', $id)->update($data);
        return redirect()->route('customers');
    }

    /*
     * Delete a customer
     */
    public function delete($id)
    {
        DB::table('customers')->where('id', $id)->delete();
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
