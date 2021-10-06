<?php

namespace App\Http\Controllers\PD\Web;

use App\Http\Controllers\Controller;
use App\Models\PD\PtpdExpandedTobaccoH;
use App\Models\PD\Lookup\PtpdExpandedTobaccoV;
use App\Models\PD\Lookup\PtpdExpandedTobaccoItemV;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpandedTobaccoHController extends BaseController
{
    public function index($id = null)
    {
        $header = $id ? PtpdExpandedTobaccoH::find($id) : (object)[];
        $headers = [];//PtpdExpandedTobaccoH::query()->get();

        //$lookup_headers = PtpdExpandedTobaccoV::orderBy('inventory_item_code')->get();
        $lookup_lines = PtpdExpandedTobaccoItemV::query()->orderBy('inventory_item_code')->get();

        $lookup_headers = DB::select("
            -- lookup รหัสสินค้าได้เฉพาะที่ยังไม่เคยบันทึกเท่านั้น
            SELECT  *
            FROM    OAPD.PTPD_EXPANDED_TOBACCO_V PETV
            WHERE   NOT EXISTS (
                SELECT  'Y'
                FROM    OAPD.PTPD_EXPANDED_TOBACCO_H
                WHERE   INVENTORY_ITEM_ID = PETV.INVENTORY_ITEM_ID)
        ");

        $data = [
            'createdAt' => date('Y-m-d'),
            'userId' => Auth::id(),
            'headers' => $headers,
            'lookupHeaders' => $lookup_headers,
            'lookupLines' => $lookup_lines,
        ];

        $btnTrans = trans('btn');

        return $this->vue('PD0009', [
            'data' => $data,
            'init_header' => $header,
            "btn_trans" => $btnTrans,
        ]);
    }

    public function test()
    {
        // $header = PtpdExpandedTobaccoH::find(14);
        // $line = $header->lines()->get();
        // dd($line);
        // echo $header->created_by;
    }
}
