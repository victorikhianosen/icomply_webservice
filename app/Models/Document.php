<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'department';

    protected $fillable = [
        'name',
        'filename',
        'created_at',
        'approver_id',
        'status',
        'description',
        'process_id',
        'first_owner_id',
        'second_owner_id',
    ];
}
