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
        $order = DB::table('orders')->select('company_invoice', DB::raw('count(*) as total'))->groupBy('company_invoice')->get();
        $company = DB::table('order_items')->select('company_id')->distinct()->get()->count();
        $medicine = DB::table('order_items')->select('medicine_id')->distinct()->get()->count();
       
        $data = array();
        $data['total_order'] = count($order);
        $data['total_pharmacy'] = $pharmacy;
        $data['total_company'] = $company;
        $data['total_medicine'] = $medicine;
        return view('home', $data);
    }
}
