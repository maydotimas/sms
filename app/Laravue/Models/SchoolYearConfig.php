<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYearConfig extends Model
{
    protected $fillable = [
        'school_year_id',
        'department_id',
        'fees_id'
    ];


    public function schoolYear()
    {
        return $this->belongsTo('App\Laravue\Models\SchoolYear');
    }
    public function fees()
    {
        return $this->belongsTo('App\Laravue\Models\Fee');
    }
    public function department()
    {
        return $this->belongsTo('App\Laravue\Models\Department');
    }
}
