<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Sale;

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
        $order = DB::table('orders')->count();
        $company = DB::table('order_items')->select('company_id')->distinct()->get()->count();
        $medicine = DB::table('order_items')->select('medicine_id')->distinct()->get()->count();
        $entry = DB::table('order_items')->count();

        $where = array();
        $where = array_merge(array(['medicines.is_antibiotic', true]), $where);
        $saleItem = Sale::where($where)
            ->join('sale_items', 'sales.id', '=', 'sale_items.sale_id')
            ->join('medicines', 'sale_items.medicine_id', '=', 'medicines.id')
            ->count();


        $data = array();
        $data['total_order'] = $order;
        $data['total_pharmacy'] = $pharmacy;
        $data['total_company'] = $company;
        $data['total_medicine'] = $medicine;
        $data['total_entry'] = $entry;
        $data['total_sale_item'] = $saleItem;
        return view('home', $data);
    }

    /** delete duplicate */
    public function orderRepair()
    {
        $distinct_orders = DB::table('orders')->select('company_invoice')->distinct()->get();
        foreach ($distinct_orders as $order) :

            $order_details = DB::table('orders')->where('company_invoice', $order->company_invoice)->get();

            if (count($order_details)) {

                $main_order_id = $order_details[0]->id;

                foreach ($order_details as $info) :
                    if ($info->id != $main_order_id) {

                        $items = OrderItem::where('order_id', $info->id)->delete();

                        // foreach ($items as $item) :
                        //     $item_update = OrderItem::find($item->id);
                        //     $item_update->order_id = $main_order_id;
                        //     $item_update->save();
                        // endforeach;

                        Order::where('id', $info->id)->delete();
                    }
                endforeach;
            }
        endforeach;
        $distinct_order_info = DB::table('orders')->select('company_invoice')->distinct()->get();
        echo json_encode($distinct_order_info);
    }

    public function getExtraItem(){
        $items = OrderItem::all();
        $ids = array();
        foreach($items as $item){

            if(!Order::find($item->order_id)){
                $ids[] = $item->order_id;
                echo $item->order_id."<br>";
            }
        }

    }

    public function companyScript(){
        $items = OrderItem::all();
        foreach($items as $item){
           $order = Order::find($item->order_id)->update(['company_id'=>$item->company_id]);
        }
    }

    public function createdDate(){
        $orders = Order::all();

        foreach($orders as $order){
            $orderPrev = DB::table('orders_prev')->where('id',$order->id)->first();

            if(empty($orderPrev)){
                $date = '2019-07-18 00:00:00';
            }else{
                $date = $orderPrev->created_at;
            }

            DB::table('orders')
            ->where('id', $order->id)
            ->update(['created_at'=>$date]);

        }

    }
}
