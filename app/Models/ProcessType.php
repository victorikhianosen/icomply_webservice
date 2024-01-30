<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessType extends Model
{
    use HasFactory;
    protected $table = 'exception_process_type';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'category_id'
    ];

    public function process()
    {
        return $this->hasMany(Process::class);
    }

    public function exception_category()
    {
        return $this->belongsTo(ProcessCategory::class, 'exception_category_id');
    }
    public function cases()
    {
        return $this->hasMany(CaseManagement2::class);
    }
}
