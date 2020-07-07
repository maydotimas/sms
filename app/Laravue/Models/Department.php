<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function gradeLevels()
    {
        return $this->hasMany('App\Laravue\Models\GradeLevel');
    }
}
