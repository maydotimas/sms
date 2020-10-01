<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'parent_no',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'occupation',
        'office_address',
        'email',
        'mobile',
        'type',
        'created_at',
        'updated_at',
        'avatar',

    ];

    public function scopeSearch($query,$keyword){
        return $query->where('first_name','like',$keyword.'%')
            ->orWhere('last_name','like',$keyword.'%');
    }
}
