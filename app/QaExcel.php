<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QaExcel extends Model
{
    protected $table ='questions';

    protected $fillable = [

         'course_id', 'quiz_id',  'instructor_id', 'week', 'options', 'label', 'type'

    ];
}
