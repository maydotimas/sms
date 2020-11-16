<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'citymunCode',
        'citymunDesc',
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('provCode','like',$keyword)
            ->orWhere('citymunCode','like',$keyword.'%')
            ->orWhere('citymunDesc','like',$keyword.'%');
    }
}
