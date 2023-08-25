<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    public function case()
    {
        return $this->belongsTo(CaseManagement::class);
    }

    public function status()
    {
        return $this->belongsTo(CaseStatus::class,'case_status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }
}
