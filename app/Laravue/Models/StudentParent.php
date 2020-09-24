<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
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

    ];
}
