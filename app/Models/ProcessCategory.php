<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessCategory extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'code',
        'description',
        'created_at',
    ];
    protected $table = 'exception_category';

    public function process_category()
    {
        return $this->hasMany(ProcessType::class);
    }

    public function cases()
    {
        return $this->hasMany(CaseManagement2::class);
    }
}
