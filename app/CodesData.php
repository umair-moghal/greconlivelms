<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodesData extends Model
{
    protected $table ='students';

    protected $fillable = [

        's_u_id',  'alergy', 'phone', 'address', 'last_name', 'gender', 'record_no', 'grade_level', 'home_address', 'iep', 'parent_first_name', 'parent_last_name', 'relation', 'parent_email'

    ];
}
