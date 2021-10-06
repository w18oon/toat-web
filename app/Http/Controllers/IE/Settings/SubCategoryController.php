<?php

namespace App\Http\Controllers\IE\Settings;

use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\Policy;
use App\Models\IE\Preference;
use App\Models\IE\AccountInfo;
use App\Models\IE\FNDListOfValues;
use App\Models\IE\VAT;
use App\Models\IE\AccessibleOrg;
use App\Models\IE\HrOperatingUnit;

use App\Http\Requests\IE\SubCategoriesStoreRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $perPage = 10;
    protected $orgId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $this->orgId = \Auth::user()->org_id;
        //     return $next($request);
        // });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {

        $sub_categories = SubCategory::whereCategoryId($category->category_id)
                            // ->accessibleOrg($this->orgId)
                            ->paginate($this->perPage);
        $operatingUnits = HrOperatingUnit::all();

        return view('ie.settings.sub-categories.index',
            compact('category',
                    'sub_categories',
                    'operatingUnits'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        $defaultSubAccountCode = '';
        $accountLists = FNDListOfValues::select(\DB::raw("description || ' ('|| flex_value || ')' AS full_description"),'flex_value')->account($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $VATLists = VAT::apVat()->where('org_id',$this->orgId)->pluck('tax','tax_rate_code')->all();

        $branchLists = FNDListOfValues::select(\DB::raw("description || ' ('|| flex_value || ')' AS full_description"),'flex_value')->branch($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("description || ' ('|| flex_value || ')' AS full_description"),'flex_value')->department($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $operatingUnits = HrOperatingUnit::all();

        return view('ie.settings.sub-categories.create',
            compact('category',
                    'accountLists',
                    'VATLists',
                    'defaultSubAccountCode',
                    'branchLists',
                    'departmentLists',
                    'operatingUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoriesStoreRequest $request, Category $category)
    {

        $sub_category  = new SubCategory();
        // $sub_category->org_id = $this->orgId;
        $sub_category->category_id = $category->category_id;
        $sub_category->name = $request->name;
        $sub_category->description = $request->description;
        $sub_category->start_date = \DateTime::createFromFormat(trans('date.format'), $request->start_date)->format('Y-m-d');
        if($request->end_date){
            $sub_category->end_date = \DateTime::createFromFormat(trans('date.format'), $request->end_date)->format('Y-m-d');
        }else{
            $sub_category->end_date = null;
        }
        $sub_category->account_code = $request->account_code;
        $sub_category->sub_account_code = $request->sub_account_code;
        $sub_category->branch_code = $request->branch_code ? $request->branch_code : null;
        $sub_category->department_code = $request->department_code ? $request->department_code : null;
        $sub_category->vat_id = $request->vat_id;
        $sub_category->use_second_unit = $request->use_second_unit ? true : false ;
        if(!$request->use_second_unit){
            $sub_category->unit = $request->unit;
        }else{
            $sub_category->unit = $request->unit_1;
            $sub_category->second_unit = $request->unit_2;
        }
        $sub_category->required_attachment = $request->required_attachment ? true : false ;
        $sub_category->allow_exceed_policy = $request->allow_exceed_policy ? true : false ;
        $sub_category->active = $request->active ? true : false ;
        $sub_category->last_updated_by = -1;
        $sub_category->created_by = -1;
        $sub_category->save();

        // SAVE ACCESIBLE ORG
        foreach($request->accessible_orgs as $accessible_org_id){
            $accessibleOrg = new AccessibleOrg();
            $accessibleOrg->org_id = $accessible_org_id;
            $accessibleOrg->last_updated_by = -1;
            $accessibleOrg->created_by = -1;
            $sub_category->accessibleOrgs()->save($accessibleOrg);
        }

        ///////////////////////
        // AUTO CREATE POLICY
        $policy_expense = new Policy();
        // $policy_expense->org_id = 81;
        $policy_expense->category_id = $category->category_id;
        $policy_expense->sub_category_id = $sub_category->sub_category_id;
        $policy_expense->type = 'EXPENSE';
        $policy_expense->active = false;
        $policy_expense->created_by = -1;
        $policy_expense->last_updated_by = -1;
        $policy_expense->save();
        // AUTO CREATE MILEAGE POLICY
        $policy_mileage = new Policy();
        // $policy_mileage->org_id = 81;
        $policy_mileage->category_id = $category->category_id;
        $policy_mileage->sub_category_id = $sub_category->sub_category_id;
        $policy_mileage->type = 'MILEAGE';
        $policy_mileage->active = false;
        $policy_mileage->created_by = -1;
        $policy_mileage->last_updated_by = -1;
        $policy_mileage->mileage_unit = Preference::getBaseMileageUnit();
        $policy_mileage->save();

        return redirect()->route('ie.settings.sub-categories.index',[$category->category_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, SubCategory $sub_category)
    {
        $sub_category->accessible_orgs = $sub_category->accessibleOrgs()->pluck('org_id')->all();
        $accountLists = FNDListOfValues::select(\DB::raw("description || ' ('|| flex_value || ')' AS full_description"),'flex_value')->account($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $VATLists = VAT::apVat()->where('org_id',$this->orgId)->pluck('tax','tax_rate_code')->all();
        $sub_category->start_date = dateFormatDisplay($sub_category->start_date);
        $sub_category->end_date = dateFormatDisplay($sub_category->end_date);
        $sub_category->accessible_orgs = $sub_category->accessibleOrgs()->pluck('org_id')->all();

        $defaultSubAccountCode = $sub_category->sub_account_code;

        $branchLists = FNDListOfValues::select(\DB::raw("description || ' ('|| flex_value || ')' AS full_description"),'flex_value')->branch($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("description || ' ('|| flex_value || ')' AS full_description"),'flex_value')->department($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $operatingUnits = HrOperatingUnit::all();

        return view('ie.settings.sub-categories.edit',
            compact('category',
                    'sub_category',
                    'accountLists',
                    'VATLists',
                    'defaultSubAccountCode',
                    'branchLists',
                    'departmentLists',
                    'operatingUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoriesStoreRequest $request, Category $category, SubCategory $sub_category)
    {
        $sub_category->name = $request->name;
        $sub_category->description = $request->description;
        $sub_category->start_date = \DateTime::createFromFormat(trans('date.format'), $request->start_date)->format('Y-m-d');
        if($request->end_date){
            $sub_category->end_date = \DateTime::createFromFormat(trans('date.format'), $request->end_date)->format('Y-m-d');
        }else{
            $sub_category->end_date = null;
        }

        $sub_category->account_code = $request->account_code;
        $sub_category->sub_account_code = $request->sub_account_code;
        $sub_category->branch_code = $request->branch_code ? $request->branch_code : null;
        $sub_category->department_code = $request->department_code ? $request->department_code : null;
        $sub_category->vat_id = $request->vat_id;
        $sub_category->use_second_unit = $request->use_second_unit ? true : false ;
        if(!$request->use_second_unit){
            $sub_category->unit = $request->unit;
        }else{
            $sub_category->unit = $request->unit_1;
            $sub_category->second_unit = $request->unit_2;
        }
        $sub_category->required_attachment = $request->required_attachment ? true : false ;
        $sub_category->allow_exceed_policy = $request->allow_exceed_policy ? true : false ;
        $sub_category->active = $request->active ? true : false ;
        $sub_category->last_updated_by = -1;
        $sub_category->save();

        $oldAccessibleOrgs = $sub_category->accessibleOrgs()->pluck('org_id')->all();
        if($request->accessible_orgs != $oldAccessibleOrgs){
            // DELETE OLD ACCESIBLE ORG
            foreach($sub_category->accessibleOrgs as $accessibleOrg){
                $accessibleOrg->delete();
            }
            // SAVE NEW ACCESIBLE ORG
            foreach($request->accessible_orgs as $accessible_org_id){
                $accessibleOrg = new AccessibleOrg();
                $accessibleOrg->org_id = $accessible_org_id;
                $accessibleOrg->last_updated_by = -1;
                $accessibleOrg->created_by = -1;
                $sub_category->accessibleOrgs()->save($accessibleOrg);
            }
        }

        return redirect()->route('ie.settings.sub-categories.index',[$category->category_id]);
    }

    public function inputSubAccountCode(Request $request)
    {
        $accountInfo = AccountInfo::whereOrgId($this->orgId)
                        ->subAccount()
                        ->first();
        $accountCode = $request->account_code;
        $subAccountCode = $request->sub_account_code;
        $subAccountLists = [''=>'-'];
        if($accountCode){
            $subAccountLists = FNDListOfValues::select(\DB::raw("description || ' ('|| flex_value || ')' AS full_description"),'flex_value')->subAccount($this->orgId)->byParentValue($accountInfo->parent_flex_value_set_name,$accountCode)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        }
        return view('ie.settings.sub-categories._ddl_sub_account_code',
            compact('subAccountLists','subAccountCode'));
    }

}
