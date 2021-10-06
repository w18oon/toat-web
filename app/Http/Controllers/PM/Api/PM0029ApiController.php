<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0029ApiController extends Controller
{
    public function show(Request $request)
    {
        if($request->input('display_lot_no')) {
            $query = "select flv1.lookup_code, msi.segment1, flv1.description, pt.tobacco_group, pt.subinventory_code,pt.locator_code, pt.lot_number, pt.onhand_quantity, pt.primary_uom_code, sr.min_qty ,sr.max_qty, pt.expiration_date, pt.origination_date, case when mln.hold_date < sysdate then 'Y' else 'N' end hold_date
            from toat.ptinv_onhand_quantities_v pt, apps.mtl_system_items_b msi, apps.mtl_lot_numbers mln, apps.fnd_lookup_values flv1, oapm.ptpm_storage_range sr
            where pt.inventory_item_id = msi.inventory_item_id
            and pt.organization_id = msi.organization_id
            and pt.inventory_item_id = mln.inventory_item_id
            and pt.organization_id = mln.organization_id
            and pt.lot_number = mln.lot_number
            and msi.item_type = flv1.lookup_code(+)
            and flv1.lookup_type = 'ITEM_TYPE'
            and pt.inventory_item_id = sr.inventory_item_id(+)
            and pt.organization_id = sr.organization_id(+)
            and pt.locator_id = sr.inventory_location_id(+)";

            if($request->input('segment1')) {
                $query .= " and msi.segment1 = '" . $request->input('segment1') . "'";
            }
    
            if($request->input('description')) {
                $query .= " and flv1.description = '" . $request->input('description') . "'";
            }
    
            if($request->input('tobacco_group')) {
                $query .= " and pt.tobacco_group = '" . $request->input('tobacco_group') . "'";
            }

            if($request->input('subinventory_code')) {
                $query .= " and pt.subinventory_code = '" . $request->input('subinventory_code') . "'";
            }
    
            if($request->input('locator_code')) {
                $query .= " and pt.locator_code = '" . $request->input('locator_code') . "'";
            }
            
            if($request->input('under_inv')) {
                $query .= " and sr.min_qty > pt.onhand_quantity";
            }

            if($request->input('close_to_exp')) {
                $query .= " and pt.expiration_date > trunc(sysdate) ";
            }

            if($request->input('hold')) {
                $query .= " and mln.hold_date = 'Y' ";
            }
        } else {
            $query = "select flv1.lookup_code, msi.segment1, flv1.description, nvl(pt.tobacco_group, '-') tobacco_group, pt.subinventory_code, pt.locator_code, sum(pt.onhand_quantity) onhand_quantity, pt.primary_uom_code, sr.min_qty, sr.max_qty
            from toat.ptinv_onhand_quantities_v pt, apps.mtl_system_items_b msi, apps.mtl_lot_numbers mln, apps.fnd_lookup_values flv1, oapm.ptpm_storage_range sr
            where pt.inventory_item_id = msi.inventory_item_id
            and pt.organization_id = msi.organization_id
            and pt.inventory_item_id = mln.inventory_item_id
            and pt.organization_id = mln.organization_id
            and pt.lot_number = mln.lot_number
            and msi.item_type = flv1.lookup_code(+)
            and flv1.lookup_type = 'ITEM_TYPE'
            and pt.inventory_item_id = sr.inventory_item_id(+)
            and pt.organization_id = sr.organization_id(+)
            and pt.locator_id = sr.inventory_location_id(+)";
    
            if($request->input('segment1')) {
                $query .= " and msi.segment1 = '" . $request->input('segment1') . "'";
            }
    
            if($request->input('description')) {
                $query .= " and flv1.description = '" . $request->input('description') . "'";
            }
    
            if($request->input('tobacco_group')) {
                $query .= " and pt.tobacco_group = '" . $request->input('tobacco_group') . "'";
            }

            if($request->input('subinventory_code')) {
                $query .= " and pt.subinventory_code = '" . $request->input('subinventory_code') . "'";
            }
    
            if($request->input('locator_code')) {
                $query .= " and pt.locator_code = '" . $request->input('locator_code') . "'";
            }

            if($request->input('under_inv')) {
                $query .= " and sr.min_qty > pt.onhand_quantity";
            }

            if($request->input('close_to_exp')) {
                $query .= " and pt.expiration_date > trunc(sysdate) ";
            }

            if($request->input('hold')) {
                $query .= " and mln.hold_date = 'Y' ";
            }
    
            $query .= " group by flv1.lookup_code, msi.segment1, flv1.description, pt.tobacco_group, pt.subinventory_code,pt.locator_code, pt.primary_uom_code, sr.min_qty, sr.max_qty";
        }

        return response()->json(DB::select($query));
    }
}
