<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseManagement extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'cases_table';

    protected $fillable = [
        'response_note',
        'user_id',
        'status_id',
        'exception_process_id',
        'cases_description',
        'cases_action',
        'status_id',
        'team_id',
        'mail_to',
        'alert_id',
        'staff_id',
        'exception_log_id',
        'responses',
        'created_at',
        'title'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function rating()
    {
        return $this->belongsTo(PriorityLevel::class, 'rating_id');
    }

    public function status()
    {
        return $this->belongsTo(CaseStatus::class, 'case_status_id');
    }

    public function alert()
    {
        return $this->belongsTo(Alert::class, 'alert_id');
    }
}
