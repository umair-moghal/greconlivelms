<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable=[
        'name'
    ];

    public function school(){
        return $this->belongsTo(School::class);
    }
}
