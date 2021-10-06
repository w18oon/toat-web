<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\IE\SubCategoryInfosStoreRequest;

use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\SubCategoryInfo;


class SubCategoryInfoController extends Controller
{
    protected $orgId;
    protected $perPage = 10;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // $this->orgId = \Auth::user()->org_id;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, SubCategory $sub_category)
    {

        $sub_category_infos = SubCategoryInfo::whereSubCategoryId($sub_category->sub_category_id)
                                ->active()->paginate($this->perPage);
        $listFormTypes = SubCategoryInfo::getlistFormTypes();

        return view('ie.settings.sub-categories.infos.index',
            compact('category',
                    'sub_category',
                    'sub_category_infos',
                    'listFormTypes'));
    }

    public function inputFormType(Category $category, SubCategory $sub_category, $formType)
    {
        return view('ie.settings.sub-categories.infos._input_form_value',
                            compact('formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryInfosStoreRequest $request, Category $category, SubCategory $sub_category)
    {
        try {

            $sub_category_info  = new SubCategoryInfo();
            // $sub_category_info->org_id = $this->orgId;
            $sub_category_info->category_id = $category->category_id;
            $sub_category_info->sub_category_id = $sub_category->sub_category_id;
            $sub_category_info->attribute_name  = $request->attribute_name;
            $sub_category_info->purpose = $request->purpose;
            $sub_category_info->form_type   = $request->form_type;
            $sub_category_info->form_value  = $request->form_value ? $this->composeFormValue($request->form_type,$request->form_value) : null;
            $sub_category_info->required = $request->required ? true : false ;
            $sub_category_info->last_updated_by = -1;
            $sub_category_info->created_by = -1;
            $sub_category_info->save();

        } catch (\Exception $e) {
            return redirect()->route('ie.settings.sub-categories.infos.index',[
                                    $category->category_id,
                                    $sub_category->sub_category_id
                                ])->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.sub-categories.infos.index',[
                                    $category->category_id,
                                    $sub_category->sub_category_id
                                ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, SubCategory $sub_category, $subCategoryInfoId)
    {
        $sub_category_info = SubCategoryInfo::find($subCategoryInfoId);
        $sub_category_info->form_value = $sub_category_info->form_value ? implode(', ', json_decode($sub_category_info->form_value)) : '';
        $listFormTypes = SubCategoryInfo::getlistFormTypes();
        $formType = $sub_category_info->form_type;

        return view('ie.settings.sub-categories.infos._modal_edit_form',
                        compact('category',
                                'sub_category',
                                'sub_category_info',
                                'listFormTypes',
                                'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryInfosStoreRequest $request, Category $category, SubCategory $sub_category, $subCategoryInfoId)
    {
        try {

            $sub_category_info = SubCategoryInfo::find($subCategoryInfoId);
            $sub_category_info->attribute_name  = $request->attribute_name;
            $sub_category_info->purpose = $request->purpose;
            $sub_category_info->form_type   = $request->form_type;
            $sub_category_info->form_value  = $request->form_value ? $this->composeFormValue($request->form_type,$request->form_value) : null;
            $sub_category_info->required = $request->required ? true : false ;
            $sub_category_info->last_updated_by = -1;
            $sub_category_info->save();

        } catch (\Exception $e) {
            return redirect()->route('ie.settings.sub-categories.infos.index',[
                                    $category->id,
                                    $sub_category->id
                                ])->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.sub-categories.infos.index',[
                                    $category->id,
                                    $sub_category->id
                                ]);
    }

    public function inactive(Request $request,Category $category, SubCategory $sub_category, $subCategoryInfoId)
    {
        try {
            $sub_category_info = SubCategoryInfo::find($subCategoryInfoId);
            $sub_category_info->active = !$sub_category_info->active;
            $sub_category_info->last_updated_by = -1;
            $sub_category_info->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }

    private function composeFormValue($form_type,$form_value)
    {
        if(!$form_value){ return ; }

        if($form_type == 'select'){
            return json_encode(array_map('trim',explode(',',$form_value )));
        }else if($form_type == 'date'){
            $arr = array_map('trim',explode(',',$form_value ));
            $data = \DateTime::createFromFormat(trans('date.format'), $arr[0])->format('Y-m-d');
            return json_encode([$data]);
        }else{
            $arr = array_map('trim',explode(',',$form_value ));
            $data = $arr[0];
            return json_encode([$data]);
        }
    }
}
