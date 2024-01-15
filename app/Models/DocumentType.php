<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;
    protected $table = 'ctl_document_type';

    public function document()
    {
        return $this->hasMany(Document::class, 'document_type_id');
    }
}
