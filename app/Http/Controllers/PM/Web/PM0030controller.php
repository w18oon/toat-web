<?php

namespace App\Http\Controllers\PM\Web;

use App\Models\PM\PtmesProductDistribution;
use App\Models\PM\PtmesProductHeader;
use App\Models\PM\PtmesProductLine;
use App\Models\PM\PtpmManufactureStep;
use Illuminate\Support\Facades\DB;

class PM0030controller extends BaseController
{
    public function index()
    {
        $headers = PtmesProductHeader::all();
        $lines = PtmesProductLine::all();
        $distributions = PtmesProductDistribution::all();
        $steps = PtpmManufactureStep::all();

        return $this->vue('pm-0030',[
            'headers' => $headers,
            'lines' => $lines,
            'distributions' => $distributions,
            'steps' => $steps,
        ]);
    }
}