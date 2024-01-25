<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriorityLevel extends Model
{
    use HasFactory;
    protected $table = 'nv_priority_level';

    public function cases()
    {
        return $this->hasMany(CaseManagement2::class);
    }
}
