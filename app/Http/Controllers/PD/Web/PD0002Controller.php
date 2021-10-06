<?php

namespace App\Http\Controllers\PD\Web;

use App\Models\PD\Lookup\MtlUnitsOfMeasureVl;
use App\Models\PD\Lookup\PtpdRawMateFlavorV;
use App\Models\PD\PtpdSimuAdditiveH;

class PD0002Controller extends BaseController
{

    public function index()
    {
        // get header
        $header_data = PtpdSimuAdditiveH::where('simu_type', 'FLAVOR')->select('simu_formula_id', 'simu_formula_no', 'description', 'remark_formula', 'creation_date', 'created_by', 'last_update_date', 'last_updated_by')->orderBy('simu_formula_no')->get();

        // get data for lookup
        $raw_mate_data = PtpdRawMateFlavorV::orderBy('item_code')->get();

        $uoms = MtlUnitsOfMeasureVl::select('uom_code')->orderBy('uom_code')->get();

        return $this->vue('pd0002', [
            'auth_userid' => auth()->user()->user_id,
            'auth_username' => auth()->user()->username,
            'sysdate' => date('d-M-Y'),
            'header_data' => $header_data,
            'raw_mate_data' => $raw_mate_data,
            'uom_data' => $uoms,
        ]);
    }
}
