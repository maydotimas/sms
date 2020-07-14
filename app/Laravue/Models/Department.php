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

    public function scopeSearch($query,$keyword){
        return $query->where('name','like','%'.$keyword.'%')
            ->orWhere('description','like','%'.$keyword.'%');
    }
    public function gradeLevels()
    {
        return $this->hasMany('App\Laravue\Models\GradeLevel');
    }
}
