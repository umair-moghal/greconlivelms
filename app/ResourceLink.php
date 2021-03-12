<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceLink extends Model
{
    protected $table ='resourcelink';
    
	protected $fillable =['course_id','title','short_description','link'];
}
