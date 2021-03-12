<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table ='students';
    protected $fillable = [
        'name', 'diabetes', 'alergy', 'phone', 'image', 'cnic', 'address', 'class', 'father_name', 'rollno'
    ];

    public function courses()
    {
    	return $this->belongsToMany(Course::class, 'course_student');
    }

    	public function instructors()
	{
		return $this->belongsToMany(Instructor::class, 'instructor_student');
	}
}
