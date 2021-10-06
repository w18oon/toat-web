<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AA0000ApiControllerScaffold extends Controller
{
    public function getIndex(Request $request): JsonResponse
    {
        try {
            DB::connection()->enableQueryLog();


            DB::getQueryLog();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e
            ], 500);
        }


        return response()->json([
        ]);
    }
}
