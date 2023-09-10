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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function first_owner()
    {
        return $this->belongsTo(User::class, 'first_owner_id');
    }

    public function second_owner()
    {
        return $this->belongsTo(User::class, 'second_owner_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_type_id');
    }
}
