<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\IE\PolicyStoreRequest;

use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\Policy;
use App\Models\IE\PolicyRate;
use App\Models\IE\Preference;
use App\Models\IE\Currency;
use App\Models\IE\MileageUnit;

class PolicyController extends Controller
{
    protected $orgId;

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

    //
    public function index(Category $category, SubCategory $sub_category)
    {
        // $policies = Policy::whereSubCategoryId($sub_category->id)->active()->get();
        $policy_expense = Policy::whereSubCategoryId($sub_category->sub_category_id)->where('type','EXPENSE')->active()->first();
        $policy_mileage = Policy::whereSubCategoryId($sub_category->sub_category_id)->where('type','MILEAGE')->active()->first();
        return view('ie.settings.policies.index',
                        compact('policy_expense',
                                'policy_mileage',
                                'category',
                                'sub_category'));
    }

    public function create(Request $request, Category $category, SubCategory $sub_category)
    {
        // get preference currency
        $baseCurrencyId = Preference::getBaseCurrency();

        $mileageUnitLists = MileageUnit::active()->pluck('code', 'mileage_unit_id')->all();
        $baseMileageUnit = Preference::getBaseMileageUnit();

        $type = $request->type;
        return view('ie.settings.policies._modal_use_policy_form',
                                compact('type',
                                        'category',
                                        'sub_category',
                                        'baseCurrencyId',
                                        'mileageUnitLists',
                                        'baseMileageUnit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PolicyStoreRequest $request,Category $category, SubCategory $sub_category)
    {
        try {
            $policy  = Policy::firstOrNew(
                            [
                             'category_id' => $category->category_id,
                             'sub_category_id' => $sub_category->sub_category_id,
                             'type' => $request->type]);
            if($request->type == 'MILEAGE'){
                $policy->mileage_unit = $request->mileage_unit;
            }
            $policy->last_updated_by = -1;
            $policy->created_by = -1;
            $policy->active = true;
            if($policy->save()){
                // ###################################
                // ## Default Rate ( for any case ) ##
                // ###################################
                $rate = PolicyRate::firstOrNew(
                            [
                             'category_id' => $category->category_id,
                             'sub_category_id' => $sub_category->sub_category_id,
                             'policy_id' => $policy->policy_id,
                             'last_updated_by' => -1,
                             'created_by' => -1,
                             'position_po_level' => null, // null = any
                             'location_id' => null]); // null = any
                if($request->unlimit){
                    $rate->unlimit = true;
                    $rate->rate = null;
                }else{
                    $rate->unlimit = false;
                    $rate->rate = $request->rate;
                }
                $rate->currency_id = $request->currency_id;
                $rate->save();
            }

        } catch (\Exception $e) {
            return redirect()->route('ie.settings.policies.index',[
                                    $category->category_id,
                                    $sub_category->sub_category_id
                                ])->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.policies.index',[
                                    $category->category_id,
                                    $sub_category->sub_category_id
                                ]);
    }

    public function inactive(Request $request,Category $category, SubCategory $sub_category, $policyId)
    {
        try {
            $policy = Policy::find($policyId);
            $policy->active = !$policy->active;
            $policy->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }
}
