<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYearConfig extends Model
{
    protected $fillable = [
        'school_year_id',
        'department_id',
        'payment_mode_id'
    ];


    public function schoolYear()
    {
        return $this->belongsTo('App\Laravue\Models\SchoolYear');
    }
}
