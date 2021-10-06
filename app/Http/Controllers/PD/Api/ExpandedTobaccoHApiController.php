<?php

namespace App\Http\Controllers\PD\Api;

use App\Models\PD\PtpdExpandedTobaccoH;
use App\Models\PD\PtpdExpandedTobaccoL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpandedTobaccoHApiController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $header = PtpdExpandedTobaccoH::create([
                'description' => $request->input('description'),
                'inventory_item_code' => $request->input('inventoryItemCode'),
                'inventory_item_id' => $request->input('inventoryItemId'),
                'remark' => $request->input('remark'),
            ]);

            foreach ($request->input('lines') as $line) {
                $lines[] = $header->lines()->create([
                    // 'inventory_item_code' => $line['inventoryItemCode'],
                    // 'inventory_item_id' => $line['inventoryItemId'],
                    // 'item_ratio' => $line['itemRatio'],
                    // 'lot_number' => $line['lotNumber'],
                    'inventory_item_code' => $line['inventory_item_code'],
                    'inventory_item_id' => $line['inventory_item_id'],
                    'item_ratio' => $line['item_ratio'],
                    'lot_number' => $line['lot_number'],
                ]);
            }

            DB::commit();

            $headers = PtpdExpandedTobaccoH::get();

            return response()->json([
                'header' => $header,
                'headers' => $headers,
                'lines' => $lines,
                'histories' => [],
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function show($id)
    {
        $header = PtpdExpandedTobaccoH::find($id);
        $lines = $header->lines()->get();
        $histories = $header->history()->get();

        return response()->json([
            'header' => $header,
            'lines' => $lines,
            'histories' => $histories,
        ]);
    }

    public function search(Request $request)
    {
        $headerBuilder = PtpdExpandedTobaccoH::query();
        if ($inventory_item_code = $request->get('inventory_item_code', null)) {
            $headerBuilder->where('inventory_item_code', 'like', "%$inventory_item_code%");
        }
        if ($description = $request->get('description', null)) {
            $headerBuilder->where('description', 'like', "%$description%");
        }
        $headers = $headerBuilder->get();

        return response()->json([
            'headers' => $headers,
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $header = PtpdExpandedTobaccoH::find($id);
            $header->inventory_item_code = $request->input('inventoryItemCode');
            $header->inventory_item_id = $request->input('inventoryItemId');
            $header->remark = $request->input('remark');
            $header->save();

            foreach ($request->input('lines') as $line) {
                $lines[] = $header->lines()->updateOrCreate([
                    'exp_tobacco_line_id' => isset($line['exp_tobacco_line_id']) ? $line['exp_tobacco_line_id'] : '',
                ], [
                    // 'inventory_item_code' => $line['inventoryItemCode'],
                    // 'inventory_item_id' => $line['inventoryItemId'],
                    // 'item_ratio' => $line['itemRatio'],
                    // 'lot_number' => $line['lotNumber'],
                    'inventory_item_code' => $line['inventory_item_code'],
                    'inventory_item_id' => $line['inventory_item_id'],
                    'item_ratio' => $line['item_ratio'],
                    'lot_number' => $line['lot_number'],
                ]);
            }

            $histories = $header->history()->get();

            DB::commit();

            $headers = PtpdExpandedTobaccoH::get();

            return response()->json([
                'header' => $header,
                'headers' => $headers,
                'lines' => $lines,
                'histories' => $histories,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $header = PtpdExpandedTobaccoH::find($id);

            foreach ($request->input('lines') as $line) {
                $header->lines()->find($line)->delete();
            }

            $lines = $header->lines()->get();

            $histories = $header->history()->get();

            DB::commit();

            return response()->json([
                'header' => $header,
                'lines' => $lines,
                'histories' => $histories,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
