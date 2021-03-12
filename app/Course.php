<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Course extends Model

{

	protected $table ='courses';

    protected $fillable = [

        'class_name', 'department', 'room_number', 'start_date', 'end_date', 'class_color', 'course_description', 'slug', 'clas_id'

    ];

    public function packages()

	{



		 return $this->hasMany('App\Package','course','id');

	}

	public function students()

	{

		return $this->belongsToMany(Student::class, 'course_student');

	}



	public function instructors()

	{

		return $this->belongsToMany(Instructor::class, 'course_instructor');

	}

}

