<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseManagement2 extends Model
{
    use HasFactory;
    protected $table = 'case_management';
    public $timestamps = false;


    public $fillable = [

        'user_id',
        'case_status_id',
        'priority_level_id',
        'description',
        'case_action',
        'assigned_user',
        'exception_log_id',
        'process_categoryid',
        'exception_process_id',
        'department_id',
        'supervisor_1',
        'supervisor_2',
        'supervisor_3',
        'alert_id',
        'title',
        'event_date',
        'response_note',
        'attachment',
        'attachment_filename',
        'process_id',
        'responses',
        'case_id',
        'assigned_user_response',
        'created_at'

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'assigned_user');
    }

    public function assigned_user()
    {
        return $this->belongsTo(Staff::class, 'assigned_user');
    }

    public function priority()
    {
        return $this->belongsTo(PriorityLevel::class, 'priority_level_id');
    }

    public function status()
    {
        return $this->belongsTo(CaseStatus::class, 'case_status_id');
    }

    public function alert()
    {
        return $this->belongsTo(Alert::class, 'alert_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function process()
    {
        return $this->belongsTo(Department::class, 'exception_process_id');
    }

    public function process_type()
    {
        return $this->belongsTo(ProcessType::class, 'process_categoryid');
    }

    public function case_response()
    {
        return $this->hasMany(CaseResponse::class);
    }
}
