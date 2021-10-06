<?php

namespace App\Http\Controllers\PM\Web;

use App\Models\Lookup\PtpmItemClassificationsVLookup;
use Illuminate\Support\Facades\DB;

class PM0019Controller extends BaseController
{
    public function index()
    {
        $lookups = DB::select("select a.period_year, a.period_name, b.thai_year, trim(b.thai_month) thai_month, a.biweekly, b.biweekly_id, to_char(b.start_date, 'YYYY-MM-DD') start_date, to_char(b.end_date, 'YYYY-MM-DD') end_date
        from oapm.ptpm_planning_job_headers a
        join pt_biweekly b
        on b.period_year = a.period_year
        and b.period_name = a.period_name
        and b.biweekly = a.biweekly");

        $items = PtpmItemClassificationsVLookup::select('item_classification_code', 'item_classification')->get();

        return $this->vue('pm0019', [
            'lookups' => $lookups,
            'items' => $items,
            'dep_code' => auth()->user()->department_code,
            'req_by' => auth()->user()->name,
        ]);
    }
}
