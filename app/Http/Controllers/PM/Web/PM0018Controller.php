<?php

namespace App\Http\Controllers\PM\Web;

use App\Models\Lookup\PtBiweeklyLookup;

class PM0018Controller extends BaseController
{
    public function index()
    {
        $lookups = PtBiweeklyLookup::select('thai_year', 'thai_month', 'period_num', 'biweekly', 'start_date', 'end_date')->orderBy('thai_year', 'asc')->orderBy('period_num', 'asc')->orderBy('biweekly', 'asc')->get();
        return $this->vue('pm0018', [
            'lookups' => $lookups,
            'department_code' => auth()->user()->department_code,
        ]);
    }
}
