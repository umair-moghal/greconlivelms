<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class greetings extends Model
{
    //
    protected $table ='greetings';
    
	protected $fillable =['title','description','image'];
}
