<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\MedicineCompany;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function saleItems()
    {
        $data = array();
        $data['title'] = 'Sale';
        $medicine_company = DB::table('medicine_companies')->orderBy('company_name', 'ASC')->get();
        $data['medicine_company'] = $medicine_company;

        return view('sales.item_list', $data);
    }

    public function itemList(Request $request)
    {
        $query = $request->query('query');

        $pageNo = $request->query('page_no') ?? 1;
        // $limit = $request->query('limit') ?? 100;
        // $offset = (($pageNo - 1) * $limit);
        $where = array();
        $where = array_merge(array(['medicines.is_antibiotic', true]), $where);

        if (!empty($query['pharmacy_licence_no'])) {
            $where = array_merge(array(['pharmacies.pharmacy_shop_licence_no', 'LIKE', '%' . $query['pharmacy_licence_no'] . '%']), $where);
        }
        if (!empty($query['pharmacy'])) {
            $where = array_merge(array(['pharmacy_branches.branch_name', 'LIKE', '%' . $query['pharmacy'] . '%']), $where);
        }
        if (!empty($query['company_id'])) {
            $where = array_merge(array(['sale_items.company_id', $query['company_id']]), $where);
        }
        if (!empty($query['batch_no'])) {
            $where = array_merge(array(['sale_items.batch_no', 'LIKE', '%' . $query['batch_no'] . '%']), $where);
        }
        if (!empty($query['branch_city'])) {
            $where = array_merge(array(['pharmacy_branches.branch_city', 'LIKE', '%' . $query['branch_city'] . '%']), $where);
        }
        if (!empty($query['branch_area'])) {
            $where = array_merge(array(['pharmacy_branches.branch_area', 'LIKE', '%' . $query['branch_area'] . '%']), $where);
        }
        if (!empty($query['medicine_name'])) {
            $where = array_merge(array(['medicines.brand_name', 'LIKE', '%' . $query['medicine_name'] . '%']), $where);
        }
        if (!empty($query['exp_type'])) {
            $where = $this->_getExpCondition($where, $query['exp_type']);
        }
        if (!empty($query['company_id'])) {
            $company_id = $query['company_id'];
        } else {
            $company_id = 0;
        }

        $query = Sale::where($where)
            ->join('sale_items', 'sales.id', '=', 'sale_items.sale_id')
            ->join('medicines', 'sale_items.medicine_id', '=', 'medicines.id')
            ->join('pharmacy_branches', 'sales.pharmacy_branch_id', '=', 'pharmacy_branches.id')
            ->join('pharmacies', 'sales.pharmacy_id', '=', 'pharmacies.id');

        $total = $query->count();

        $orders = $query
            //->offset($offset)
            //->limit($limit)
            ->get();

        $orderData = array();
        foreach ($orders as $item) {
            $this->imageUpload($item);
            $aData = array();
            $aData['id'] = $item->id;
            $aData['sale_id'] = $item->sale_id;
            $aData['file_name'] = empty($item->file_name) == true ? '' : '/uploads/' . $item->file_name;

            $company = MedicineCompany::findOrFail($item->company_id);
            $aData['company'] = $company->company_name;

            $aData['pharmacy_branch'] = $item->branch_name . '<br>(LN# ' . $item->pharmacy_shop_licence_no . ')';
            $aData['pharmacy_licence_no'] = $item->pharmacy_shop_licence_no;

            $aData['invoice'] = $item->invoice;

            $medicine = Medicine::findOrFail($item->medicine_id);
            $aData['medicine'] = $medicine->brand_name;

            $aData['exp_date'] = $this->_getExpStatus($item->exp_date);
            $aData['mfg_date'] = date("F, Y", strtotime($item->mfg_date));

            $aData['batch_no'] = $item->batch_no;
            $aData['quantity'] = $item->quantity;
            $aData['status'] = $item->status;

            $orderData[] = $aData;
        }

        $data = array(
            'total' => $total,
            'data' => $orderData,
            'page_no' => $pageNo,
            // 'limit' => $limit,
        );
        echo json_encode($orderData);
    }
    public function imageUpload($data)
    {
      if ($data['file'] && !file_exists($dir = 'assets/prescription_image/'. $data['file_name']))
      {
          $picture   = base64_decode($data['file']);
          $dir = 'uploads'. $data['file_name'];
          file_put_contents($dir, $picture);
      }
    }
    private function _getExpStatus($date)
    {
        $expDate = date("F, Y", strtotime($date));

        $today = date('Y-m-d');
        $exp1M = date('Y-m-d', strtotime("+1 months", strtotime(date('Y-m-d'))));
        $exp3M = date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d'))));
        if ($date < $today) {
            return '<blink><span class="m-badge  m-badge--danger m-badge--wide">' . $expDate . '</span></blink>';
        } else if ($date >= $today && $date <= $exp1M) {
            return '<blink><span class="m-badge  m-badge--warning m-badge--wide">' . $expDate . '</span></blink>';
        } else if ($date > $exp1M && $date <= $exp3M) {
            return '<blink><span class="m-badge  m-badge--month3 m-badge--wide">' . $expDate . '</span></blink>';
        } else {
            return '<span class="m-badge  m-badge--metal m-badge--wide">' . $expDate . '</span>';
        }
    }

    private function _getExpCondition($where, $expTpe)
    {
        $today = date('Y-m-d');
        $exp1M = date('Y-m-d', strtotime("+1 months", strtotime(date('Y-m-d'))));
        $exp3M = date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d'))));
        if ($expTpe == 2) {
            $where = array_merge(array(
                ['order_items.exp_date', '>', $today],
                ['order_items.exp_date', '<', $exp1M]
            ), $where);
        } else if ($expTpe == 3) {
            $where = array_merge(array(
                ['order_items.exp_date', '>', $exp1M],
                ['order_items.exp_date', '<', $exp3M]
            ), $where);
        } else if ($expTpe == 1) {
            $where = array_merge(array(
                ['order_items.exp_date', '>', $exp3M]
            ), $where);
        } else if ($expTpe == 4) {
            $where = array_merge(array(['order_items.exp_date', '<', $today]), $where);
        }
        return $where;
    }
}
