<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nv_DownloadStatus extends Model
{

    protected $table = 'nv_download_status';
    public $timestamps = false;
    protected $fillable = [
        'slug',
        'name',
        'description',
        'value_id',
        'created_at',
    ];
}
