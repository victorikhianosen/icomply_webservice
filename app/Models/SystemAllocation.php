<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemAllocation extends Model
{
    use HasFactory;
    protected $table = 'system_allocation';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function system()
    {
        return $this->belongsTo(System::class, 'system_id');
    }

    public function system_cat()
    {
        return $this->belongsTo(User::class, 'category_id');
    }
}
