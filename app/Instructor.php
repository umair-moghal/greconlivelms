<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
	protected $table ='instructors';

	public function students()
	{
		return $this->belongsToMany(Student::class, 'instructor_student');
	}

	public function courses()
	{
		return $this->belongsToMany(Course::class, 'course_instructor');
	}
}
