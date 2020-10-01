<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'provCode',
        'provDesc',
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('provDesc','like',$keyword.'%');
    }
}
