<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PM0025ApiController extends Controller
{

    public function update(Request $request, $id)
    {
        $web_batch_no = date('YmdHis');
        $program_id = 'PM0025';

        $default_attributes = [
            'web_batch_no' => $web_batch_no,
            'program_id' => $program_id,
            'record_status' => 'UPDATE',
            'interface_status' => '',
            'last_updated_by' => Auth::id(),
            'last_update_date' => Carbon::now(),
        ];

        // return response()->json(['input' => $request->input()],200);

        DB::beginTransaction();
        try {
            // update header
            DB::table('ptmes_product_header')
                ->where('batch_id', $id)
                ->update($default_attributes);

            // update line
            foreach($request->input('lines') as $line) {
                DB::table('ptmes_product_line')
                ->where('batch_id', $id)
                ->where('wip_step', $line['wip_step'])
                ->whereRaw("trunc(product_date) = to_date(?, 'dd/mm/yyyy')", $line['product_date'])
                ->update(array_merge($default_attributes, [
                    'receive_wip' => $line['receive_wip'],
                    'product_qty' => $line['product_qty'],
                    'loss_qty' => $line['loss_qty'],
                    'transfer_qty' => $line['transfer_qty'],
                    'transfer_wip' => $line['transfer_wip'],
                ]));
            }

            // update distributions
            foreach($request->input('distributions') as $distribution) {
                DB::table('ptmes_product_distribution')
                ->where('batch_id', $id)
                ->where('wip_step', $distribution['wip_step'])
                ->where('machine_set', $distribution['machine_set'])
                ->whereRaw("trunc(product_date) = to_date(?, 'dd/mm/yyyy')", $distribution['product_date'])
                ->update(array_merge($default_attributes, [
                    'result_qty_01' => $distribution['result_qty_01'],
                    'result_qty_02' => $distribution['result_qty_02'],
                    'result_qty_03' => $distribution['result_qty_03'],
                    'result_qty_04' => $distribution['result_qty_04'],
                    'result_loss_qty' => $distribution['result_loss_qty'],
                    'sample_qty' => $distribution['sample_qty'],
                    'product_qty' => $distribution['product_qty'],
                ]));
            }

            DB::commit();
            return response()->json(null,200);
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
