<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    protected $fillable = [
        'student_id',
        'school_year_id',
        'enrollment_id',
        'payment_no',
        'payment_amount_due',
        'payment_amount',
        'payment_date',
        'payment_due',
        'remarks',
        'type',
        'status',
    ];

    public function scopePaid($query)
    {
        return $query->where('status', '=', '1');
    }

    public function student()
    {
        return $this->belongsTo('App\Laravue\Models\Student');
    }

    public function enrollment()
    {
        return $this->belongsTo('App\Laravue\Models\Enrollment');
    }

    public function schoolYear()
    {
        return $this->belongsTo('App\Laravue\Models\SchoolYear');
    }
}
