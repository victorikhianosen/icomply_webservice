<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nv_Download extends Model
{

    protected $table = 'nv_download';
    public $timestamps = false;
    protected $fillable = [
        'status',
        'name',
        'expiration_date',
        'download_link',
        'refernce_id',
        'created_at',
    ];

}
