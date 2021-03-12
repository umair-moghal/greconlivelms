<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class NotificationsController extends Controller
{
	public function index(){

		// 1 is for students
		// 2 is for students and instructors
		// 3 is for students and instructors and school admins
		// 4 is for direct messages
		// 5 is for direct results of students
		
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
	   
		

		return view('notifications.index',compact('notifications'));
	}


	public function notifications_search_bar(Request $request){
		
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


	    if($request->course != 'Select Course'){
	    	foreach ($notifications as $key => $noti) {
	    		if($noti->course_id != $request->course){
	    			unset($notifications[$key]);
	    		}
	    	}
	    }else{
	    	$request->course = null;
	    }

	    if($request->type != 'Select Type'){
	    	foreach ($notifications as $key => $noti) {
	    		if($noti->activity_name != $request->type){
	    			unset($notifications[$key]);
	    		}
	    	}
	    }else{
	    	$request->type = null;
	    }


	    if($request->from_date != null){
	    	foreach ($notifications as $key => $noti) {
	    		$notif = \Carbon\Carbon::parse($noti->activity_time)->format('Y-m-d');
	    		if($notif <= $request->from_date){
	    			unset($notifications[$key]);
	    		}
	    	}
	    }
	    // dd($notifications);

	    if($request->to_date != null){

	    	foreach ($notifications as $key => $noti) {
	    		$notif = \Carbon\Carbon::parse($noti->activity_time)->format('Y-m-d');
	    		if($notif >= $request->to_date){
	    			unset($notifications[$key]);
	    		}
	    	}
	    }


		

	     $course = $request->course;
	     $type = $request->type;
	     $from_date = $request->from_date;
	     $to_date = $request->to_date;

		return view('notifications.index',compact('notifications','course','type','from_date','to_date'));
	}
}