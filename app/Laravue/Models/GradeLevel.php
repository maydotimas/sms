<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'department_id'
    ];

    public function department()
    {
        return $this->belongsTo('App\Laravue\Models\Department');
    }
}
