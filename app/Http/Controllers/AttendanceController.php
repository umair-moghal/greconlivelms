<?php

namespace App\Http\Controllers;

use App\Attendance;

use Excel;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function course_attendance(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        $attendance = Attendance::where('course_id',$request->course_id)
            ->get()
            ->groupBy('date');
        return response()->json($attendance,200);
    }

    public function student_course_attendance(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:students,id'
        ]);

        $attendance = Attendance::where([
            'course_id' => $request->course_id,
            'student_id' => $request->student_id
            ])
            ->get()
            ->groupBy('date');
        return response()->json($attendance,200);
        
    }

    public function student_attendnace()
    {

        $attendance = DB::table('attendance')->where('student_id', Auth::user()->id)->get();
        return view('attendance.student_attendance', compact('attendance'));   
    }



    public function show_attendance_to_student($id)
    {
        if(Auth::user()->role_id == '5')
        {
            $attendance = DB::table('attendance')->where('student_id', Auth::user()->id)->where('course_id', $id)->get()->all();
            return view('attendance.show_attendance', compact('attendance'));     
        }

        if(Auth::user()->role_id == '4')
        {
            $course = DB::table('courses')->where('id', $id)->get()->first();
            $class_students = DB::table('classes_students')->where('class_id', $course->clas_id)->get()->pluck('s_u_id')->toArray();
        
            $attendance = DB::table('attendance')->whereIn('student_id', $class_students)->get()->all();
            return view('attendance.show_attendance', compact('attendance', 'course'));     
        }
       
    }


    public function show_attendance_to_school()
    {
        $classes = DB::table('classes')->get()->all();
        return view('attendance.attendance_view_school',compact('classes'));
    }

    public function data($id)
    {
        $course = DB::table("courses")->where("clas_id",$id)->get();
        return response()->json($course);
    }

    public function course_data($id)
    {
        $course = DB::table('courses')->where('id', $id)->get()->first();
        $class_students = DB::table('classes_students')->where('class_id', $course->clas_id)->get()->pluck('s_u_id');
        $attendance = DB::table('attendance')->whereIn('student_id', $class_students)->get();
        foreach ($attendance as $atn) {
            $student = DB::table('users')->where('id', $atn->student_id)->get()->first();
            $atn->course = $course->course_name;
            $atn->student = $student->name;
        }
        // dd($attendance);
        return response()->json($attendance);
        // return response()->json(array(
        //     'course' => $course,
        //     'attendance' => $attendance,
        // ));
    }

    public function export()
    {
        return Excel::download(new CompanyExport, 'attendance.xlsx');
    }

    public function export_students()
    {
        return Excel::download(new StudentExport, 'attendance.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}


class StudentExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        $data = DB::table('attendance')->join('courses', 'courses.id', '=', 'attendance.course_id')->join('users', 'users.id', '=', 'attendance.student_id')->select('users.name', 'courses.course_name', 'attendance.lecture_id', 'attendance.date', 'attendance.time', 'attendance.status')->get();
        return $data->unique();
    }

    public function headings(): array
    {
        return [
            'Student Name',
            'Course Name', 
            'Lecture', 
            'Date', 
            'Time', 
            'Status',
        ];
    }
}




class CompanyExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        $data = DB::table('attendance')->join('courses', 'courses.id', '=', 'attendance.course_id')->select('courses.course_name', 'attendance.lecture_id', 'attendance.date', 'attendance.time', 'attendance.status')->get();
        return $data->unique();
    }

    public function headings(): array
    {
        return [
            'Course Name', 
            'Lecture', 
            'Date', 
            'Time', 
            'Status',
        ];
    }
}
