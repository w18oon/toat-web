<?php

namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PD\PtpdSimuAdditiveH;

class FlavorNoApiController extends Controller
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

    public function search(Request $request)
    {
        $simuAdditiveHs = PtpdSimuAdditiveH::query();

        return response()->json(['data' => $simuAdditiveHs->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $request->validate([
            'simu_formula_no' => 'required',
            'description' => 'required',
            'remark_formula' => 'required',
            // 'creation_date' => 'required|date',
            // 'last_update_date' => 'required|date',
            'created_by' => 'required',
        ]);

        $simuAdditiveH = new PtpdSimuAdditiveH;
        $simuAdditiveH->simu_formula_id = $request->get('simu_formula_id');
        $simuAdditiveH->simu_formula_no = $request->get('simu_formula_no');
        $simuAdditiveH->description = $request->get('description');
        $simuAdditiveH->remark_formula = $request->get('remark_formula');
        $simuAdditiveH->creation_date = $request->get('creation_date');
        $simuAdditiveH->last_update_date = $request->get('last_update_date');
        $simuAdditiveH->created_by = $request->get('created_by');
        $simuAdditiveH->simu_type = $request->get('simu_type');
        $simuAdditiveH->program_code = $request->get('program_code');
        $simuAdditiveH->created_by_id = $request->get('created_by_id');
        $simuAdditiveH->updated_by_id = $request->get('updated_by_id');
        $simuAdditiveH->deleted_by_id = $request->get('deleted_by_id');
        $simuAdditiveH->last_updated_by = $request->get('last_updated_by');
        $simuAdditiveH->save();

        return response()->json(['data' => $simuAdditiveH]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'simu_formula_no' => 'required',
            'description' => 'required',
            'remark_formula' => 'required',
            // 'creation_date' => 'required|date',
            // 'last_update_date' => 'required|date',
            'created_by' => 'required',
        ]);

        $simuAdditiveH = PtpdSimuAdditiveH::find($id);
        $simuAdditiveH->simu_formula_id = $request->get('simu_formula_id');
        $simuAdditiveH->simu_formula_no = $request->get('simu_formula_no');
        $simuAdditiveH->description = $request->get('description');
        $simuAdditiveH->remark_formula = $request->get('remark_formula');
        $simuAdditiveH->creation_date = $request->get('creation_date');
        $simuAdditiveH->last_update_date = $request->get('last_update_date');
        $simuAdditiveH->created_by = $request->get('created_by');
        $simuAdditiveH->simu_type = $request->get('simu_type');
        $simuAdditiveH->program_code = $request->get('program_code');
        $simuAdditiveH->created_by_id = $request->get('created_by_id');
        $simuAdditiveH->updated_by_id = $request->get('updated_by_id');
        $simuAdditiveH->deleted_by_id = $request->get('deleted_by_id');
        $simuAdditiveH->last_updated_by = $request->get('last_updated_by');
        $simuAdditiveH->save();

        return response()->json(['data' => $simuAdditiveH]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
