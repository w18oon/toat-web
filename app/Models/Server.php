<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;
    protected $table = "ptw_servers";
    public $primaryKey = 'server_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
}
