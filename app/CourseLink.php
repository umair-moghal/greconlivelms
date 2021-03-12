<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseLink extends Model
{
    //
    protected $table ='courselink';
    
	protected $fillable =['course_id','title','short_description','link'];
}
