<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseManagement extends Model
{
    use HasFactory;
    protected $table = 'case_management';


    protected $fillable = [
        'id',
        'user_id',
        'case_status_id',
        'priority_level_id',
        'description',
        'supervisor_name',
        'reason_for_close',
        'narration',
        'mail_to'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assigned_user()
    {
        return $this->belongsTo(User::class, 'assigned_user');
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
        return $this->belongsTo(Alert::class,'alert_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
