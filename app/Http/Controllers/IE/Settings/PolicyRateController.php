<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\IE\PolicyRateStoreRequest;
use App\Http\Requests\IE\PolicyRateUpdateRequest;

use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\Policy;
use App\Models\IE\PolicyRate;
use App\Models\IE\Location;
use App\Models\IE\FNDListOfValues;
use App\Models\IE\Preference;
use App\Models\IE\Currency;
use App\Models\IE\MileageUnit;

class PolicyRateController extends Controller
{
    protected $orgId;
    protected $perPage = 20;

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

    public function index(Category $category, SubCategory $sub_category, Policy $policy)
    {
        $this->orgId = 81;
        $rates = PolicyRate::wherePolicyId($policy->policy_id)
                        // ->whereOrgId($this->orgId)
                        ->active()
                        ->orderBy('rate')
                        ->paginate($this->perPage);

        // LISTS FOR CREATE
        $positionLists = FNDListOfValues::select(\DB::raw("description || ' ('|| flex_value || ')' AS full_description"),'flex_value')->poLevel()->pluck('full_description','flex_value')->all();
        $locationLists = Location::accessibleOrg($this->orgId)->active()->pluck('name','location_id')->all();

        $baseCurrencyId = Preference::getBaseCurrency();

        $mileageUnitLists = MileageUnit::active()->pluck('code','mileage_unit_id')->all();
        $baseMileageUnit = Preference::getBaseMileageUnit();

        return view('ie.settings.policies.rates.index',
                        compact('rates',
                                'policy',
                                'category',
                                'sub_category',
                                'positionLists',
                                'locationLists',
                                'baseCurrencyId',
                                'mileageUnitLists',
                                'baseMileageUnit'));
    }

    public function store(PolicyRateStoreRequest $request,Category $category, SubCategory $sub_category, Policy $policy)
    {
        try {
            // CHECK DUPLICATE RATE
            $isDuplicate = $this->checkDuplicateRate($policy,$request);
            if($isDuplicate){
                return redirect()->route('ie.settings.policies.rates.index',[$category->category_id, $sub_category->sub_category_id, $policy->policy_id])->withErrors(['this rate is already created.']);
            }

            // INSERT TO TABLE
            $rate = new PolicyRate();
            // $rate->org_id = $this->orgId;
            $rate->category_id = $category->category_id;
            $rate->sub_category_id = $sub_category->sub_category_id;
            $rate->policy_id = $policy->policy_id;
            $rate->position_po_level = $request->position_po_level ? $request->position_po_level : null;
            $rate->location_id = $request->location_id ? $request->location_id : null;
            if($request->unlimit){
                $rate->unlimit = true;
                $rate->rate = null;
            }else{
                $rate->unlimit = false;
                $rate->rate = $request->rate;
            }
            $rate->currency_id = $request->currency_id;
            $rate->save();

        } catch (\Exception $e) {
            return redirect()->route('ie.settings.policies.rates.index',[$category->category_id, $sub_category->sub_category_id, $policy->policy_id])->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.policies.rates.index',[$category->category_id, $sub_category->sub_category_id, $policy->policy_id]);

    }

    public function edit(Category $category, SubCategory $sub_category, Policy $policy, $rateId)
    {
        $this->orgId = 81;
        $rate = PolicyRate::find($rateId);

        // LISTS FOR CREATE
        $positionLists = FNDListOfValues::select(\DB::raw("description || ' ('|| flex_value || ')' AS full_description"),'flex_value')->poLevel()->pluck('full_description','flex_value')->all();
        $locationLists = Location::accessibleOrg($this->orgId)->active()->pluck('name','location_id')->all();

        $baseCurrencyId = Preference::getBaseCurrency();

        $mileageUnitLists = MileageUnit::active()->pluck('code','mileage_unit_id')->all();
        $baseMileageUnit = Preference::getBaseMileageUnit();

        return view('ie.settings.policies.rates._modal_edit_form',
                        compact('rate',
                                'policy',
                                'category',
                                'sub_category',
                                'positionLists',
                                'locationLists',
                                'baseCurrencyId',
                                'mileageUnitLists',
                                'baseMileageUnit'));
    }

    public function update(PolicyRateUpdateRequest $request,Category $category, SubCategory $sub_category, Policy $policy, $rateId)
    {
        try {
            $rate = PolicyRate::find($rateId);
            // UPDATE TABLE PolicyRate
            if($request->unlimit){
                $rate->unlimit = true;
                $rate->rate = null;
            }else{
                $rate->unlimit = false;
                $rate->rate = $request->rate;
            }
            $rate->currency_id = $request->currency_id;
            $rate->save();

        } catch (\Exception $e) {
            return redirect()->route('ie.settings.policies.rates.index',[$category->category_id, $sub_category->sub_category_id, $policy->policy_id])->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.policies.rates.index',[$category->category_id, $sub_category->sub_category_id, $policy->policy_id]);
    }

    public function inactive(Request $request,Category $category, SubCategory $sub_category, Policy $policy, $rateId)
    {
        try {
            $rate = PolicyRate::find($rateId);
            $rate->active = !$rate->active;
            $rate->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }

    private function checkDuplicateRate($policy,$request)
    {
        $rates = PolicyRate::active()->wherePolicyId($policy->policy_id);
        if($request->position_po_level){
            $rates->where('position_po_level',$request->position_po_level);
        }else{
            $rates->whereNull('position_po_level');
        }
        if($request->location_id){
            $rates->whereLocationId($request->location_id);
        }else{
            $rates->whereNull('location_id');
        }
        // IF THIS RATE EXIST
        if($rates->count() > 0){
            return true;
        }
        return false;
    }
}
