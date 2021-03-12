<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table ='schools';
    protected $fillable = [
        'name', 'logo', 'owner_name', 'owner_address', 'address'];
    
    public function departments(){
        return $this->hasMany(Department::class, 'school_id', 'sch_u_id');
    }

    public function instructors()
		{
			return $this->belongsToMany(Instructor::class, 'instructor_school');
		}
}
