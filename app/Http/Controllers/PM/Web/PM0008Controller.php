<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0008ApiController;
use Illuminate\Support\Facades\DB;

class PM0008Controller extends BaseController
{
    public function __construct(PM0008ApiController $api)
    {
        $this->api = $api;
    }
    /** @noinspection DuplicatedCode */
    public function index()
    {
        $query = "select flv1.lookup_code, msi.segment1,pt.item_desc, flv1.description, nvl(pt.tobacco_group, '-') tobacco_group, pt.subinventory_code,pt.locator_code, sum(pt.onhand_quantity) onhand_quantity, pt.primary_uom_code, sr.min_qty, sr.max_qty
        from toat.ptinv_onhand_quantities_v pt,apps.mtl_system_items_b msi, apps.mtl_lot_numbers mln, apps.fnd_lookup_values flv1, oapm.ptpm_storage_range sr
        where pt.inventory_item_id     = msi.inventory_item_id
        and pt.organization_id = msi.organization_id
        and pt.inventory_item_id = mln.inventory_item_id
        and pt.organization_id = mln.organization_id
        and pt.lot_number = mln.lot_number
        and msi.item_type = flv1.lookup_code(+)
        and flv1.lookup_type = 'ITEM_TYPE'
        and pt.inventory_item_id = sr.inventory_item_id(+)
        and pt.organization_id = sr.organization_id(+)
        and pt.locator_id = sr.inventory_location_id(+)
        group by flv1.lookup_code, msi.segment1,pt.item_desc , flv1.description, pt.tobacco_group, pt.subinventory_code,pt.locator_code, pt.primary_uom_code, sr.min_qty ,sr.max_qty";

        return $this->vue('pm0008', [
            'data' => DB::select($query)
        ]);
    }
}
