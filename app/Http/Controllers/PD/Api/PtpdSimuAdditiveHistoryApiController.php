<?php

namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use App\Models\PD\PtpdSimuAdditiveH;

class PtpdSimuAdditiveHistoryApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $header = PtpdSimuAdditiveH::find($id);
        $histories = $header->history()
            ->select('simu_for_history_id as id', 'edit_by', 'edit_field', 'edit_no', 'old_data', 'new_data')
            ->orderBy('edit_field')
            ->orderBy('edit_no')
            ->get();
        return response()->json(['histories' => $histories]); 
    }
}
