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

    public function scopeSearch($query,$keyword){
        return $query->where('name','like','%'.$keyword.'%')
            ->orWhere('description','like','%'.$keyword.'%');
    }

    public function department()
    {
        return $this->belongsTo('App\Laravue\Models\Department');
    }
    public function reservation()
    {
        return $this->hasMany('App\Laravue\Models\Reservation');
    }
}
