<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zoom;

class ZoomController extends Controller
{
    public function create_user($f_name,$l_name,$email,$password)
    {
        $user =     Zoom::user();
        return $user->create([
            'first_name' => $f_name,
            'last_name' => $l_name,
            'email' => $email,
            'password' => $password,
            'type'=> 1
        ]);
    }

    public function  get_user($user_id)
    {
        $user =     Zoom::user();
        return $user->find($user_id);
    }

    public function user_list()
    {
        $user =     Zoom::user();
        return $user->all();
    }
    public function create_meeting($user_id,$topic)
    {

        $user = Zoom::user()->find($user_id);
        if($user->status == 'pending'){
            // dd('walla');
         return false;

        }

        $meeting = Zoom::meeting();

        $meeting = Zoom::meeting()->make([
            'topic' => $topic,
            'type' => 3,
            'password' => '123456789'
        ]);

        $meeting->recurrence()->make([
            'type' => 1,
            'repeat_interval' => 15,
            'weekly_days' => '5',
            'end_times' => 5
        ]);

        $meeting->settings()->make([
            'host_video' => true,
            'participant_video' => true,
            'join_before_host' => true,
            'approval_type' => 0,
            'enforce_login' => false,
            'waiting_room' => false
        ]);
        // dd($user->meetings()->save('asd'));
        $user->meetings()->save($meeting);
        
        return $meeting;     

    }

    public function meeting_list($user_id){
        $user = Zoom::user()->find($user_id);

        return $user->meetings()->all();
    
    }
    public function get_meeting($meeting_id){
        $meeting = Zoom::meeting();
        $m = $meeting->find($meeting_id);
        dd($m->report());
        return $meeting->find($meeting_id);
    }

    public function participants($meeting_id){
        $meeting = Zoom::meeting();
        $m = $meeting->find($meeting_id);

        dd($m);
        
    }

    // ,$f_name,$l_name,$address,$city,$country,$zip,$state,$phone,$industry,$org,$job_title

    public function add_student_to_meeting($meeting_id,$email){
        
        $meeting = Zoom::meeting()->find($meeting_id);
        $registrant = Zoom::meeting()->registrants()->make([
            "email" => $email,
            // "first_name" => '$f_name',
            // "last_name" => $l_name,
            // "address" => $address,
            // "city" => $city,
            // "country" => $country,
            // "zip" => $zip,
            // "state" => $state,
            // "phone" => $phone,
            // "industry" => $industry,
            // "org" => $org,
            // "job_title" => $job_title,
            "purchasing_time_frame" => "Within a month",
            "role_in_purchase_process" => "Influencer",
            "no_of_employees" => "1-20",
            "comments" => "Excited to host you.",
            "custom_questions" => [
                [
                "title" => "Favorite thing about Zoom",
                "value" => "Meet Happy"
                ]
            ]
            ]);
        
        return $registrant;



    }
}
