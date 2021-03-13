<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
// use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Zoom;
use Session;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index($type = 'School Calendar')
    {
    	$user = Auth::user();

    	// $events = DB::table('calendar_events')->where('type',$type)->get();
        $events = DB::table('calendar_events')->get();

        // dd(Auth::user()->id);
        //need to make query dinamic
        $lectures = DB::table('lectures')->where('lec_Date' , '!=' , null)->get();
        // dd($courses);
      
        // echo $newformat;
        
    	$cal_events = [];
    	foreach($events as $event)
        {
          

	    		$even = \Calendar::event(
			    $event->event_name, //event title
			    true, //full day event?
			     $event->start_date, //start time (you can also use Carbon instead of DateTime)
			     $event->end_date, //end time (you can also use Carbon instead of DateTime)
				   $event->id,  //optionally, you can specify an event ID
          [
            'url' => '/calendar'
          ]
				);

    		array_push($cal_events, $even);
    	}
      // for lectures
      //ahmad
      foreach($lectures as $c){
        $time = strtotime($c->lec_Date);
          $_date = date('Y-m-d',$time);
        $even = \Calendar::event(
			    $c->topic, //event title        topic is lecture topic  
			    true, //full day event?
			     $c->lec_Date, //start time (you can also use Carbon instead of DateTime)
			     $c->lec_Date, //end time (you can also use Carbon instead of DateTime)
				  //  $event->id,  //optionally, you can specify an event ID
          [
            'url' => '/calendar'
          ]
				);

    		array_push($cal_events, $even);
      }

    	
    	$calendar = \Calendar::addEvents($cal_events);
      



        // dd($students);
        return view ('dashboard', compact('user','calendar'));
    }

    public function index_post($type)
    {
    	$user = Auth::user();
        $events = DB::table('calendar_events')->where('type',$type)->get();

    	if($type == 'School Calendar'){
    		$events = DB::table('calendar_events')->get();

    	}

    	
    	$cal_events = [];
    	foreach($events as $event){
	    		$even = \Calendar::event(
			    $event->event_name, //event title
			    true, //full day event?
			     $event->start_date, //start time (you can also use Carbon instead of DateTime)
			     $event->end_date, //end time (you can also use Carbon instead of DateTime)
				 $event->id,  //optionally, you can specify an event ID
         [
            'url' => '/calendar'
          ] 

				);
    		array_push($cal_events, $even);
    	}

    	$type = $type;

    	$calendar = \Calendar::addEvents($cal_events);
    	return view ('dashboard', compact('user','calendar','type'));
    }

    public function noti_checker($data){
        $last_value = DB::table('users')->where('id',auth()->user()->id)->pluck('noti_count')->first();

        $last_value = $data + $last_value;
        DB::table('users')->where('id',auth()->user()->id)->update([
            'noti_count' => $last_value
        ]);

        return 'success';
    }

     public function noti_number($data){
        // $last_value = DB::table('users')->where('id',auth()->user()->id)->pluck('noti_count')->first();

    // 1 is for students
    // 2 is for students and instructors
    // 3 is for students and instructors and school admins
    // 4 is for direct messages
    // 5 is for direct results of students
    
    $notifications1 = DB::table('activities')->where('message_reciever', auth()->user()->id)->where('activity_for',4)->orderby('created_at','desc')->get();
    // dd($notifications1);

      $notifications2 = DB::table('activities')->where('activity_for',3)->orderby('id','desc')->get();


      if(auth()->user()->role_id == 5){
         $course_ids = DB::table('course_students')->where('student_id',auth()->user()->id)->get()->pluck('course_id');
        $notifications3 = DB::table('activities')->whereIn('course_id',$course_ids)->where('activity_for',1)->orderby('created_at','desc')->get();

        $notifications4 = DB::table('activities')->where('activity_for',5)->where('message_reciever',auth()->user()->id)->orderby('id','desc')->get();

        $notifications3 = $notifications3->merge($notifications4);
        $notifications3 = $notifications3->merge($notifications2);
        $notifications = $notifications3->merge($notifications1);
      }elseif(auth()->user()->role_id == 4){
        $notifications = $notifications1->merge($notifications2);
      }elseif(auth()->user()->role_id == 3){
         $notifications3 = DB::table('activities')->where('activity_for',3)->orderby('created_at','desc')->get();

        $notifications3 = $notifications3->merge($notifications2);
        $notifications = $notifications3->merge($notifications1);
        
      }else{
        $notifications = $notifications1->merge($notifications2);
      }

        $notifications = count($notifications);

        $skipper = DB::table('users')->where('id',auth()->user()->id)->pluck('noti_count')->first();

         // $notifications = DB::table('notifications')->where('school_id',$school_id)->orWhere('school_id',0)->orderBy('id','desc')->count();

        $data = $notifications - $skipper;
         if($data < 0){
          $data = 0;
         }
        
        return $data;
    }
    public function zoom_show_meetings_student(){
      // dd('student');
      $data = DB::table('users')->where('users.id' ,'=',auth()->user()->id)->join('students','users.id','=' , 'students.s_u_id')->first();
      // dd($data);

      $meetings = DB::table('ins_general_meetings')->get();
      $ass = array();
      foreach ($meetings as $row) {
        // dd($row->assignees);
        if (str_contains($row->assignees, $data->email)) { 
         array_push($ass , $row->id);
        }
      }
      return view('zoom.user_index',compact('ass'));
    }
    public function zoom_show_meetings(){
      // dd('raja ji ');
      $data = DB::table('ins_general_meetings')->where('ins_id' , auth()->user()->id)->get();
      return view('zoom.index' , compact('data'));

    }
    public function noti_checker_fetch(){


        // $skipper = DB::table('users')->where('id',auth()->user()->id)->pluck('noti_count')->first();

        // $noti_count = DB::table('notifications')->where('created_by','!=',auth()->user()->id)->where('school_id',$school_id)->orWhere('school_id',0)->orWhere('reciever',auth()->user()->id)->orderby('id','desc')->count();

         // $notifications = DB::table('notifications')->where('school_id',$school_id)->orWhere('school_id',0)->orderBy('id','desc')->take(5)->get();

         // $notifications = DB::table('notifications')->where('created_by','!=',auth()->user()->id)->where('school_id',$school_id)->orWhere('school_id',0)->orWhere('reciever',auth()->user()->id)->orderby('id','desc')->take(5)->get();

      $notifications1 = DB::table('activities')->where('message_reciever', auth()->user()->id)->where('activity_for',4)->orderby('created_at','desc')->get();

      $notifications2 = DB::table('activities')->where('activity_for',3)->orderby('id','desc')->get();


        if(auth()->user()->role_id == 5){
           $course_ids = DB::table('course_students')->where('student_id',auth()->user()->id)->get()->pluck('course_id');
          $notifications3 = DB::table('activities')->whereIn('course_id',$course_ids)->where('activity_for',1)->orderby('created_at','desc')->get();
           $notifications4 = DB::table('activities')->where('activity_for',5)->where('message_reciever',auth()->user()->id)->orderby('id','desc')->get();

        $notifications3 = $notifications3->merge($notifications4);
          $notifications3 = $notifications3->merge($notifications2);
        $notifications = $notifications3->merge($notifications1);
        }elseif(auth()->user()->role_id == 4){
          $notifications = $notifications1->merge($notifications2);
        }elseif(auth()->user()->role_id == 3){
           $notifications3 = DB::table('activities')->where('activity_for',3)->orderby('created_at','desc')->get();

          $notifications3 = $notifications3->merge($notifications2);
        $notifications = $notifications3->merge($notifications1);
          
        }else{
          $notifications = $notifications1->merge($notifications2);
        }


     
        $skipper = DB::table('users')->where('id',auth()->user()->id)->pluck('noti_count')->first();

        $noti_count = count($notifications);

         $noti_count -= $skipper;

        $data = '';
        foreach ($notifications as  $key => $value) {

          if($key < 5){
           
              
              if($noti_count > $key)
              {
                 
                 if($value->link) {
                    $data .=' <a href="'.$value->link.'" class="dropdown-item" style="background-color:gold"><strong>'.$value->title.'</strong> </a> ';   
                 }else{
                  $data .=' <a href="#" class="dropdown-item" style="background-color:gold"><strong>'.$value->title.'</strong> </a> ';
                 }
                   
              }else{
                
                 if($value->link) {
                $data .=' <a href="'.$value->link.'" class="dropdown-item">'.$value->title.' </a> '; 
                }else{
                  $data .=' <a href="#" class="dropdown-item">'.$value->title.' </a> '; 
                }
              }

          }
             
        }
        // dd($notifications);
        $data .= '<a href="/notifications" class="text-center m-2" style="text-align:center">View all</a>';
        $data = json_encode($data);
        return $data;
    }

    public function go_live(Request $request){
     

      $emails = array();

      if($request->emails != null){
          $request->emails = explode(',',$request->emails);
         
          foreach ($request->emails as $key => $email) {
            $email = trim(preg_replace('/\s\s+/', ' ', $email));
            array_push($emails, $email);
          }

      } 

      // dd($emails);

      if(isset($request->courses)){

          foreach ($request->courses as $key => $course){
              $user_ids = DB::table('course_students')->where('course_id',$course)->get()->pluck('user_id');

              $user_emails = DB::table('users')->whereIn('id',$user_ids)->get()->pluck('email');
              // dd($user_emails);
              foreach ($user_emails as $key => $email) {
                
                    array_push($emails, $email);

              }
             
          }

      } 


      if(isset($request->instructors)){
            $user_emails = DB::table('users')->whereIn('id',$request->instructors)->get()->pluck('email');

            foreach ($user_emails as $key => $email) {
                  array_push($emails, $email);
            }
  

      } 



      //Zoom Code
        $user = DB::table('instructors')->where('i_u_id', Auth::user()->id)->get()->first();
        // dd($user->zoom_id);
        $check = Zoom::user()->find($user->zoom_id);
        // dd($check);

         // $met =$check->meetings()->all();
         // dd($met);


        // dd($check->first_name);
        // if($check == ""){
        // 	return redirect()->back()->with('success','Please activate your zoom account to generate meeting, cehck your email.');
        // }
        // $user = Zoom::user()->find('id');
 
        $zoom = new ZoomController();
        $meeting = $zoom->create_meeting($user->zoom_id,'Live Meeting');
        if($meeting == false){
        	Session::flash('message', 'Please activate your ZOOM account to generate meeting, check your mail');
            return redirect()->back();
        }
        else{
        	// dd($meeting);
        	
	    //$meeting = $zoom->create_meeting('6Upk2QD8S-2l_J9inS9-yA',$request->input('topic'));
	        //echo '<pre>';print_r($meeting);exit;
	    // $lecture = DB::table('lectures')->insertGetId([
	    //         'topic' => 'Live Meeting',
	    //         'instructor_id' => $request->input('instructor_id'),
	    //         'week' => $request->input('week'),
	    //         'day' => $request->input('day'),
	    //         'meeting_id' => $meeting->id,
	    //         'join_url' => $meeting->join_url,
	    //         'start_url' => $meeting->start_url,
	    //         'course_id' => $request->input('course_id'),
	    //     ]);

        $class  =DB::table('courses')->where('id', $request->input('course_id'))->get()->pluck('clas_id');
        

        $students = DB::table('classes_students')->whereIn('class_id', $class)->get()->pluck('s_u_id');

        $student = DB::table('users')->join('students', 'students.s_u_id', 'users.id')->whereIn('users.id',$students)->get(); 

        // dd($meeting);
        $redir_url = $meeting->start_url;
        // $url
        // dd($emails);
        foreach($emails as $std)
        {
          $zoom = new ZoomController();
          $registrant = $zoom->add_student_to_meeting($meeting->id, $std);
        }




      // the message
      $msg = "Please Click below link to join meeting with instructor \n".$meeting->join_url;

      // use wordwrap() if lines are longer than 70 characters
      $msg = wordwrap($msg,7000);

      // send email
     // \Artisan::call('cache:clear');
     // \Artisan::call('config:clear');
     // \Artisan::call('config:cache');
     // \Artisan::call('view:clear');
      foreach ($emails as $key => $email) {


                                   $to_name = $email;
                                   $data = (object)null;
                                   $to_email = $email;
                                   $data->ins_name = 'ahmad';
                                   $data->join_link = $meeting->join_url;
                                   Mail::send('meeting_link', array(
                                        'data' => $data,
                                    ), function($message) use ($to_name, $to_email ) {
                                       $message->to($to_email, $to_name)
                                           ->subject('Your have recieved zoom meeting link from your instructor.');
                                       $message->from("sisapps@stepinnsolution.com");
                                   }); 
                                 
           

          // mail($email,"GRECON- Live Instructor Invitation",$msg);
      }


      // GO LIVE ACTIVITIES

      if(isset($request->courses)){
        if(isset($request->send_notification)){
          foreach ($request->courses as $key => $cour_id) {
           
           $course_name = DB::table('courses')->where('id',$cour_id)->pluck('course_name')->first();

                DB::table('activities')->insert([
                    'title' => 'Resource Added Notification',
                    'description' => 'Lecture Added To '. $course_name.' Notification',
                    'created_by' => auth()->user()->id,
                    'activity_name' => 'Resource',
                    'course_id' => $cour_id,
                    'activity_for' => 1,                        
                    'activity_time' => Carbon::now(),
                    'link' => '/studentcourses',
                ]);
              
          }
        } 
      }

      $msg = '<a class="btn btn-info btn-block" href="'. $redir_url . '"> Meeting created click here to open meeting  </a> ';
   
      DB::table('ins_general_meetings')->insert([
           'host_url' => $redir_url,
           'join_url' => $meeting->join_url,
           'meeting_id' => $meeting->id,
           'ins_zoom_id' => $user->zoom_id,
           'ins_id' => Auth::user()->id,
           'assignees' => implode(",",$emails),
           'created_at' => carbon::now(),
      ]);    
      return redirect()->back()->with('link', '<a class="btn btn-info btn-block" href="'. $redir_url . '"> Meeting created click here to open meeting  </a> ');



      					}
    }
}