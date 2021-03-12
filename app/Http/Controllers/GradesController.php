<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;



class GradesController extends Controller

{
	public function setgrades($id)
	{
		// $grades = DB::table('grades')->where('set_by', Auth::user()->id)->get()->all();
		return view('grades.setgrades', compact('id'));
	}

	public function savegrades(Request $request)
	{
		$this->validate($request, [

            'from' => 'required',

            'to' => 'required',

            'grade' => 'required',

        ]);
        $grades = array(
                    'marks_from' => $request->from,
                    'marks_to' => $request->to,
                    'grade' => $request->grade,
                    'course_id' => $request->course_id,
                );
        $grd = DB::table('grades')->where([
            'marks_from' => $request->from,
            'marks_to' => $request->to,
            'grade' => $request->grade
            ])->orWhere('grade', $request->grade)->orWhere([
            'marks_from' => $request->from,
            'marks_to' => $request->to
            ])->get()->first();
        if($grd == null)
        {
        	$success = DB::table('grades')->insert($grades);
			if($success){
	            Session::flash('message', 'Grades created successfully');
	            return redirect()->back();
	        }else{
	            Session::flash('message', 'Something went wrong');
	            return redirect()->back();
	        }
        }
        else
        {
        	Session::flash('message', 'This grade already exist');
	        return redirect()->back();
        }

	}

	public function editgrades($id)
	{
		$grade = DB::table('grades')->where('id', $id)->get()->first();
		return view('grades.edit', compact('grade'));
	}

	public function updategrades(Request $request)
	{
		DB::table('grades')->where('id', $request->id)->update([
            'marks_from' => $request->input('from'),
            'marks_to' => $request->input('to'),
            'grade' => $request->input('grade'),
        ]);
        
            Session::flash('message', 'Course Grade Updated successfully');
            return redirect()->back();

	}

	public function destroy(Request $request)
	{
		$id = $request->id;

        DB::table('grades')->where('id',$id)->delete();

        Session::flash('message', 'Grade deleted successfully');
	}

}

