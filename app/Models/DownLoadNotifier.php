<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownLoadNotifier extends Model
{
    //
    use HasFactory;

    protected $table = 'download_notifier';
    public $timestamps = false;
    protected $fillable = [
        'ip_address',
        'temp_dir',
        'file_size',
        'download_status',
        'created_at',
    ];
}
