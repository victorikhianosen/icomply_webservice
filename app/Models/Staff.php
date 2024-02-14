<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    
    protected $table = 'test_am_staffs';

    protected $fillable = [
        'id',
        'staff_name',
        'department',
        'email',
        'dept_email',
        'staff_id',
        'user_id',
        'os_user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department');
    }
    public function cases()
    {
        return $this->hasMany(CaseManagement2::class);
    }
}
