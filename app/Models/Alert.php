<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'user_id',
        'status_id',
        'exception_process_id',
        'alert_description',
        'alert_action',
        'alert_name',
        'team_id',
        'mail_to',
        'email',
        'rule_id',
        'alert_frequency_id'
    ];

    protected $table = 'alert';
    protected $casts = [
        'mail_to' => 'array'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function status()
    {
        return $this->belongsTo(CaseStatus::class, 'case_status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function exception_category()
    {
        return $this->belongsTo(ExceptionCategory::class, 'exception_category_id');
    }

    public function exception_status()
    {
        return $this->belongsTo(ExceptionProcessStatus::class, 'exception_process_status_id');
    }

    public function alert_group()
    {
        return $this->belongsTo(AlertGroup::class, 'alert_group_id');
    }
}
