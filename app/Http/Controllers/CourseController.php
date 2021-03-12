<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Course;

use File;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

use App\Package;

use Illuminate\Support\Facades\DB;





class CourseController extends Controller

{

    public function coursecreate()

    {

        

          $user = Auth::user()->id;

            $assigned_permissions =array();

            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');

            if(auth()->user()->role_id == '4')
            {
              $data = DB::table('module_permissions_store_instructors')->where('user_id' , $user)->pluck('allowed_module');
            }

            if($data != null){

                 foreach ($data as $value) {

                $assigned_permissions = explode(',',$value);

                 

            }

            }

            if(!in_array('Add New Course', $assigned_permissions)){

                return redirect('dashboard');

            }

    	$user = Auth::user();

        $id = auth()->user()->id;
		

		
		if(auth()->user()->role_id == 1){
                      $school_id = 0;
                  }elseif (auth()->user()->role_id == 3) {
                      $school_id = auth()->user()->id;
                  }
                  elseif (auth()->user()->role_id == 4) {
                     $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();
                  }
				// echo auth()->user()->role_id."---".auth()->user()->id."===".$school_id;exit; 
				  
		$coursegrades = DB::table('course_available_grades_percentages')->where('school_id' , $school_id)->orderBy('name', 'asc')->get();
        $school=DB::table('schools')->where('sch_u_id', $id)->first();
        $departments=DB::table('departments')->where('school_id', $id)->get()->all();


        $classes = DB::table('classes')->get()->all();

        // $departments = DB::table('departments')->get()->all();

    	return view ('courses.create', compact('user', 'departments', 'classes','coursegrades'));

    }



    public function coursestore(Request $request)
    {
		
	
		
		
		
         $this->validate($request, [

            'cname' => 'min:3|max:50',


            'rno' => 'required',


            'building' => 'required',


            'sdate' => 'required|date',

            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10000',

            // 'edate' => 'required|date|after_or_equal:sdate',

            'ccolor' => 'required',

            'sessions' => 'required',
            
            'cdescription' => 'required',

            'unlock' => 'required' ,
        
            

            ]);

             if ($files = $request->file('image')) {

            $name=$files->getClientOriginalName();

            $image = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path() .'/assets/img/upload', $image);

       }
       if(Auth::user()->role_id == 3)
           {
            $ins = $request->ins;
           }
           elseif(Auth::user()->role_id == 4)
           {
            $ins = Auth::user()->id;
           }

        $str = strtolower($request->cname);

        $slug = preg_replace('/\s+/', '-', $str);

        if($request->sessions == 1)
        {
            $weeks = 9;
        }
        elseif($request->sessions == 2)
        {
            $weeks = 18;
        }
        elseif($request->sessions == 3)
        {
            $weeks = 27;
        }
        elseif($request->sessions == 4)
        {
            $weeks = 36;
        }

        // $time = \Carbon\Carbon::now()->format('Y-m-d');
        $sdate = $request->sdate;
        $days = $weeks * 7;
        $enddate = (new \Carbon\Carbon($sdate))->addDays($days);
        $edate = $enddate->format('Y-m-d');


        $data = array(

            'course_name'=> $request->cname,

            'image'=> $image,

            'ins_id'=> $ins,

            'user_id'=> Auth::user()->id,

            'room_number'=> $request->rno,

            'building'=> $request->building,

            'start_date'=> $request->sdate,

            'end_date'=> $edate,

            'course_color'=> $request->ccolor,

            'sessions'=> $request->sessions,

            'weeks'=> $weeks,

            'slug'=> $slug,

            'course_description'=> $request->cdescription,

            'unlock_week' => $request->unlock,
            'quiz_percent'=>$request->quiz_percent,
            'test_percent'=>$request->test_percent,
            'assignment_percent'=>$request->assignment_percent,
            

        );
        $c = DB::table('courses')->insertGetId($data);

         DB::table('notifications')->insert([
            'description' => 'New Course '. $request->cname,
            'created_by' => Auth::user()->id,
            'reciever' => $ins,
            'type' => 'Course',
          ]);

        $latest_id = DB::table('courses')->orderBy('id','desc')->pluck('id')->first();

        $four_char =  substr($request->cname, 0, 4);
        $four_char = strtoupper($four_char);

        DB::table('courses')->where('id',$latest_id)->update([
            'unique_identifier' => $latest_id.$four_char,
        ]);


                if($c && isset($_POST['selected_grade_options'])){
					foreach($_POST['selected_grade_options'] as $key=>$val){
			
					 $course_available_grades_percentages_id = $val;
					 $grade_percentage = $_POST['coursegrade_options_'.$val];
					 
					 $name = DB::table('course_available_grades_percentages')->where('id',$val)->pluck('name')->first();
					 
					 //echo $grade_percentage."---".$name."<br>";
						$gradesdata = array(
							'course_id'=>$latest_id,
							'grade_title'=>$name,
							'grade_percentage'=>trim($grade_percentage),
							'created_at'=>date('Y-m-d H:i:s'),
							'updated_at'=>date('Y-m-d H:i:s'),
							'available_course_grades_id'=>$val,
						);
						$inserted_id = DB::table('course_assigned_grade_percentages')->insertGetId($gradesdata);
						
				}
				

                    Session::flash('message', 'Course created successfully');

                    return redirect('/course');

                }else{

                    Session::flash('message', 'Something went wrong');

                    return redirect()->back();

                }

    }



    public function course()
    { 

        
        $user = Auth::user()->id;
         if(auth()->user()->role_id != '5'){

          $user = Auth::user()->id;

            $assigned_permissions =array();

            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');


            if(auth()->user()->role_id == '4')
            {
              $data = DB::table('module_permissions_store_instructors')->where('user_id' , $user)->pluck('allowed_module');
            }

            if($data != null){

                foreach ($data as $value) 
                 {

                    $assigned_permissions = explode(',',$value);

                 }

            }

            if(!in_array('All Courses', $assigned_permissions)){

                return redirect('dashboard');

            }

         }

    	$user = Auth::user();

        if(auth()->user()->role_id == '3')
        {
            $courses = DB::table('courses')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get()->all();
            return view('courses.index', compact('courses', 'user'));

        }
        elseif(auth()->user()->role_id == '4')
        {
            $courses = DB::table('courses')->where('ins_id', Auth::user()->id)->orderBy('id', 'desc')->get()->all();
            return view('courses.index', compact('courses', 'user'));


        }
        

    }


    public function see_students_of_course($id){
           $stds = DB::table('classes_students')->where('class_id' , $id)->orderBy('id', 'desc')->get()->all();
           return view('clases.all_students_of_class' , compact('stds', 'id'));           
        
    }

    public function addstudent_to_course($id, $clasid)
    {

           $allStudents = DB::table('students')->where('school_id', Auth::user()->id)->join('users', 'users.id', 'students.s_u_id')->get()->all();
           $course_name = '';
           $course_name = DB::table('courses')->where('id' , $id)->pluck('course_name')->first();
          
           if($course_name == null)
                
                return redirect('/course');
            $course_students = DB::table('course_students')->where('course_id' , $id)->pluck('student_id');   
            $arr_students[] = '';
            foreach($course_students as $course_student){
                 $arr_students[] = $course_student;
            }
            
            
            
        
        
           return view('courses.add_std_to_course' , compact('allStudents' , 'id','course_name','arr_students'));           
        
    }

    public function storestudent_to_course(Request $request)
    {



        if(!empty($request->std_id)){
        
        DB::table('course_students')->where('course_id',$request->course_id)->delete();
        foreach( $request->std_id  as $student_id)
        {
        
            $course_students = array(
                'course_id' => $request->course_id,
                'student_id' => $student_id,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            );
        $success = DB::table('course_students')->insert($course_students);
        
		DB::table('notifications')->insert([
            'description' => 'Students updated in course',
            'created_by' => Auth::user()->id,
            'reciever' => Auth::user()->id,
            'type' => 'Course Update',
          ]);
		  
		  
            
            
        }
          Session::flash('message', 'Selected Student added to course'. DB::table('courses')->where('id',$request->course_id)->pluck('course_name')->first().'.');
          return redirect('/course');
   }
   else{
       Session::flash('message', 'Please select a student first!');

        return redirect()->back();
   }

    }

    public function course_students($id)
    {

        $students = DB::table('course_students')->where('course_id', $id)->get()->all();
        if(!empty($students))
        {

            return view('courses.students', compact('students', 'id'));
        }
        else{
            Session::flash('message', 'This course has no student assigned yet!');

            return redirect()->back();
        }
    }


    public function show_details($id, $clasid)
    {
        $course_assigned_grade_percentages = DB::table('course_assigned_grade_percentages')->where('course_id',$id)->get();

        if(auth()->user()->role_id == '5'){
             $course = DB::table('courses')->where('id', $id)->get()->first();


            $weeks = $course->weeks;
            // $instructor_id = DB::table('instructor_student')->where('s_u_id',auth()->user()->id)->pluck('created_by_id')->first();
            // dd($instructor_id);
           // if($instructor_id == null){
           //      return view('courses.show_details', compact('course', 'weeks', 'clasid'));

           // }
            $instructor_id = $course->ins_id;
           // dd($instructor_id);
            return view('courses.show_details', compact('course', 'weeks', 'instructor_id', 'clasid','course_assigned_grade_percentages'));
        }
        $course = DB::table('courses')->where('id', $id)->get()->first();
         $course_assigned_grade_percentages = DB::table('course_assigned_grade_percentages')->where('course_id', $id)->get();	
		$weeks = $course->weeks;
        $instructor_id = Auth::user()->id;
        return view('courses.show_details', compact('course', 'weeks', 'instructor_id', 'clasid','course_assigned_grade_percentages'));
    }

    public function show_week_details($insid, $cid, $week, $clasid)
    {
        if($insid == null){
            return redirect()->back();
        }

        $mquizzes = DB::table('quizzes')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'monday'],
        ])->orderBy('id', 'desc')->get()->all();
        $tuesquizzes = DB::table('quizzes')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'tuesday'],
        ])->orderBy('id', 'desc')->get()->all();
        $wedquizzes = DB::table('quizzes')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'wednesday'],
        ])->orderBy('id', 'desc')->get()->all();
        $tquizzes = DB::table('quizzes')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'thursday'],
        ])->orderBy('id', 'desc')->get()->all();
        $fquizzes = DB::table('quizzes')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "friday"],
        ])->orderBy('id', 'desc')->get()->all();


        $mlinks = DB::table('courselink')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'monday'],
        ])->orderBy('id', 'desc')->get()->all();
        $tueslinks = DB::table('courselink')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'tuesday'],
        ])->orderBy('id', 'desc')->get()->all();
        $wedlinks = DB::table('courselink')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'wednesday'],
        ])->orderBy('id', 'desc')->get()->all();
        $tlinks = DB::table('courselink')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'thursday'],
        ])->orderBy('id', 'desc')->get()->all();
        $flinks = DB::table('courselink')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'friday'],
        ])->orderBy('id', 'desc')->get()->all();




        $mlectures = DB::table('lectures')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'monday'],
        ])->orderBy('id', 'desc')->get()->all();
         $tueslectures = DB::table('lectures')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'tuesday'],
        ])->orderBy('id', 'desc')->get()->all();
          $wedlectures = DB::table('lectures')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'wednesday'],
        ])->orderBy('id', 'desc')->get()->all();
           $thlectures = DB::table('lectures')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'thursday'],
        ])->orderBy('id', 'desc')->get()->all();
            $flectures = DB::table('lectures')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'friday'],
        ])->orderBy('id', 'desc')->get()->all();





        $mvideoos = DB::table('resources')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "monday"],
        ])->orderBy('id', 'desc')->get()->all();
        $tuesvideoos = DB::table('resources')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "tuesday"],
        ])->orderBy('id', 'desc')->get()->all();
        $wedvideoos = DB::table('resources')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "wednesday"],
        ])->orderBy('id', 'desc')->get()->all();
        $tvideoos = DB::table('resources')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "thursday"],
        ])->orderBy('id', 'desc')->get()->all();
        $fvideoos = DB::table('resources')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "friday"],
        ])->orderBy('id', 'desc')->get()->all();

        $course = DB::table('courses')->where('id',$cid)->first();
        
        
        
        return view('courses.show_week_details', compact('course','mquizzes','tuesquizzes','wedquizzes' ,'tquizzes' ,'fquizzes', 'mlinks', 'tueslinks', 'wedlinks', 'tlinks', 'flinks', 'mlectures', 'tueslectures', 'wedlectures', 'thlectures', 'flectures', 'mvideoos', 'tuesvideoos', 'wedvideoos', 'tvideoos', 'fvideoos', 'insid', 'cid', 'week', 'clasid'));
    }

    public function students_courses()
    {
        $courses = DB::table('course_students')->where('student_id', Auth::user()->id)->orderBy('id' , 'desc')->get()->all();
        return view('courses.student_courses', compact('courses'));
    }


    public function class_course($id)

    { 
        $courses = DB::table('courses')->where('clas_id', $id)->get();
        return view('courses.class_courses', compact('courses', 'id'));

    }

    public function class_stds($id)
    { 
        $students = DB::table('classes_students')->where('class_id', $id)->get()->all();
        return view('clases.no_students_of_class', compact('students'));

    }


    public function course_wise_url(Request $request)

    {

    	$user = Auth::user();

    	// $cat = Course::where('slug',$request->cat)->first();

        $cat = DB::table('courses')->where('slug',$request->cat)->first();

        if($cat){

               $course_name = $cat->course_name;

               return view('courses.course_wise_url', compact('course_name','cat', 'user'));

           }else{

               Session::flash('error','URL Category not found');

               return redirect('/course');

           }

    }

    public function course_replicate(Request $request)
    {
        $oldcourse = DB::table('courses')->where('id', $request->course_id)->first();

        $data = new Course();
        $data->course_name = $oldcourse->course_name;
        $data->building = $oldcourse->building;
        $data->room_number = $oldcourse->room_number;
        $data->image = $oldcourse->image;
        $data->user_id = $oldcourse->user_id;
        $data->start_date = $oldcourse->start_date;
        $data->end_date = $oldcourse->end_date;
        $data->course_color = $oldcourse->course_color;
        $data->sessions = $oldcourse->sessions;
        $data->slug = $oldcourse->slug;
        $data->clas_id = $oldcourse->clas_id;
        $data->course_description = $oldcourse->course_description;

        $data->save();
        DB::table('course_instructor')->insert([
                'i_u_id' => Auth::user()->id,
                'course_id' => $data->id,
            ]);
        if($request->selected > 0)
	        foreach( $request->selected  as $sitems)
	        {
	            if($sitems == 'quiz')
	            {
	                $coursequiz = DB::table('quizzes')->where('course_id', $oldcourse->id)->get()->all();
	                if($coursequiz)
	                {
	                    foreach($coursequiz as $cq)
	                    {
	                        $dup_course_quiz = array(
	                            'quiz_date' => $cq->quiz_date,
	                            'negative_marking' => $cq->negative_marking,
	                            'name' => $cq->name,
	                            'duration' => $cq->duration,
	                            'start_time' => $cq->start_time,
	                            'end_time' => $cq->end_time,
	                            'instructor_id' => $cq->instructor_id,
	                            'course_id' => $data->id,
	                        );

	                        $dupcq = DB::table('quizzes')->insertGetId($dup_course_quiz);
	                        $dqqs = DB::table('quiz_questions')->where('quiz_id', $cq->id)->get()->all();
	                        if($dqqs)
	                        {
	                            foreach ($dqqs as $dqq) 
	                            {
	                                $dup_qq = array(
	                                    'sort_order' => $dqq->sort_order,
	                                    'quiz_id' => $dupcq,
	                                    'question_id' => $dqq->question_id,
	                                );
	                                $success = DB::table('quiz_questions')->insert($dup_qq);
	                                
	                            }
	                            Session::flash('message', 'Course duplicate successfully with its quiz and questions');

	                            return redirect('/course');
	                        }
	                        else
	                        {
	                            Session::flash('message', 'Course and its related quizzes are duplicate successfully.But this created quiz has no questions.');

	                            return redirect('/course');
	                        }
	                    }

	                }
	                else
	                {
	                    Session::flash('message', 'Course duplicate successfully. But it has no quiz and its relevant questions');

	                    return redirect('/course');
	                }
	            }
	            elseif($sitems == 'links')
	            {
	            	$courselink=DB::table('courselink')->where('course_id', $oldcourse->id)->get()->all();
	            	foreach ($courselink as $cl) {
	            	$dup_course_link = array(
	                            'title' => $cl->title,
	                            'short_description' => $cl->short_description,
	                            'link' => $cl->link,
	                            'course_id' => $data->id,
	                        );

	                        $success = DB::table('courselink')->insertGetId($dup_course_link);
	            	}
	            	if($success){

			            Session::flash('message', 'Course Links duplicated successfully');

			            return redirect('/course');

			        }else{

			            Session::flash('message', 'Something went wrong');

			            return redirect()->back();

			        }

	            }
	            elseif($sitems == 'downloadables')
	            {
	            	$cresources=DB::table('resources')->where('course_id', $oldcourse->id)->get()->all();
	            	foreach ($cresources as $cr) 
	            	{
		            	$dup_course_downloads = array(
		                            'title' => $cr->title,
		                            'file' => $cr->file,
		                            'short_description' => $cr->short_description,
		                            'type' => $cr->type,
		                            'course_id' => $data->id,
		                        );

		                $success = DB::table('resources')->insertGetId($dup_course_downloads);
	            	}
	            	if($success){

			            Session::flash('message', 'Course resources duplicated successfully');

			            return redirect('/course');

			        }else{

			            Session::flash('message', 'Something went wrong');

			            return redirect()->back();

			        }
	            }

	        }
	    else
	    {
	    	Session::flash('message', 'Course duplicated successfully without its quizzes and other data.');

            return redirect('/course');	
	    }
    }

    public function course_edit($id)

    {

    	$user = Auth::user();

        $course = DB::table('courses')->where('id',$id)->first();
		

		if(auth()->user()->role_id == 1){
                      $school_id = 0;
                  }elseif (auth()->user()->role_id == 3) {
                      $school_id = auth()->user()->id;
                  }
                  elseif (auth()->user()->role_id == 4) {
                     $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();
                  }
	$courseavailablegrades = DB::table('course_available_grades_percentages')->where('school_id' , $school_id)->orderBy('name', 'asc')->get();

        $departments = DB::table('departments')->get()->all();

        $classes = DB::table('classes')->get()->all();


        return view('courses.edit', compact('course', 'user', 'departments', 'classes','courseavailablegrades'));

    }



   public function course_update(Request $request, $id)

    {
		
      // echo '<pre>';print_r($_POST);exit;

        $this->validate($request, [

                'cname' => 'required|min:3|max:50',

                // 'department' => 'required|min:2|max:200',

                'rno' => 'required',

                'building' => 'required',

                'sdate' => 'required|date',

                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

                'edate' => 'required|date|after_or_equal:sdate',

                'ccolor' => 'required',

                'sessions' => 'required',

                'cdescription' => 'required',

                'unlock_week' => 'required',
                // 'quiz_percent' => 'required',
                // 'test_percent' => 'required',
                // 'assignment_percent' => 'required',

            ]);

        $course = DB::table('courses')->where('id',$id)->get()->first();

       
            

        if ($files = $request->file('image')) {

            $path="assets/img/upload/$course->image";

            @unlink($path);

            $name=$files->getClientOriginalName();

            $image = time().'.'.$request->image->getClientOriginalExtension();

            // $request->image->move(public_path('storage/'), $image);

            $request->image->move(public_path() .'/assets/img/upload', $image);

           }

           else{

            $image = $course->image;

           }

           if(Auth::user()->role_id == 3)
           {
            $ins = $request->ins;
           }
           elseif(Auth::user()->role_id == 4)
           {
            $ins = Auth::user()->id;
           }

        $str = strtolower($request->cname);

        $slug = preg_replace('/\s+/', '-', $str);

        $data = Course::find($id);

        $data->course_name=$request->input('cname');

        $data->image=$image;

        $data->ins_id=$ins;

        $data->room_number=$request->input('rno');

        $data->building=$request->input('building');

        $data->start_date=$request->input('sdate');

        $data->end_date=$request->input('edate');

        $data->course_color=$request->input('ccolor');

        $data->sessions=$request->input('sessions');

        $data->slug=$slug;

        $data->course_description=$request->input('cdescription');

        $data->unlock_week=$request->input('unlock_week');
        $data->quiz_percent=$request->input('quiz_percent');
        $data->test_percent=$request->input('test_percent');
        $data->assignment_percent=$request->input('assignment_percent');

            
        $success = $data->save();

        if(isset($request->send_notification)){
            DB::table('notifications')->insert([
            'description' => 'Course Updated '. $request->cname,
            'created_by' => Auth::user()->id,
            'reciever' => $ins,
            'type' => 'Course Update',
          ]);
        }

        if($success){
			
			if(isset($_POST['selected_grade_options'])){
				DB::table('course_assigned_grade_percentages')->where('course_id',$id)->delete();
				foreach($_POST['selected_grade_options'] as $key=>$val){
				
					 $course_available_grades_percentages_id = $val;
					 $grade_percentage = $_POST['coursegrade_options_'.$val];
					 
					 $name = DB::table('course_available_grades_percentages')->where('id',$val)->pluck('name')->first();
					 
					 //echo $grade_percentage."---".$name."<br>";
						$gradesdata = array(
							'course_id'=>$id,
							'grade_title'=>$name,
							'grade_percentage'=>trim($grade_percentage),
							'created_at'=>date('Y-m-d H:i:s'),
							'updated_at'=>date('Y-m-d H:i:s'),
							'available_course_grades_id'=>$val,
						);
						$inserted_id = DB::table('course_assigned_grade_percentages')->insertGetId($gradesdata);
						
				}
			}

            Session::flash('message', 'Course updated successfully');

            return redirect('/course')->with('success', 'Update Successfuly');

        }else{

            Session::flash('message', 'Something went wrong');

            return redirect()->back()->with('alert', 'Update Unsuccessfuly');

        }

    }

    

    public function destroy(Request $request)

    {

			$id = $request->id;  

            $course = DB::table('courses')->where('id',$id)->get()->first();

            $path="/assets/img/upload/$course->image";

            File::delete($path);

            DB::table('quizzes')->where('course_id',$course->id)->delete();
            DB::table('questions')->where('course_id',$course->id)->delete();
            DB::table('resources')->where('course_id',$course->id)->delete();
            DB::table('courselink')->where('course_id',$course->id)->delete();
            DB::table('course_instructor')->where('course_id',$course->id)->delete();
			DB::table('courses')->where('id',$id)->delete();

            Session::flash('message', 'Course deleted successfully');

    }

    public function addinstructor_to_course($id){
            $ins = DB::table('course_instructor')->pluck('i_u_id');
            $instructors = DB::table('instructors')->whereNotIn('i_u_id', $ins)->join('users', 'users.id', '=' , 'instructors.i_u_id')->get()->all();
            return view('courses.add_instructor_to_course' , compact('instructors', 'id'));    
    }

    public function storeinstructor_to_course(Request $request){

         
        if(count($request->instructor_id) > 0 ){
            
        foreach( $request->instructor_id  as $i_u_id){
            DB::table('course_instructor')->insert([
                'i_u_id' => $i_u_id,
                'course_id' => $request->course_id
            ]);
    }
    Session::flash('message', 'Selected Instructor added to Course'. DB::table('courses')->where('id',$request->course_id)->pluck('course_name')->first().'.');
    return redirect('/course');
}
    else{
    Session::flash('message', 'No Class Selected');

    return redirect('/course');
    }

}

    public function see_instructors_of_course($id){

        $instructors = DB::table('course_instructor')->where('course_id' , $id)->get()->all();

        return view('courses.all_instructors_to_course' , compact('instructors', 'id'));
    }

    public function destroy_instructor_from_course(Request $request)

    {
        
			$id = $request->id;  

            $crs_ins = DB::table('course_instructor')->where('id',$id)->delete();

			// DB::table('course_instructor')->where('id',$id)->delete();

            Session::flash('message', 'course_instructor deleted successfully');

    }

}