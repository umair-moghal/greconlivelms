<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Course_available_grades_percentage;


use DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Session;



class CoursegradesController extends Controller

{

    public function index(){
       
           $user = Auth::user()->id;
           
           if(auth()->user()->role_id == 1){
                      $school_id = 0;
                  }elseif (auth()->user()->role_id == 3) {
                      $school_id = DB::table('schools')->where('sch_u_id',auth()->user()->id)->pluck('id')->first();
                  }
                  elseif (auth()->user()->role_id == 4) {
                     $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();
                  }
              
         
        if(auth()->user()->role_id == '3'){ 
                $user = Auth::user();
                $coursegrades = DB::table('course_available_grades_percentages')->where('school_id' , $school_id)->orderBy('id', 'desc')->get();
                
        }

         if(auth()->user()->role_id == '4'){ 
                $user = Auth::user();
                $coursegrades = DB::table('course_available_grades_percentages')->where('school_id' , $school_id)->orderBy('id', 'desc')->get();
                
        }

        if(auth()->user()->role_id == '5'){ 
            $user = Auth::user();
            $coursegrades = DB::table('course_available_grades_percentages')->where('school_id' , $school_id)->orderBy('id', 'desc')->get();
            
    }
        
      
        return view ('coursegrades.index', compact( 'coursegrades'));

    }

  
    public function create(){
           $user = Auth::user()->id;
            $assigned_permissions =array();
            

        $user = Auth::user();

    	return view ('coursegrades.create', compact('user'));

    }
    public function store(Request $request){

        $this->validate($request, [

            'name'=>'required|min:1|max:100'

        ]);



        $id = $request->user()->id;

         
		if(auth()->user()->role_id == 1){
                      $school_id = 0;
                  }elseif (auth()->user()->role_id == 3) {
                      $school_id = auth()->user()->id;
                  }
                  elseif (auth()->user()->role_id == 4) {
                     $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();
                  }

        $data = array(
                'name' => $request->name,
                'added_by_id' => $id,
				'school_id' => $school_id,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
				'added_by_role_id'=>Auth::user()->role_id
            );
            
            DB::table('course_available_grades_percentages')->insert($data);
			
			
			

        Session::flash('message', 'Successfully Saved');

        return redirect('/coursegrades');

    }

    public function destroy(Request $request){

        $id = $request->input("id");

        $coursegrades = Course_available_grades_percentage::find($id);

        $coursegrades->delete();

    }

    public function edit($id){

        $coursegrades = Course_available_grades_percentage::find($id);

        $user = Auth::user();

    	return view ('coursegrades.edit', ['coursegrades'=>$coursegrades], compact('user'));

    }



    public function update($id, Request $request){

        $coursegrades = Course_available_grades_percentage::find($id);

        

        $this->validate($request, [

            'name'=>'required|min:1|max:100',

        ]);

        

        $coursegrades->name=$request->name;

        $coursegrades->save();

        Session::flash('message', 'Successfully Updated');

        return redirect('/coursegrades');

    }

}

