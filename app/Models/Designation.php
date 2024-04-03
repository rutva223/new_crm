<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = [
        'name',
        'department',
        'created_by',
    ];

    public function departments()
    {
        return $this->hasOne('App\Models\Department', 'id', 'department');
    }
}
