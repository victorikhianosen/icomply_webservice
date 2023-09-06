<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessCategory extends Model
{
    use HasFactory;
    protected $table = 'process_category';
    protected $fillable = [
        'id',
        'name',
    ];

    public function process()
    {
        return $this->hasMany(Process::class);
    }

    public function exception_category()
    {
        return $this->belongsTo(ExceptionCategory::class, 'exception_category_id');
    }
}
