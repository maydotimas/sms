<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $fillable = [
        'cityCode',
        'brgyCode',
        'brgyDesc',
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('cityCode','like',$keyword.'%');
    }
}
