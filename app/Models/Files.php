<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;
    protected $table = 'files';
    protected $fillable = [
        'file_name',
        'file_link',
        'file_id',
        
    ];
    public function case()
    {
        return $this->hasMany(CaseManagement2::class, 'attachment');
    }
}
