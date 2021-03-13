<?php



namespace App\Http\Controllers;



use App\Instructor;

use App\User;

use File;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

// use Illuminate\Support\Facades\DB;

use DB;

use Carbon\Carbon;


class InstructorsController extends Controller

{

    

    public function store_permission_ins(Request $request){

        

       $is_assigned_any_permissions = DB::table('module_permissions_store_instructors')->where('user_id' , $request->id)->first();

       if($is_assigned_any_permissions != null){

       $data = $request->permiss;

       if($data == null)

       {

              $data = ['nodata , nodata'];

       }

            $new = implode(',', $data);

            $result = DB::table('module_permissions_store_instructors')->where('user_id' , $request->id)->update([ 

                 "user_id" => $request->id,

                 "allowed_module" => $new

            ]);



             Session::flash('message', 'Permissions are updated for instructor');

             return redirect('/instructors');

           

       }

       elseif ($is_assigned_any_permissions == null) {

            # code...

            $data = $request->permiss;

            if($data == null)

               {

                     $data = ['nodata , nodata'];

               }

            $new = implode(',', $data);

            $result = DB::table('module_permissions_store_instructors')->insert([ 

                "user_id" => $request->id,

               "allowed_module" => $new

            ]);

           

             Session::flash('message', 'Permissions are updated for instructor');

             return redirect('/instructors');



        } 

        

      

      

    }

    

    public function change_permission_instructor($id){

        // dd($id);

        $user = Auth::user();

        $granted_permissions;

        $granted_permissions = DB::table('module_permissions_store_instructors')->where('user_id' , $id)->first();

        if($granted_permissions == null)

             {

             $granted_permissions = [' ' , ' '];

             

             }

         elseif ($granted_permissions != null) {

                 # code...

                 $granted_permissions = explode(',',$granted_permissions->allowed_module);

              

             } 

       $title = "Change Instructor Permissions";

       $permissions = DB::table('module_permissions_instructors')->pluck('module');

       $page='instructor';

       return view('permissions.addd_remove_permission',compact('user' , 'page' ,'title' , 'id' , 'permissions' , 'granted_permissions'));

    }

    

    public function index()
    {
          $user = Auth::user()->id;
          if(auth()->user()->role_id != '5'){

            $assigned_permissions =array();

            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');
            if($data != null){

                 foreach ($data as $value) {

                $assigned_permissions = explode(',',$value);
            }

            }

            if(!in_array('All Instructors', $assigned_permissions)){

                return redirect('dashboard');

            }

          }

        $user = Auth::user();

        // $instructors = DB::table('instructor_school')->where('sch_u_id', Auth::user()->id)->paginate(5);

        $instructors = DB::table('instructor_school')->where('sch_u_id', Auth::user()->id)->orderBy('id' , 'desc')->get()->all();

    	return view ('instructors.index', compact('user', 'instructors'));

    }

    public function create_lecture($insid, $cid, $week)
    {
        $course = DB::table('courses')->where('id', $cid)->get()->first();
        // dd($course);
        $instructor_id = $insid;
        $week = $week;
        return view('instructors.create_lecture', compact('course', 'instructor_id', 'week'));
    }
    public function edit_lecture($id)
    {
        $lec = DB::table('lectures')->where('id', $id)->get()->first();

        Session::flash('message', 'Lecture updated successfully');
        
        return view('instructors.edit_lecture', compact('lec'));
    }
    public function update_lecture(Request $request, $id)
    {
        $lec = DB::table('lectures')->where('id', $id)->update([
            'topic' => $request->topic,
            'day' => $request->day,
        ]);
        
        return redirect()->back();
    }
    public function destroy_lec(Request $request)
    {
        $id = $request->id;

        DB::table('lectures')->where('id',$id)->delete();

        Session::flash('message', 'Lecture deleted successfully');
    }
    public function show_lecture($id)
    {
        $lectures = DB::table('lectures')->where('course_id', $id)->orderBy('id' , 'desc')->get();
        dd($lectures);

        return view('instructors.show_lectures', compact('lectures'));
    }
    public function launch_meeting($id, $cid)
    {
      $lec = DB::table('lectures')->where('id', $id)->get()->first();
      $a = $this->live_fun($lec->meeting_id);
      $date = \Carbon\Carbon::now()->format('Y-m-d');
      $time = \Carbon\Carbon::now()->format('h:i');
      $atn = DB::table('attendance')->where('student_id', Auth::user()->id)->where('course_id', $cid)->where('lecture_id', $id)->get()->first();
      if($atn)
      {
        DB::table('attendance')->where('student_id', Auth::user()->id)->where('course_id', $cid)->where('lecture_id', $id)->update([
          'status' => 'p', 
          'date' => $date, 
          'time' => $time,
        ]);
      }
      else{

        $attendance = array(
          'student_id' => Auth::user()->id, 
          'course_id' => $cid, 
          'lecture_id' => $id, 
          'status' => 'p', 
          'date' => $date, 
          'time' => $time, 
        );  

        DB::table('attendance')->insert($attendance);
      }
      return view('instructors.launch_meeting', compact('a', 'lec'));
    }

    public function live_fun($lec_meeting)
    {
      $user = Auth::user();
      if($user->role_id == '4')
      {
        $role = 1;
      }
      elseif($user->role_id == '5')
      {
        $role = 0;
      }
      $api_key = "qrmEqiqIS7C244YKZoJyMw";
      $meeting_number = $lec_meeting;
      $role = $role;
      $api_secret = "0l4FeTaZLT7MRTdbCMZePDKqAfaTvLjfYhDj";

      $time = time() * 1000 - 30000;//time in milliseconds (or close enough)
    
      $data = base64_encode($api_key . $meeting_number . $time . $role);
      
      $hash = hash_hmac('sha256', $data, $api_secret, true);
      
      $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);
      
      //return signature, url safe base64 encoded
      $a = rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');

      return $a;
    }

    public function store_lecture(Request $request)
    {

        // dd($request->all());

        $this->validate($request, [
          'topic' => 'required|min:3|max:50',
        ]);
        $user = DB::table('instructors')->where('i_u_id', Auth::user()->id)->get()->first();
        // dd($user);
		
	      $zoom = new ZoomController();
          $meeting = $zoom->create_meeting($user->zoom_id,$request->input('topic'));
         if($meeting == false){
            Session::flash('message', 'Please activate your ZOOM account to generate meeting, check your mail');
            return redirect()->back();
        }
		    //$meeting = $zoom->create_meeting('6Upk2QD8S-2l_J9inS9-yA',$request->input('topic'));
            //echo '<pre>';print_r($meeting);exit;
		      $lecture = DB::table('lectures')->insertGetId([
            'topic' => $request->input('topic'),
            'instructor_id' => $request->input('instructor_id'),
            'week' => $request->input('week'),
            'day' => $request->input('day'),
            'meeting_id' => $meeting->id,
            'join_url' => $meeting->join_url,
            'start_url' => $meeting->start_url,
            'course_id' => $request->input('course_id'),
            'lec_Date' => $request->lec_date,
        ]);

           $course_name = DB::table('courses')->where('id',$request->course_id)->pluck('course_name')->first();
           if(isset($request->send_notification)){
            DB::table('activities')->insert([
                'title' => 'Resource Added Notification',
                'description' => 'Lecture Added To '. $course_name.' Notification',
                'created_by' => auth()->user()->id,
                'activity_name' => 'Resource',
                'course_id' => $request->course_id,
                'activity_for' => 1,                        
                'activity_time' => Carbon::now(),
                'link' => '/studentcourses',
            ]);
          }
        

        $class  =DB::table('courses')->where('id', $request->input('course_id'))->get()->pluck('clas_id');
        $students = DB::table('classes_students')->whereIn('class_id', $class)->get()->pluck('s_u_id');

        $student = DB::table('users')->join('students', 'students.s_u_id', 'users.id')->whereIn('users.id',$students)->get(); 


        foreach($student as $std)
        {
          $zoom = new ZoomController();
          $registrant = $zoom->add_student_to_meeting($meeting->id, $std->email, $std->name, $std->name, $std->address, 'lahore', 'US', '95055', 'CA', $std->phone, 'Tech', 'IT', 'DA');
        }
    
        Session::flash('message', 'Lecture created successfully');

        return redirect()->back();
    }

    public function create(){
         $user = Auth::user()->id;

            $assigned_permissions =array();

            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');


            if($data != null){

                 foreach ($data as $value) {

                $assigned_permissions = explode(',',$value);

            }

            }

            if(!in_array('Add Instructor', $assigned_permissions)){

                return redirect('dashboard');

            }

        $user = Auth::user();

        $schools = DB::table('schools')->get()->all();

    	return view ('instructors.create', compact('user', 'schools'));

    }


    public function store(Request $request){

        $this->validate($request, [

            'name'=>'required|min:3|max:50',

            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10000',

            'email'=>'required|email|unique:users|max:255',

            'password' => 'required|string|confirmed',

            'phno' => 'required',

            'cnic' => 'required',

            'add' => 'required|min:3|max:200'

        ]);

        if ($files = $request->file('image')) {

            $image = $request->file('image');

            $imageName = time().'.'.$image->getClientOriginalName();

            $request->image->move(public_path() .'/assets/img/upload', $imageName);

        }

        $udata = new User();

        $udata->name=$request->input('name');

        $udata->role_id=4;

        $udata->email=$request->input('email');

        $udata->contact=$request->input('phno');

        $udata->image=$imageName;

        $udata->password = Hash::make($request['password']);

        $udata->save();


        $instructor=new Instructor;


        $instructor->i_u_id=$udata->id;

        $instructor->phone=$request->phno;

        $instructor->cnic=$request->cnic;

        $instructor->address=$request->add;

        $instructor->save();

        $i_sch_data = array(

            'i_u_id' => $instructor->i_u_id,

            'sch_u_id' => Auth::user()->id,

        ); 
        $success = DB::table('users')->where('id' , $udata->id)->update([
            'unique_id' => $udata->name . '' . $udata->id,
        ]);

        $success = DB::table('instructor_school')->insert($i_sch_data);

        if($success){
            $all_perm = DB::table('module_permissions_instructors')->pluck('module')->toArray();

            $new = implode(',', $all_perm);

            $result = DB::table('module_permissions_store_instructors')->insert([ 

                 "user_id" => $instructor->i_u_id,

                 "allowed_module" => $new

            ]);
            $zoom = new ZoomController();
            
            $zo_u = $zoom->user_list();

            $zoom_user = $zoom->create_user($request->input('name'),$request->input('name'),$request->input('email'),$request->input('password'));

            DB::table('instructors')->where('i_u_id', $instructor->i_u_id)->update([
                'zoom_id' => $zoom_user->id,
            ]);
        
            Session::flash('message', 'Instructor create successfully, Zoom notification sent to instructor');

            return redirect('/instructors');

        }else{

            Session::flash('message', 'Something went wrong');

            return redirect()->back();
        }
    }

    

    public function destroy(Request $request)

    {

        $id = $request->id;

        $user = DB::table('users')->where('id',$id)->get()->first();

        $path="assets/img/upload/$user->image";

        File::delete($path);

        DB::table('instructor_school')->where('i_u_id',$id)->delete();

        DB::table('instructors')->where('i_u_id',$id)->delete();

        DB::table('users')->where('id',$id)->delete();

        Session::flash('message', 'Instructor deleted successfully');

    }   

    public function show($id)

    {
        $user = Auth::user();

        $instructordetail = DB::table('instructors')->where('i_u_id',$id)->get()->first();

        return view('instructors.show', compact('instructordetail', 'user'));
    }

   

    public function edit($id){

        $user = Auth::user();

        $instructor = DB::table('users')->join('instructors','instructors.i_u_id','=','users.id')->where('users.id',$id)->first();

    	return view ('instructors.edit', compact('instructor', 'user'));

    }



    public function update($id, Request $request)

    {

        $instructor = DB::table('instructors')->where('id',$id)->get()->first();

        $user = DB::table('users')->where('id',$instructor->i_u_id)->get()->first();


        $this->validate($request, [

            'name'=>'required|min:3|max:50',

            //'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:10000',

            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,

            'phno' => 'required',

            'cnic' => 'required',

            'add' => 'required|min:3|max:200'

        ]);

        if ($files = $request->file('image')) {

            $path="assets/img/upload/$user->image";

            @unlink($path);

            $image = $request->file('image');

            $imageName = time().'.'.$image->getClientOriginalName();  

            $image->move(public_path() .'/assets/img/upload', $imageName);

           }

           else{

            $imageName = $user->image;

           }



           $udata = User::find($instructor->i_u_id);

           $udata->name=$request->input('name');

           $udata->contact=$request->input('phno');

           $udata->email=$request->input('email');

           $udata->image=$imageName;

           $udata->save();

    

            $data = Instructor::find($id);

            $data->phone=$request->input('phno');

            $data->cnic=$request->input('cnic');

            $data->address=$request->input('add');

            $data->save();

            Session::flash('message', 'Updated successfully');

            return redirect('/instructors');

    }

}