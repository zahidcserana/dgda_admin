<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class UsersController extends Controller
{
    public function index($id = null)
    {
        $users = DB::table('users')->get();
        $user = array();
        if ($id != null) {
            $user = DB::table('users')->where('id', $id)->first();
        }
        $data['users'] = $users;
        $data['user'] = $user;

        return view('auth.users', $data);
    }

    /*
    * Edit User
    */
    public function edit($id, Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }
        unset($data['password_confirmation']);
        $data['password'] = Hash::make($data['password']);
        DB::table('users')->where('id', $id)->update($data);
        return redirect()->route('users')->with('status','Successfully Updated.');
    }

    public function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect('users')->with('status', 'Successfully Deleted.');
    }
}
