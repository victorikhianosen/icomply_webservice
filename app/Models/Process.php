<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'process_id',
        'user_id',
        'second_line_owner',
        'first_line_owner',
        'frequency',
        'status',
        'branch_code',
        'alert_group_id',
        'narration'
    ];

    protected $casts = [
        'mail_to' => 'array',
    ];
    protected $table = 'process';

    public function process_category()
    {
        return $this->belongsTo(ProcessCategory::class,'process_id');
    }

    public function alert()
    {
        return $this->hasMany(Alert::class,'alert_id');
    }
}
