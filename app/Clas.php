<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    protected $table ='classes';

    protected $fillable = [

        'name', 'icon_id'

        ];
}
