<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $fillable = [
        'name',
        'year',
        'start_month',
        'end_month',
        'status'
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('name','like','%'.$keyword.'%');
    }

    public function scopeTable($query,$keyword){
        return $query->where('name','like','%'.$keyword.'%')
            ->orWhere();
    }

    public function schoolYearConfig()
    {
        return $this->hasMany('App\Laravue\Models\SchoolYearConfig');
    }
}
