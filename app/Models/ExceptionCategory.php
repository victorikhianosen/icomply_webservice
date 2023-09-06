<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExceptionCategory extends Model
{
    use HasFactory;
    protected $table = 'exception_category';

    public function process_category()
    {
        return $this->hasMany(ProcessCategory::class);
    }
}
