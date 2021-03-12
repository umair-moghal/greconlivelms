<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SafetyTip extends Model
{
    protected $fillable=[
        'title',
        'description'
    ];
}
