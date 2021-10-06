<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VAT extends Model
{
    use HasFactory;
    protected $table = "PTIE_TAXS_V";

    public function scopeApVat($query)
    {
        // return $query->whereIn('tax_rate_code',['PVAT-G7']);
    }
}
