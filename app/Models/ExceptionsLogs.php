<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExceptionsLogs extends Model
{

    protected $table = 'exceptions_logs';
    public $timestamps = false;
    protected $fillable = [
        'response_note',
        'user_id',
        'status_id',
        'exception_process_id',
        'transaction_id',
        'cases_action',
        'team_id',
        'rating_id',
        'alert_id',
        'staff_id',
        'exception_log_id',
        'responses',
        'created_at',
        'title',
        'customer_id',
        'attachment',
        'attachment_last_updated',
        'attachment_filename',
        'attachment_charset',
        'event_date',
        'closed_date',
        'direct_supervisor',
        'group_head',
        'divisional_head',
        'closed_remarks',
        'cases_description',
        'exceptions_logs_id',
        'category_id',
        'rule_id',
        'process_id',
        'tran_id'
    ];
}
