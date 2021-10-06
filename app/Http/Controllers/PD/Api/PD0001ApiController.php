<?php

namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PD\PtpdSimuAdditiveH;
use App\Models\PD\PtpdSimuAdditiveL;
use App\Models\PD\PtpdMixProcess;
use App\Models\PD\PtpdInstruction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PD0001ApiController extends Controller
{
    const PROGRAM_CODE = 'PD0001';

    public function store(Request $request)
    {
        $header = [];
        $lines = [];
        $mixs = [];
        $instructions = [];

        $request_header = $request->input('header');

        if ($request->input('new_simu_formula_no') != '') {
            $header_from = PtpdSimuAdditiveH::find($request->input('simu_formula_id'));

            $header = PtpdSimuAdditiveH::create([
                'simu_formula_no' => $request->input('new_simu_formula_no'),
                'description' => $header_from->description,
                'remark_formula' => $header_from->remark_formula,
                'creation_date' => Carbon::now(),
                'created_by' => $request->input('user_id'),
                'last_update_date' => Carbon::now(),
                'last_updated_by' => $request->input('user_id'),
                'simu_type' => 'CASING',
                'program_code' => self::PROGRAM_CODE,
            ]);

            foreach($header_from->lines()->get() as $line_from) {
                $lines[] = $header->lines()->create([
                    'raw_material_id' => $line_from['raw_material_id'],
                    'raw_material_num' => $line_from['raw_material_num'],
                    'description' => $line_from['description'],
                    'actual_qty' => $line_from['actual_qty'],
                    'actual_uom' => $line_from['actual_uom'],
                    'actual_cost' => $line_from['actual_cost'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => self::PROGRAM_CODE,
                ]);
            }

            foreach($header_from->mixs()->get() as $mix_from) {
                $mixs[] = $header->mixs()->create([
                    'mix_no' => $mix_from['mix_no'],
                    'mix_desc' => $mix_from['mix_desc'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => 'PDP001',
                ]);
            }

            foreach($header_from->instructions()->get() as $instruction_from) {
                $instructions[] = $header->instructions()->create([
                    'instruction_no' => $instruction_from['instruction_no'],
                    'instruction_desc' => $instruction_from['instruction_desc'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => 'PDP001',
                ]);
            }
        } else {
            $header = PtpdSimuAdditiveH::create([
                'simu_formula_no' => $request_header['simu_formula_no'],
                'description' => $request_header['description'],
                'remark_formula' => $request_header['remark_formula'],
                'creation_date' => Carbon::now(),
                'last_update_date' => Carbon::now(),
                'created_by' => $request->input('user_id'),
                'last_updated_by' => $request->input('user_id'),
                'simu_type' => 'CASING',
                'program_code' => 'PDP001',
            ]);

            foreach($request->input('lines') as $line) {
                $lines[] = $header->lines()->create([
                    'raw_material_id' => $line['raw_material_id'],
                    'raw_material_num' => $line['raw_material_num'],
                    'description' => $line['description'],
                    'actual_qty' => $line['actual_qty'],
                    'actual_uom' => $line['actual_uom'],
                    'actual_cost' => $line['actual_cost'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => 'PDP001',
                ]);
            }

            $no = 1;
            foreach($request->input('mixs') as $mix) {
                $mixs[] = $header->mixs()->create([
                    'mix_no' => $no,
                    'mix_desc' => $mix['mix_desc'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => 'PDP001',
                ]);
                $no += 1;
            }


            $no = 1;
            foreach($request->input('instructions') as $instruction) {
                $instructions[] = $header->instructions()->create([
                    'instruction_no' => $no,
                    'instruction_desc' => $instruction['instruction_desc'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => 'PDP001',
                ]);

                $no += 1;
            }
        }

        $lines = DB::table('ptpd_simu_additive_l')
            ->join('ptpd_raw_mate_CASING_v', 'ptpd_raw_mate_CASING_v.item_code', '=', 'ptpd_simu_additive_l.raw_material_num')
            ->select('simu_formula_line_id', 'raw_material_id', 'raw_material_num', 'ptpd_simu_additive_l.description', 'actual_qty', 'actual_uom', 'actual_cost', 'ptpd_raw_mate_CASING_v.status', 'ptpd_raw_mate_CASING_v.price_per_unit', 'ptpd_raw_mate_CASING_v.uom')
            ->where('simu_formula_id', $header->simu_formula_id)
            ->get();

        $headers = PtpdSimuAdditiveH::where('simu_type', 'CASING')
                    ->selectRaw("simu_formula_id, simu_formula_no, description, remark_formula, to_char(creation_date, 'yyyy-mm-dd') creation_date, created_by, to_char(last_update_date, 'yyyy-mm-dd') last_update_date, last_updated_by")
                    ->orderBy('simu_formula_no')
                    ->get();

        $created_by = User::where('user_id', $header->created_by)->first()->name;

        return response()->json([
            'headers' => $headers,
            'header' => $header,
            'lines' => $lines,
            'mixs' => $mixs,
            'instructions' => $instructions,
            'histories' => [],
            'created_by' => $created_by
        ]);
    }

    public function show($id)
    {
        $header = PtpdSimuAdditiveH::where('simu_formula_id', $id)->first();

        $lines = DB::table('ptpd_simu_additive_l')
            ->join('ptpd_raw_mate_CASING_v', 'ptpd_raw_mate_CASING_v.item_code', '=', 'ptpd_simu_additive_l.raw_material_num')
            ->select('simu_formula_line_id', 'raw_material_id', 'raw_material_num', 'ptpd_simu_additive_l.description', 'actual_qty', 'actual_uom', 'actual_cost', 'ptpd_raw_mate_CASING_v.status', 'ptpd_raw_mate_CASING_v.price_per_unit', 'ptpd_raw_mate_CASING_v.uom')
            ->where('simu_formula_id', $id)
            ->get();

        $mixs = DB::table('ptpd_mix_process')
                    ->select('mix_id', 'mix_desc')
                    ->where('simu_formula_id', $id)
                    ->orderBy('mix_id')
                    ->get();

        $instructions = DB::table('ptpd_instruction')
                            ->select('instruction_id', 'instruction_desc')
                            ->where('simu_formula_id', $id)
                            ->orderBy('instruction_id')
                            ->get();

        $histories = DB::table('ptpd_simu_additive_history')
                        ->select('simu_for_history_id', 'edit_by', 'edit_date', 'edit_field', 'edit_no', 'old_data', 'new_data')
                        ->where('simu_formula_id', $id)
                        ->get();

        $created_by = User::where('user_id', $header->created_by)->first()->name;

        return response()->json([
            'created_by' => $created_by,
            'header' => $header,
            'lines' => $lines,
            'mixs' => $mixs,
            'instructions' => $instructions,
            'histories' => $histories,
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
        DB::beginTransaction();

        $request_header = $request->input('header');
        $header = PtpdSimuAdditiveH::find($id);
        $header->description = $request_header['description'];
        $header->remark_formula = $request_header['remark_formula'];
        $header->last_update_date = Carbon::now();
        $header->save();

        $lines = [];
        foreach($request->input('lines') as $line) {
            $lines[] = $header->lines()->updateOrCreate([
                'simu_formula_line_id' => isset($line['simu_formula_line_id']) ? $line['simu_formula_line_id']: '',
            ],
            [
                'raw_material_id' => $line['raw_material_id'],
                'raw_material_num' => $line['raw_material_num'],
                'description' => $line['description'],
                'actual_qty' => $line['actual_qty'],
                'actual_uom' => $line['actual_uom'],
                'actual_cost' => $line['actual_cost'],
                'created_by' => $request->input('user_id'),
                'last_updated_by' => $request->input('user_id'),
            ]);
        }

        $mixs = [];
        $no = 1;
        foreach($request->input('mixs') as $mix) {
            $mixs[] = $header->mixs()->updateOrCreate([
                'mix_no' => $no,
            ],[
                'mix_desc' => $mix['mix_desc'],
                'created_by' => $request->input('user_id'),
                'last_updated_by' => $request->input('user_id'),
            ]);
            $no += 1;
        }

        $instructions = [];
        $no = 1;
        foreach($request->input('instructions') as $instruction) {
            $instructions[] = $header->instructions()->updateOrCreate([
                'instruction_no' => $no,
            ],[
                'instruction_desc' => $instruction['instruction_desc'],
                'created_by' => $request->input('user_id'),
                'last_updated_by' => $request->input('user_id'),
            ]);
            $no += 1;
        }

        DB::commit();

        $headers = PtpdSimuAdditiveH::where('simu_type', 'CASING')
                    ->selectRaw("simu_formula_id, simu_formula_no, description, remark_formula, to_char(creation_date, 'yyyy-mm-dd') creation_date, created_by, to_char(last_update_date, 'yyyy-mm-dd') last_update_date, last_updated_by")
                    ->orderBy('simu_formula_no')
                    ->get();
        
        $lines = DB::table('ptpd_simu_additive_l')
                    ->join('ptpd_raw_mate_CASING_v', 'ptpd_raw_mate_CASING_v.item_code', '=', 'ptpd_simu_additive_l.raw_material_num')
                    ->select('simu_formula_line_id', 'raw_material_id', 'raw_material_num', 'ptpd_simu_additive_l.description', 'actual_qty', 'actual_uom', 'actual_cost', 'ptpd_raw_mate_CASING_v.status', 'ptpd_raw_mate_CASING_v.price_per_unit', 'ptpd_raw_mate_CASING_v.uom')
                    ->where('simu_formula_id', $header->simu_formula_id)
                    ->get();
        
        $created_by = User::where('user_id', $header->created_by)->first()->name;

        return response()->json([
            'created_by' => $created_by,
            'headers' => $headers,
            'header' => $header,
            'lines' => $lines,
            'mixs' => $mixs,
            'instructions' => $instructions,
            'histories' => $header->history()->get(),
        ]);
    }

    public function remove_lines(Request $request)
    {
        DB::beginTransaction();
        if($request->input('data_type') === 'lines') {
            foreach($request->input('id') as $id) {
                $line = PtpdSimuAdditiveL::find($id);
                if($line) {
                    $line->delete();
                }
            }
        }
        if($request->input('data_type') === 'mixs') {
            foreach($request->input('id') as $id) {
                $mix = PtpdMixProcess::find($id);
                if($mix) {
                    $mix->delete();
                }
            }
        }
        if($request->input('data_type') === 'instructions') {
            foreach($request->input('id') as $id) {
                $instruction = PtpdInstruction::find($id);
                if($instruction) {
                    $instruction->delete();
                }
            }
        }
        DB::commit();
        return response()->json();
    }
}
