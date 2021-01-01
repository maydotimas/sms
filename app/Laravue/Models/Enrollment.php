<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'school_year_id',
        'grade_level_id',
        'section_id',
        'student_type',
        'sub_fee_id',
        'payment_mode_type_id',
        'enrollment_amount',
        'payment_receipt',
        'enrollment_code',
        'status',
        'is_locked',
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
