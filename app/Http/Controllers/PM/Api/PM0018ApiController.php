<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0018ApiController extends Controller
{
    public function show(Request $request)
    {
        $data = DB::select("select a.organization_id, a.batch_no, a.blend_no, a.plan_qty, a.dtl_um, a.job_type, t.description, b.item_desc, b.quantity, b.primary_unit_of_measure
        from oapm.ptpm_summary_batch_v a
        left join oapm.ptpm_pmq0001_details_v b
        on b.organization_id = a.organization_id
        and b.inventory_item_id = apps.ptpm_main.get_product_id(p_organization_id => a.organization_id, p_inventory_item_id => a.inventory_item_id)
        left join oapm.ptpm_job_type t
        on t.lookup_code = a.job_type
        where a.plan_start_date >= to_date(?, 'yyyy-mm-dd')
        and a.plan_cmplt_date < to_date(?, 'yyyy-mm-dd') + 1
        and a.organization_code = 'M02'
        and a.department_code = ? ", [$request->input('start_date'), $request->input('end_date'), $request->input('department_code')]);
        // $header = PtpmAdditiveTransferH::find($id);
        // return response()->json([
        //     'header' => $header,
        //     'lines' => $header->lines()->get(),
        // ]);
        return response()->json(['rows' => $data]);
    }
}
