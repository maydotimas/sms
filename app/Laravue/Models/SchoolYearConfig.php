<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYearConfig extends Model
{
    protected $fillable = [
        'school_year_id',
        'department_id',
        'fee_id',
        'payment_mode_id'
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('id','=',$keyword);
    }

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
