<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pharmacy = DB::table('pharmacy_branches')->count();
        $order = DB::table('orders')->select('company_invoice')->distinct()->get()->count();
        $company = DB::table('order_items')->select('company_id')->distinct()->get()->count();
        $medicine = DB::table('order_items')->select('medicine_id')->distinct()->get()->count();
        $entry = DB::table('order_items')->count();
       
        $data = array();
        $data['total_order'] = $order;
        $data['total_pharmacy'] = $pharmacy;
        $data['total_company'] = $company;
        $data['total_medicine'] = $medicine;
        $data['total_entry'] = $entry;
        return view('home', $data);
    }
}
