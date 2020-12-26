<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $fillable = [
        'name',
        'year',
        'start_month',
        'end_month',
        'status',
        'payment_mode_id'
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('name','like','%'.$keyword.'%');
    }
    public function scopeActive($query){
        return $query->where('status','=',1);
    }

    public function scopeTable($query,$keyword){
        return $query->where('name','like','%'.$keyword.'%')
            ->orWhere();
    }

    public function schoolYearConfig()
    {
        return $this->hasMany('App\Laravue\Models\SchoolYearConfig');
    }

    public function paymentMode()
    {
        return $this->belongsTo('App\Laravue\Models\PaymentMode');
    }
}
