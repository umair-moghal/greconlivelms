<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
use Carbon\Carbon;

class MessagesController extends Controller
{
    public function messages($id=0)
    {
        
        

        $curr_user = Auth::user();
        $user = Auth::user();
        $user_id =$curr_user->role_id;

        //ahmad  3 8 2021
      
         if(Auth::user()->role_id == 3)
        {
              $school_ins_ids = DB::table('instructor_school')->where('sch_u_id' , $curr_user->id)->pluck('i_u_id');
              $school_instructors = DB::table('users')->wherein('id' ,$school_ins_ids )->get();
              return view ('messages.messages', compact('school_instructors'));
        }

        if(Auth::user()->role_id == 4)
        {
            $instructor_courses = DB::table('courses')->where('ins_id', $curr_user->id)->pluck('id')->toArray();
            $instructor_students = DB::table('course_students')->whereIn('course_id', $instructor_courses)->join('users', 'users.id', 'course_students.student_id')->get();
            

              $school_ins_ids = DB::table('instructor_school')->where('i_u_id' , $curr_user->id)->pluck('sch_u_id');
              $school_instructors = DB::table('users')->wherein('id' ,$school_ins_ids )->get();
            return view ('messages.messages', compact('instructor_students','school_instructors'));
        }
        if(Auth::user()->role_id == 5)
        {    
            $student_courses = DB::table('course_students')->where('student_id', $curr_user->id)->pluck('course_id')->toArray();
            
            $instructor_courses = DB::table('course_instructor')->whereIn('course_id', $student_courses)->get()->pluck('i_u_id');

            $instructors = DB::table('users')->whereIn('id', $instructor_courses)->get();
            // dd($instructors);

            return view ('messages.messages', compact('instructors'));

        }



        return redirect()->back();

              
    }

    public function get_messages($id)
    {
        
        $my_id = Auth::user()->id;

        if(Auth::user()->role_id == 4)
        {
            $check = DB::table('users')->where('id' , $id)->pluck('role_id')->first();
            if($check == 5){
                        $messages = DB::table('messages_instructor_student')->where(function ($querry) use ($id, $my_id)
                        {
                            $querry->where([
                                'ins_id' => $my_id,
                                'std_id' => $id,
                            ]);
                        })->get();
               }else{
                         $messages = DB::table('messages_instructor_school')->where(function ($querry) use ($id, $my_id)
                            {
                                $querry->where([
                                    'ins_id' => $my_id,
                                    'school_id' => $id,
                                ]);
                            })->get();

               }

        }
        elseif(Auth::user()->role_id == 5)
        {

            $messages = DB::table('messages_instructor_student')->where(function ($querry) use ($id, $my_id)
            {
                 $querry->where([
                    'ins_id' => $id,
                    'std_id' => $my_id,
                ]);
            })->get();

        }
        elseif(Auth::user()->role_id == 3)
        {
            $messages = DB::table('messages_instructor_school')->where(function ($querry) use ($id, $my_id)
            {
                 $querry->where([
                    'ins_id' => $id,
                    'school_id' => $my_id,
                ]);
            })->get();

        }

        $msg_user = DB::table('users')->where('id', $id)->get()->first();

        return view ('messages.chat_area', compact('messages', 'msg_user', 'id'));
    }


    public function sendMessage(Request $request)
    {        
        // dd($request->all());
        $time = \Carbon\Carbon::now();
        $recieveid = $request->receiver;
        $data;

        if(Auth::user()->role_id == 3){
            $school_id = Auth::user()->id;
            $ins_id = $recieveid;
                        $data = array(
                        'content'=> $request->content,
                        'school_id'=> $school_id,
                        'ins_id'=> $ins_id,
                        'sent_by'=> Auth::user()->id,
                        'created_at'=> $time,
                    );
                   $success = DB::table('messages_instructor_school')->insert($data);
        }
    	if(Auth::user()->role_id==4)
    	{
            $check = DB::table('users')->where('id' , $recieveid)->pluck('role_id')->first();
            if($check == 5){
        		$std_id = $recieveid;
        		$ins_id = Auth::user()->id;
                        $data = array(
                        'content'=> $request->content,
                        'std_id'=> $std_id,
                        'ins_id'=> $ins_id,
                        'sent_by'=> Auth::user()->id,
                        'created_at'=> $time,
                        );
                       $success = DB::table('messages_instructor_student')->insert($data);
                 }else{
                    $school_id = $recieveid;
                    $ins_id = Auth::user()->id;
                        $data = array(
                        'content'=> $request->content,
                        'school_id'=> $school_id,
                        'ins_id'=> $ins_id,
                        'sent_by'=> Auth::user()->id,
                        'created_at'=> $time,
                        );
                       $success = DB::table('messages_instructor_school')->insert($data);

                 }
    	}
    	if(Auth::user()->role_id==5)
    		{
    		$ins_id = $recieveid;
    		$std_id = Auth::user()->id;
                $data = array(
                'content'=> $request->content,
                'std_id'=> $std_id,
                'ins_id'=> $ins_id,
                'sent_by'=> Auth::user()->id,
                'created_at'=> $time,
               );
                 $success = DB::table('messages_instructor_student')->insert($data);
        }

        
    	

		 
            DB::table('activities')->insert([
                'title' => 'New Message Notification',
                'description' => $request->content,
                'created_by' => auth()->user()->id,
                'activity_name' => 'Message',
                'activity_for' => 4,                        
                'activity_time' => Carbon::now(),
                 'message_reciever' => $recieveid,
                
            ]);

          // DB::table('notifications')->insert([
          //   'description' => $request->content,
          //   'created_by' => auth()->user()->id,
          //   'reciever' => $recieveid,
          //   'type' => 'Message'
          // ]);

          // Pusher

        $options = array(
            'cluster' => 'ap2',
            'useTLS' => false
          );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );


          $data = ['recieveid' => $recieveid];
          // dd($data);

          // $pusher->trigger('my-channel', 'my-event', $data);
          return $data;
    }
}
