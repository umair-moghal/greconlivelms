<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Setting;
class SettingsController extends Controller
{
    public function setting()
    {
        $user = Auth::user();
        $setting = Setting::get()->first();
        return view('settings.settings', compact('setting','user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
        'fb' => 'required',
        'twitter' => 'required',
        'youtube' => 'required',
        'contact'=>'required|email|max:255',
        'Noti'=>'required|email|max:255',
        'phone' => 'required'
        ]);

        $data=Setting::where('id', 1)->first();
        $data->facebook_url=$request->input('fb');
        $data->twitter_url=$request->input('twitter');
        $data->youtube_url=$request->input('youtube');
        $data->contact_email=$request->input('contact');
        $data->notification_email=$request->input('Noti');
        $data->phone_number=$request->input('phone');
        $data->save();
        Session::flash('message', 'Updated Successfully');
        return redirect('/setting');
    }
}