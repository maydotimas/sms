<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description'
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('name','like','%'.$keyword.'%')
            ->orWhere('description','like','%'.$keyword.'%');
    }

    public function subFee()
    {
        return $this->hasMany('App\Laravue\Models\SubFee');
    }
}
