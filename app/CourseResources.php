<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseResources extends Model
{
    //
    protected $table ='resources';
    
	protected $fillable =['course_id','title','short_description','type', 'day'];
}
