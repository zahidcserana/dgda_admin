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

class PharmacyController extends Controller
{
     /**
     * order List
     */
    public function index()
    {
        $data = array();
        $data['title'] = 'Pharmacy';

        return view('pharmacies.index', $data);
    }

    /**
     * Ajax request for listing
     * @param Request $request
     */
    public function pharmacyList(Request $request)
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
        $pharmacies = DB::table('pharmacy_branches')
        ->where($conditions)
        ->orderBy('pharmacy_branches.id', 'desc')
        ->join('pharmacies', 'pharmacy_branches.pharmacy_id', '=', 'pharmacies.id')
        ->get();

        $data['pharmacies'] = $pharmacies;

        echo json_encode($pharmacies);
    }
}
