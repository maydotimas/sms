<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentModeType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'payment_mode_id',
        'percentage',
        'payable_in',
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('name','like','%'.$keyword.'%')
            ->orWhere('description','like','%'.$keyword.'%');
    }

    public function scopePaymentMode($query,$keyword){
        return $query->where('payment_mode_id','=',$keyword);
    }

    public function paymentMode()
    {
        return $this->belongsTo('App\Laravue\Models\PaymentMode');
    }
}
