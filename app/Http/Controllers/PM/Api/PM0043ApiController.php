<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\PM\PtpmAdditiveTransferH;
use App\Models\PM\PtpmAdditiveTransferL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0043ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $web_batch_no = date('YmdHis');
        $request_header = $request->input('header');
        $header = new PtpmAdditiveTransferH;
        $header->department_code = $request_header['department_code'];
        $header->department_desc = $request_header['department_desc'];
        $header->transfer_date = $request_header['transfer_date'];
        $header->status = $request->input('status');
        $header->subinventory_from = $request_header['subinventory_from'];
        $header->locator_id_from = $request_header['locator_id_from'];
        $header->locator_from = $request_header['locator_from'];
        $header->subinventory_to = $request_header['subinventory_to'];
        $header->locator_id_to = $request_header['locator_id_to'];
        $header->locator_to = $request_header['locator_to'];
        $header->program_id = $request_header['program_id'];
        $header->web_batch_no = $web_batch_no;
        $header->save();

        $header = PtpmAdditiveTransferH::find($header->additive_header_id);

        foreach($request->input('lines') as $line) {
            $header->lines()->create([
                'department_code' => $request_header['department_code'],
                'department_desc' => $request_header['department_desc'],
                'transfer_number' => $header->transfer_number,
                'organization_id' => $line['organization_id'],
                'inventory_item_id' => $line['inventory_item_id'],
                'item_code' => $line['item_code'],
                'item_description' => $line['item_description'],
                'lot_number' => $line['lot_number'],
                'onhand_qty' => $line['onhand_qty'],
                'qty' => $line['qty'],
                'uom' => $line['uom'],
                'origination_date' => $line['origination_date'],
                'expire_date' => $line['expire_date'],
                'program_code' => $header->program_id,
                'web_batch_no' => $header->web_batch_no,
            ]);
        }

        return response()->json([
            'headers' => PtpmAdditiveTransferH::orderBy('additive_header_id')->get(),
            'header' => $header,
            'lines' => $header->lines()->get(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $header = PtpmAdditiveTransferH::find($id);
        return response()->json([
            'headers' => PtpmAdditiveTransferH::orderBy('additive_header_id')->get(),
            'header' => $header,
            'lines' => $header->lines()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $web_batch_no = date('YmdHis');
        $err_msg = '';

        DB::beginTransaction();
        try {
            $request_header = $request->input('header');
            $header = PtpmAdditiveTransferH::find($id);
            if($request->input('status') == 'โอนเรียบร้อย') {
                $return_code = $this->call_pkg($header->department_code, $header->transfer_number);
                if($return_code) {
                    $header->status = $request->input('status');
                } else {
                    $h = PtpmAdditiveTransferH::find($id);
                    $err_msg = $h->record_status;
                }
            }
            if($request->input('status') == 'ยกเลิกการโอน') {
                $header->status = $request->input('status');
            }
            $header->transfer_date = $request_header['transfer_date'];
            $header->locator_id_from = $request_header['locator_id_from'];
            $header->locator_from = $request_header['locator_from'];
            $header->locator_id_to = $request_header['locator_id_to'];
            $header->locator_to = $request_header['locator_to'];
            $header->web_batch_no = $web_batch_no;
            $header->save();



            foreach($request->input('lines') as $line) {
                $header->lines()->updateOrCreate([
                    'additive_line_id' => isset($line['additive_line_id']) ? $line['additive_line_id']: '',
                ],
                [
                    'department_code' => $request_header['department_code'],
                    'department_desc' => $request_header['department_desc'],
                    'transfer_number' => $header->transfer_number,
                    'organization_id' => $line['organization_id'],
                    'inventory_item_id' => $line['inventory_item_id'],
                    'item_code' => $line['item_code'],
                    'item_description' => $line['item_description'],
                    'lot_number' => $line['lot_number'],
                    'onhand_qty' => $line['onhand_qty'],
                    'qty' => $line['qty'],
                    'uom' => $line['uom'],
                    'origination_date' => $line['origination_date'],
                    'expire_date' => $line['expire_date'],
                    'program_code' => $header->program_id,
                    'web_batch_no' => $header->web_batch_no,
                ]);
            }

            DB::commit();

            $header = PtpmAdditiveTransferH::find($id);

            return response()->json([
                'headers' => PtpmAdditiveTransferH::orderBy('additive_header_id')->get(),
                'header' => $header,
                'lines' => $header->lines()->get(),
                'err_msg' => $err_msg,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        foreach($request->input('id') as $id) {
            $line = PtpmAdditiveTransferL::find($id);
            if($line) {
                $line->delete();
            }
        }
        return response()->json(['id' => $request->input('id')]);
    }

    public function call_pkg($department_code, $transfer_number)
    {
        $command = "DECLARE v_result VARCHAR2 ( 1000 );
        BEGIN
                v_result := apps.PTPM_TRANSACTION_PKG.ADDITIVE ( p_department_code => '$department_code', p_transfer_number => '$transfer_number' );
        dbms_output.put_line ( 'Status : ' || v_result );
        END;";

        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($command);
        $ret_code = $stmt->execute();

        return $ret_code;
    }
}
