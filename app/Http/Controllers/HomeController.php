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
        $order = DB::table('orders')->distinct('company_invoice')->count();
        $data = array();
        $data['total_order'] = $order;
        $data['total_pharmacy'] = $pharmacy;
        return view('home', $data);
    }
}
