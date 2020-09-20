<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
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

    public function type()
    {
        return $this->hasMany('App\Laravue\Models\PaymentModeType');
    }
}
