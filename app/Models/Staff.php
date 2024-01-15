<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    protected $table = 'staffs';

    // // INSERT INTO public.staffs(
    // id, staff_name, department, email, dept_email, staff_id, user_id, os_user)
    // VALUES (?, ?, ?, ?, ?, ?, ?, ?);
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department');
    }
}
