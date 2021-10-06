<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $table = 'PTIE_CURRENCIES_V';

    public function scopeByOrgId($query, $orgId)
    {
        $query->select(\DB::raw('fsp.org_id,
                                gl.currency_code,
                                gl.chart_of_accounts_id'));
        $query->from(\DB::raw('financials_system_params_all fsp,
                             gl_ledgers gl'));
        $query->whereRaw('fsp.set_of_books_id = gl.ledger_id');
        $query->where('fsp.org_id',$orgId);

        return $query;
    }
}
