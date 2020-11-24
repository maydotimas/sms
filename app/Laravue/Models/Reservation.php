<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'student_id',
        'school_year_id',
        'grade_level_id',
        'section_id',
        'student_type',
        'reservation_amount',
        'payment_receipt',
        'reservation_code',
        'status',
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('id','=',$keyword);
    }

    public function scopeFilterSearch($query,$keyword,$sy){
        return $query->where('id','=',$keyword)
            ->orWhere('school_year_id','=',$sy);
    }

    public function student()
    {
        return $this->belongsTo('App\Laravue\Models\Student');
    }
    public function schoolYear()
    {
        return $this->belongsTo('App\Laravue\Models\SchoolYear');
    }
    public function gradeLevel()
    {
        return $this->belongsTo('App\Laravue\Models\GradeLevel');
    }
    public function section()
    {
        return $this->belongsTo('App\Laravue\Models\Section');
    }
}
