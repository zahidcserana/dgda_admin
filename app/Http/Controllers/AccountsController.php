<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Account;
use App\Model\Customer;
use Validator;
use DB;
use PDF;
use Auth;
use Session;

class AccountsController extends Controller
{
    /*
     * Customer Form
     */
    public function form()
    {
        $data = array(
            'customers' => DB::table('customers')->get()
        );
        return view('accounts.add', $data);
    }

    /*
     * Add
     */
    public function add(Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'amount' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }
        DB::table('accounts')->insert($data);
        return redirect()->route('accounts');
    }

    public function index()
    {
        $data = array();
        $data['title'] = 'Accounts';

        return view('accounts.index', $data);
    }

    public function accountsList(Request $request)
    {
        $query = $request->query('query');

        $conditions = array();
        $where = array();
        if (isset($query['name']) && !empty($query['name'])) {
            $conditions = array_merge(array(['customers.name', 'LIKE', '%' . $query['name'] . '%']), $conditions);
        }
        if (isset($query['email']) && !empty($query['email'])) {
            $conditions = array_merge(array(['customers.email', 'LIKE', '%' . $query['email'] . '%']), $conditions);
        }
        if (isset($query['mobile']) && !empty($query['mobile'])) {
            $conditions = array_merge(array(['customers.mobile', 'LIKE', '%' . $query['mobile'] . '%']), $conditions);
        }
        if (isset($query['status']) && !empty($query['status'])) {
            $conditions = array_merge(array('accounts.status' => $query['status']), $conditions);
        }
        $accounts = DB::table('customers')->Join('accounts', 'accounts.customer_id', '=', 'customers.id')->where($conditions)->get();

        foreach ($accounts as $account) {
            $account->customer_id = '<a href="/accounts/' . $account->id . '">' . $account->name . '</a>';
            $account->actions = '
               <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">
                   Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a href="/accounts/' . $account->id . '">Edit</a></li>
                    <li><a onclick="return confirm(\'Are you sure?\')" href="/accounts/' . $account->id . '/delete">Delete</a></li>
                  </ul>
                </div>
					';
        }
        $data['accounts'] = $accounts;

        echo json_encode($accounts);
    }

    /*
     * View Customer
     */
    public function view($id,Request $request)
    {
        $account = DB::table('customers')->Join('accounts', 'accounts.customer_id', '=', 'customers.id')->where('accounts.id', $id)->first();
        if (empty($account)) {
            return redirect()->route('accounts');
        }
        $request->session()->put('account', $account);
        $data = array(
            'account' => $account,
            'customers' => DB::table('customers')->get(),
        );
        return view('accounts.view', $data);
    }

    public function edit($id = null, Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'amount' => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }
        DB::table('accounts')->where('id', $id)->update($data);
        return redirect()->route('accounts');
    }

    public function downloadPDF(Request $request)
    {
        $account = $request->session()->get('account');
        $pdf = PDF::loadView('accounts.pdf', compact('account'));
        return $pdf->download('account.pdf');
    }

    /*
     * Delete an account
     */
    public function delete($id)
    {
        DB::table('accounts')->where('id', $id)->delete();
        return redirect()->route('accounts');
    }
}
