<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertGroup extends Model
{
    use HasFactory;
    
    protected $table = 'alert_group';

    public function alert()
    {
        return $this->hasMany(Alert::class);
    }
}
