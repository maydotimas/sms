<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'lrn',
        'student_no',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'nickname',
        'handedness',
        'religion',
        'street',
        'brgy',
        'town',
        'province',
        'email',
        'mobile',
        'avatar',
        'gender',
        'birthdate',
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('first_name','like',$keyword.'%')
            ->orWhere('last_name','like',$keyword.'%');
    }
    public function scopeSearchStudent($query,$id,$birthdate){
        return $query->where('student_no','=',$id)
            ->where('birthdate','=',$birthdate);
    }
}
