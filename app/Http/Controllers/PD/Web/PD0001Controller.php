<?php

namespace App\Http\Controllers\PD\Web;

use App\Models\PD\Lookup\PtpdRawMateCasingV;
use App\Models\PD\PtpdSimuAdditiveH;
use Illuminate\Support\Facades\DB;

class PD0001Controller extends BaseController
{

    public function index()
    {
        // get header
        $headers = PtpdSimuAdditiveH::where('simu_type', 'CASING')
                        ->selectRaw("simu_formula_id, simu_formula_no, description, remark_formula, to_char(creation_date, 'yyyy-mm-dd') creation_date, created_by, to_char(last_update_date, 'yyyy-mm-dd') last_update_date, last_updated_by")
                        ->orderBy('simu_formula_no')
                        ->get();

        // get data for lookup
        $raw_materials = PtpdRawMateCasingV::orderBy('item_code')->get();

        $uoms = DB::select('select uom.inventory_item_id, uom.organization_id, uom.from_uom_code code, uom.conversion_rate, uom.to_uom_code
        from ptpm_item_conv_uom_v uom
        join ptpd_raw_mate_casing_v raw_mat
        on raw_mat.inventory_item_id = uom.inventory_item_id
        and raw_mat.organization_id = uom.organization_id
        order by uom.from_uom_code');

        return $this->vue('pd0001', [
            'btn' => $btnTrans = trans('btn'),
            'default_data' => getDefaultData(),
            'headers_data' => $headers,
            'raw_materials_data' => $raw_materials,
            'uoms_data' => $uoms,
        ]);
    }
}
