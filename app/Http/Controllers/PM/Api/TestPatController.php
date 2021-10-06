<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmIngredientRequestH;
use App\Models\PM\PtpmIngredientRequestL;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

//TODO remove
class TestPatController extends Controller
{

    public function get(): string
    {
//        $data = PtpmIngredientRequestL::query()
//            ->where('ingreq_header_id', 1)
//            ->with('ptpmItemNumberVLookup')
//            ->with('ptpmItemConvUomVLookup')
//            ->get();

        $class = "App\\Models\\Lookup\\PtpmMachineGroupsLookup";
        $data = $class::query()->take(20)->get();
//        $data = $class::query()->get();

//        foreach ($data as $row) {
//            unset($row['rn']);
//        }

        return $data;
    }
}
