<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramInfo extends Model
{
    use HasFactory;
    protected $table = "pt_programs_info";
    // public $primaryKey = 'program_code';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
}
