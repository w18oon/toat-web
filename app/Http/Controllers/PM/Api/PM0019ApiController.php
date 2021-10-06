<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PM\PtglCoaDeptCodeV;
use Illuminate\Http\Request;
use App\Models\PM\PtpmBiweeklyRequestHeaders;
use Illuminate\Support\Facades\DB;

class PM0019ApiController extends Controller
{
    public function index()
    {
        $header_id = '';
        $command = "DECLARE V_RESULT VARCHAR2 ( 255 );
        BEGIN
            :V_RESULT := APPS.PTPM_CREATE_REPORT_PKG.REQUEST_OUT ( P_SOURCE_TABLE => 'PTPM_BIWEEKLY_REQUEST_HEADERS', P_SOURCE_ID => 121, P_SOURCE_LINE_ID => 1279 );
        DBMS_OUTPUT.PUT_LINE ( 'V_RESULT => ' || V_RESULT );
        END;";
    
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare($command);
        $stmt->bindParam(':V_RESULT', $header_id, \PDO::PARAM_INT);
        $ret_code = $stmt->execute();
        dd($header_id);
    }

    public function store(Request $request)
    {
        $req_by = User::where('name', $request->input('request_by'))->first()->user_id;
        $dep_desc = PtglCoaDeptCodeV::where('department_code', $request->input('department_code'))->first()->description;

        $header = new PtpmBiweeklyRequestHeaders;
        $header->biweekly_id = $request->input('biweekly_id');
        $header->tobacco_group = $request->input('tobacco_group');
        $header->request_date = $request->input('request_date');
        $header->product_date_from = $request->input('product_date_from');
        $header->product_date_to = $request->input('product_date_to');
        $header->department_desc = $dep_desc;
        $header->department_code = $request->input('department_code');
        $header->request_by = $req_by;
        $header->send_date = $request->input('send_date');
        $header->save();

        $ret_code = '';

        if($header->bi_request_header_id) {
            $command = "DECLARE V_RESULT VARCHAR2 ( 255 );
            BEGIN
                    V_RESULT := APPS.PTPM_MICS_PKG.AUTO_BIWEEKLY_LINE ( P_BIWEEKLY_ID => $header->biweekly_id, P_TOBACCO_GROUP => $header->tobacco_group, P_BI_REQUEST_HEADER_ID => $header->bi_request_header_id );
            DBMS_OUTPUT.PUT_LINE ( 'V_RESULT => ' || V_RESULT );
            END;";
    
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($command);
            $ret_code = $stmt->execute();
        }

        $lines = $header->lines()->get();
        foreach($lines as $key => $line) {
            $request_qty = '';
            if($line->product_onhand - $line->total_qty < 0) {
                $request_qty = abs($line->product_onhand - $line->total_qty);
            }
            $lines[$key]->request_qty = $request_qty;
        }

        return response()->json(['header' => $header, 'lines' => $lines, 'ret_code' => $ret_code]);
    }

    public function update(Request $request, $id)
    {
        $req_header_id = [];
        $errors = [];

        $header = PtpmBiweeklyRequestHeaders::find($id);

        foreach($request->input('lines') as $line) {

            DB::beginTransaction();
            try {
                $header->lines()->updateOrCreate([
                    'bi_request_line_id' => $line['bi_request_line_id'],
                ],[
                    'request_qty' => $line['request_qty'],
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return $e;
            }

            if(in_array($line['bi_request_line_id'], $request->input('checked'))) {
                try {
                    $header_id = '';
                    $command = "DECLARE V_RESULT VARCHAR2 ( 255 );
                                BEGIN
                                    :V_RESULT := APPS.PTPM_CREATE_REPORT_PKG.REQUEST_OUT ( P_SOURCE_TABLE => 'PTPM_BIWEEKLY_REQUEST_HEADERS', P_SOURCE_ID => $line[bi_request_header_id], P_SOURCE_LINE_ID => $line[bi_request_line_id] );
                                -- DBMS_OUTPUT.PUT_LINE ( 'V_RESULT => ' || V_RESULT );
                                END;";
                
                    $pdo = DB::getPdo();
                    $stmt = $pdo->prepare($command);
                    $stmt->bindParam(':V_RESULT', $header_id, \PDO::PARAM_INT);
                    if($stmt->execute()) {
                        $req_header_id[] = $header_id;
                    }
                } catch (\Exception $e) {
                    $errors[] = $e;
                }
            }
        }

        return response()->json(['req_header_id' => array_unique($req_header_id), 'errors' => array_unique($errors)]);
    }
}
