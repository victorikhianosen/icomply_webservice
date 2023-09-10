<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemCategory extends Model
{
    use HasFactory;
    protected $table = 'system_category';

    public function system()
    {
        return $this->hasMany(System::class,'category_id');
    }

}
