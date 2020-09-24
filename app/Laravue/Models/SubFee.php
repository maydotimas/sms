<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class SubFee extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'fee_id',
        'tuition',
        'misc',
        'discount',
        'type',
    ];

    public function scopeSearch($query,$keyword){
        return $query->where('name','like','%'.$keyword.'%')
            ->orWhere('description','like','%'.$keyword.'%');
    }

    public function scopeFee($query,$keyword){
        return $query->where('fee_id','=',$keyword);
    }

    public function fee()
    {
        return $this->belongsTo('App\Laravue\Models\Fee');
    }
}
