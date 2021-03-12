<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsController extends Controller
{
	public function student_enrollment(){
		$students = null;
		if(auth()->user()->role_id == 3){
			$user_ids = DB::table('students')->where('school_id',auth()->user()->id)->get()->pluck('s_u_id');
			$students = DB::table('users')->whereIn('id',$user_ids)->get();
		}elseif(auth()->user()->role_id == 4){
			$courses_list = DB::table('courses')->where('ins_id',auth()->user()->id)->get()->pluck('id');

			$students_id = DB::table('course_students')->where('course_id',$courses_list)->get()->pluck('student_id');
			$students = DB::table('users')->whereIn('id',$students_id)->get();
		}
		return view('reports.students',compact('students'));
	}

	public function student_enrollment_post(Request $request){
		$students = null;
		if(auth()->user()->role_id == 3){
			$user_ids = DB::table('students')->where('school_id',auth()->user()->id)->get()->pluck('s_u_id');
			$students = DB::table('users')->whereIn('id',$user_ids)->get();
			if($request->student_name != null){
				$students = DB::table('users')->whereIn('id',$user_ids)->where('name','LIKE','%'.$request->student_name.'%')->get();
			}
			
		}elseif(auth()->user()->role_id == 4){
			$courses_list = DB::table('courses')->where('ins_id',auth()->user()->id)->pluck('id')->get();
			$students_id = DB::table('course_students')->where('course_id',$courses_list)->get()->pluck('student_id');
			$students = DB::table('users')->whereIn('id',$students_id)->get();
			if($request->student_name != null){
				$students = DB::table('users')->whereIn('id',$user_ids)->where('name','LIKE','%'.$request->student_name.'%')->get();
			}
		}

		


		foreach ($students as $key => $std) {
                  
                  $course = DB::table('course_students')->where('student_id',$std->id)->pluck('course_id')->first();
                  $course = DB::table('courses')->where('id',$course)->first();
                 
         			if($request->course != 'Select Course' && $course->id != $request->course){
         				unset($students[$key]);
         			}

		}
		if($request->course == 'Select Course'){
	    	$request->course = null;
	    }

		$course = $request->course;
	    $name = $request->student_name;
	    if(isset($request->highest)){
	    	$students = $students->sort();
	    }elseif(isset($request->loweset)){
	    	$students = $students->rsort();
	    }

		return view('reports.students',compact('students','course','name'));
	}

	public function students_count(){
		return view('reports.students_count');
	}

	public function percent_assignments_completed(){
		return view('reports.percent_assignments');
	}

	public function attendance(){
		return view('reports.attendance');
	}

	public function grade_point_average(){
		return view('reports.grade_point_average');
	}

	public function assignment_reporting(){
		return view('reports.assignment_reporting');
	}

	public function csv_student_enrollment()
    {
        return Excel::download(new StudentExport, 'student_enrollment.xlsx');
    }
}

class StudentExport implements FromCollection , WithHeadings
{

    public function collection()
    {
    	if(auth()->user()->role_id == 3){
			$user_ids = DB::table('students')->where('school_id',auth()->user()->id)->get()->pluck('s_u_id');
			$students = DB::table('users')->select('id', 'unique_id', 'name', 'email', 'created_at', 'contact', 'bio')->whereIn('id',$user_ids)->get();
			
			
		}elseif(auth()->user()->role_id == 4){
			$courses_list = DB::table('courses')->where('ins_id',auth()->user()->id)->get()->pluck('id');
			$students_id = DB::table('course_students')->where('course_id',$courses_list)->get()->pluck('student_id');
			$students = DB::table('users')->select('id', 'unique_id', 'name', 'email', 'created_at', 'contact', 'bio')->whereIn('id',$students_id)->get();
			
		}
        $data = $students;

        return $data->unique();

    }
    public function headings(): array
    {
        return [
            'Id',
            'Unique Id',
            'Name',
            'Email',
            'Created At',
            'Contact',
            'Bio',
        ];
    }

}