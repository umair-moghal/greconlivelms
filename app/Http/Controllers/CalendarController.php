<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use calendar;

class CalendarController extends Controller
{
    public function index($type = 'School Calendar')
    {

        $user = Auth::user();


        $school_id = 0;
        if(auth()->user()->role_id == 1){
            $school_id = 0;
        }elseif (auth()->user()->role_id == 3) {
            $school_id = DB::table('schools')->where('sch_u_id',auth()->user()->id)->pluck('id')->first();
        }
        elseif (auth()->user()->role_id == 4) {
           $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();
        }

        $events = DB::table('calendar_events')->where('school_id',$school_id)->orWhere('school_id',0)->get();
        // $events = DB::table('calendar_events')->where('type',$type)->get();

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

        
        $calendar = \Calendar::addEvents($cal_events);
        // return view ('dashboard', compact('user','calendar'));
        return view ('calendar.index', compact('user','calendar'));
    }


     public function index_post($type)
    {
        $user = Auth::user();

        $school_id = 0;
        if(auth()->user()->role_id == 1){
            $school_id = 0;
        }elseif (auth()->user()->role_id == 3) {
            $school_id = DB::table('schools')->where('sch_u_id',auth()->user()->id)->pluck('id')->first();
        }
        elseif (auth()->user()->role_id == 4) {
           $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();
        }

        $events = DB::table('calendar_events')->where('type',$type)->where('school_id',$school_id)->orWhere('school_id',0)->get();

        // $events = DB::table('calendar_events')->where('type',$type)->get();

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
        return view ('calendar.index', compact('user','calendar','type'));
    }

   

    public function add_event_from_calendar(Request $request)
    {
        if(auth()->user()->role_id == 1){
            $type = 'US Holidays';
        }elseif (auth()->user()->role_id == 3) {
           $type = 'Events';
        }elseif (auth()->user()->role_id == 4) {
           $type = 'Live Instructor Schedule';
        }else{
            return redirect()->back();
        }

        $school_id = 0;
            if(auth()->user()->role_id == 1){
                $school_id = 0;
            }elseif (auth()->user()->role_id == 3) {
                $school_id = DB::table('schools')->where('sch_u_id',auth()->user()->id)->pluck('id')->first();
            }
            elseif (auth()->user()->role_id == 4) {
               $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();
            }

        $event = array(
            'event_name' => $request->event_name,
            'event_description' => $request->event_description,
            'start_date' => $request->event_start,
            'end_date' => $request->event_end,
            'type' => $type,
            'school_id' => $school_id,
            'created_by' => auth()->user()->id,
        );

        $success = DB::table('calendar_events')->insert($event);
        if($success)
        {
            $school_id = 0;
            if(auth()->user()->role_id == 1){
                $school_id = 0;

               
                     DB::table('activities')->insert([
                        'title' => $request->event_name . ' Notification',
                        'description' => $request->event_name . ' US Holiday Notification',
                        'created_by' => auth()->user()->id,
                        'school_id' => $school_id,
                        'activity_name' => 'US Holiday',
                        'activity_for' => 3,                        
                        'activity_time' => $request->event_start,
                        'link' => '/calendar',
                    ]);
            

            }elseif (auth()->user()->role_id == 3) {

                $school_id = DB::table('schools')->where('sch_u_id',auth()->user()->id)->pluck('id')->first();
               
                     DB::table('activities')->insert([
                        'title' => $request->event_name . ' Notification',
                        'description' => $request->event_name . ' Event Notification',
                        'created_by' => auth()->user()->id,
                        'school_id' => $school_id,
                        'activity_name' => 'Events',
                        'activity_for' => 2,                        
                        'activity_time' => $request->event_start,
                        'link' => '/calendar',
                    ]);
            }
            elseif (auth()->user()->role_id == 4) {
               $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();

                // Instructor needs to have a dropdown to select course against which
               // notification will be generated

                $course_id = DB::table('courses')->where('ins_id',auth()->user()->id)->pluck('id')->first();

                DB::table('activities')->insert([
                        'title' => $request->event_name . ' Notification',
                        'description' => $request->event_name . ' Instructor Notification',
                        'created_by' => auth()->user()->id,
                        'school_id' => $school_id,
                        'activity_name' => 'Instructor',
                        'course_id' => $course_id,
                        'activity_for' => 1,                        
                        'activity_time' => $request->event_start,
                        'link' => '/studentcourses',
                    ]);
                // Link will be updated with course id and class id
            }
            
           

            Session::flash('message', 'Event created  successfully');
            $events = DB::table('calendar_events')->where('type',$request->event_type)->get();
                    $user = Auth::user();
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

                    $type = $request->event_type;
                   
                    
                        return redirect('/dashboard/'.$type);
                   
                   
        }
        else
        {
            Session::flash('message', 'Something went wrong');

            return redirect()->back();
        }
    }
}