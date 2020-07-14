<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'grade_level_id'
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('name','like','%'.$keyword.'%')
            ->orWhere('description','like','%'.$keyword.'%');
    }

    public function grade_level()
    {
        return $this->belongsTo('App\Laravue\Models\GradeLevel');
    }
}
