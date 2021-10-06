<?php

namespace App\Http\Controllers\PM\Api;

use App\Models\PM\PtmesProductHeader;
use App\Models\PM\PtmesProductLine;
use App\Models\PM\PtmesProductDistribution;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PM0030ApiController extends Controller
{
    public function update(Request $request, $id)
    {
        $web_batch_no = date('YmdHis');
        DB::beginTransaction();
        try {
            // update header
            PtmesProductHeader::where('batch_id', $id)
                ->update([
                    'web_batch_no' => $web_batch_no,
                    'program_id' => 'PM0030',
                    'last_updated_by' => Auth::id(),
                    'last_update_date' => Carbon::now(),
                ]);
            // update line
            foreach($request->input('lines') as $line) {
                PtmesProductLine::where('batch_id', $id)
                ->where('wip_step', $line['wip_step'])
                ->whereRaw("trunc(product_date) = to_date(?,'dd/mm/yyyy')", $line['product_date'])
                ->update([
                    'product_qty' => $line['product_qty'],
                    'loss_qty' => $line['loss_qty'],
                    'transfer_qty' => $line['transfer_qty'],
                    'transfer_wip' => $line['transfer_wip'],
                    'web_batch_no' => $web_batch_no,
                    'program_id' => 'PM0030',
                    'last_updated_by' => Auth::id(),
                    'last_update_date' => Carbon::now(),
                ]);
            }
            
            // update distributions
            foreach($request->input('distributions') as $distribution) {
                PtmesProductDistribution::where('batch_id', $id)
                ->where('wip_step', $distribution['wip_step'])
                ->whereRaw("trunc(product_date) = to_date(?,'dd/mm/yyyy')", $distribution['product_date'])
                ->update([
                    'result_qty_01' => $distribution['result_qty_01'],
                    'result_qty_02' => $distribution['result_qty_02'],
                    'result_qty_03' => $distribution['result_qty_03'],
                    'result_qty_04' => $distribution['result_qty_04'],
                    'result_loss_qty' => $distribution['result_loss_qty'],
                    'product_qty' => $distribution['product_qty'],
                    'web_batch_no' => $web_batch_no,
                    'program_id' => 'PM0030',
                    'last_updated_by' => Auth::id(),
                    'last_update_date' => Carbon::now(),
                ]);
            }
            DB::commit();
            // return response()->json(null,200);
            return response()->json([
                'line' => $request->input('line'),
                'distributions' => $request->input('distributions'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
