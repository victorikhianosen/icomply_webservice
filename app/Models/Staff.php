<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'email',
        
    ];
    protected $table = 'staff';

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }
}
