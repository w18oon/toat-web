<?php

namespace App\Http\Controllers\PM\Web;

use App\Models\PM\PtmesProductDistribution;
use App\Models\PM\PtmesProductHeader;
use App\Models\PM\PtmesProductLine;
use App\Models\PM\PtpmManufactureStep;

class PM0025controller extends BaseController
{
    public function index()
    {
        $headers = PtmesProductHeader::all();
        $lines = PtmesProductLine::all();
        $distributions = PtmesProductDistribution::all();
        $steps = PtpmManufactureStep::select ('lookup_code', 'meaning')->get();

        return $this->vue('pm0025',[
            'headers' => $headers,
            'lines' => $lines,
            'distributions' => $distributions,
            'steps' => $steps,
        ]);
    }
}