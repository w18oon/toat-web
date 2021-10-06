<?php

namespace App\Http\Controllers\IE\Settings;

use App\Models\IE\Location;
use App\Models\IE\AccessibleOrg;
use App\Models\IE\HrOperatingUnit;

use App\Http\Requests\IE\LocationStoreRequest;
use App\Http\Requests\IE\LocationUpdateRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
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
    public function index()
    {
        $locations = Location::orderBy('name')->paginate($this->perPage);
        $operatingUnits = HrOperatingUnit::all();

        return view('ie.settings.locations.index', compact('locations','operatingUnits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationStoreRequest $request)
    {
        $location = new Location();
        // $location->org_id = $this->orgId;
        $location->name = $request->name;
        $location->description = $request->description;
        $location->last_updated_by = -1;
        $location->created_by = -1;
        $location->save();

        // SAVE ACCESIBLE ORG
        foreach($request->accessible_orgs as $accessible_org_id){
            $accessibleOrg = new AccessibleOrg();
            $accessibleOrg->org_id = $accessible_org_id;
            $accessibleOrg->last_updated_by = -1;
            $accessibleOrg->created_by = -1;
            $location->accessibleOrgs()->save($accessibleOrg);
        }

        return redirect()->route('ie.settings.locations.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $location->accessible_orgs = $location->accessibleOrgs()->pluck('org_id')->all();
        $operatingUnits = HrOperatingUnit::all();

        return view('ie.settings.locations._modal_edit_form',compact('location','operatingUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LocationUpdateRequest $request, Location $location)
    {
        $location->name = $request->name;
        $location->description = $request->description;
        $location->active = $request->active ? true : false;
        $location->save();

        $oldAccessibleOrgs = $location->accessibleOrgs()->pluck('org_id')->all();
        if($request->accessible_orgs != $oldAccessibleOrgs){
            // DELETE OLD ACCESIBLE ORG
            foreach($location->accessibleOrgs as $accessibleOrg){
                $accessibleOrg->delete();
            }
            // SAVE NEW ACCESIBLE ORG
            foreach($request->accessible_orgs as $accessible_org_id){
                $accessibleOrg = new AccessibleOrg();
                $accessibleOrg->org_id = $accessible_org_id;
                $location->accessibleOrgs()->save($accessibleOrg);
            }
        }

        return redirect()->route('ie.settings.locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inactive(Request $request,$id)
    {
        try {
            $location = Location::find($id);
            $location->active = !$location->active;
            $location->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }
    //
}
