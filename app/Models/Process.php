<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'process_id',
        'user_id',
        'second_owner_id',
        'first_owner_id',
        'frequency',
        'status',
        'branch_code',
        'alert_group_id',
        'narration',
        'approver_id'
    ];

   
    protected $table = 'exception_process';

    public function process_category()
    {
        return $this->belongsTo(ProcessType::class,'process_id');
    }

    public function alert()
    {
        return $this->hasMany(Alert::class,'alert_id');
    }
    public function cases()
    {
        return $this->hasMany(CaseManagement2::class);
    }
}
