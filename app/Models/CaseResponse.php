<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseResponse extends Model
{
    use HasFactory;
    protected $table = 'case_management_response';

    public $fillable = [
        'case_management_response_id',
        'case_id',       
        'response',
        'created_at'
    ];

   

    public function cases()
    {
        return $this->belongsTo(CaseManagement2::class, 'case_id');
    }
}
