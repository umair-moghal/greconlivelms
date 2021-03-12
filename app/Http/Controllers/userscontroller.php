<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use SweetAlert;
use Illuminate\Support\Facades\Mail;
use Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use \Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

class userscontroller extends Controller
{
    public function loginpage()
    {
    	return view('users/loginpage');
    }
    public function registerpage()
    {
    	return view('users/registerpage');
    }
    
    public function registeruser(Request $request)
    {
    	if(Auth::check()){
	    	return view('users/loginpage');	
	    }
	    else{
	    	$this->validate($request, [
	            'name' => 'required|string|max:255',
	            'email' => 'required|string|email|max:255|unique:users',
	            'password' => 'required|string|min:8|confirmed',
	        ]);
	    	$user = User::create([
	            'name' => $request['name'],
	            'email' => $request['email'],
	            'password' => Hash::make($request['password']),
	        ]);
	    	if($user)
	    	{
	    		return view('dashboard');
	    	}
	    	else
	    	{
	    		return back()->with('message', 'Registration fail');
	    	}
	    }
    }
    public function loginuser(Request $request)
    {
	    	if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember')))
	    	{
	    		// SweetAlert::message('You are loggedIn successfully!');
	    		$roleId = DB::table('users')->where('email',$request['email'])->pluck('role_id')->first();
    			$user = Auth::user();
	    		Auth::login($user, $remember = true);
                $login_user = DB::table('users')->where('email',$request['email'])->first();
    			$user = DB::table('users')->where('role_id',$roleId)->first();


                $login_details = array(
                    'user_id' => $login_user->id,
                    'login_at' => \Carbon\Carbon::now(),
                );
                // dd($login_details);
                $logged_details = DB::table('user_loggings')->insert($login_details);
	    		alert('LoggedIn successfully!')->persistent("Close this");

	    		return redirect('/dashboard');
	    	}
	    	else
	    	{
	    		return back()->withErrors([
		            'email' => 'Invalid Email',
		            'password'=>'Invalid Password',
	        	]);
	    	}
    }
    public function forgetpassword()
    {
    	return view('users.email');
    }
    
    public function resetpassword()
    {
    	return view('users.reset');
    }
    public function setpassword(Request $request)
    {
    	$user = User::where('email', '=', $request->email)->first();
    	if($user == null)
    	{
    		return back()->with('message', 'Email does not exist');
	    }
    	else
    	{
    		DB::table('users')->where('email',$request->email)->update([
	                   "password" => Hash::make($request->password)
	                   ]);
	       $name = DB::table('users')->where('email',$request->email)->pluck('name')->first();
	       $password = DB::table('users')->where('email',$request->email)->pluck('password')->first();
	       $email = $request->email;
	       $email_data = array('password' => $password , 'name' => $name);
	        //$email_data = array('description' => $inputs['title'] . ' Updated.');
	        $test = Mail::send(['html'=>'users.reset'], $email_data, function($message) use($email)
	        {
	            $message->to($email)->subject('Socrai Notification: Account password is reset');
	            // $setting = DB::table('settings')->first();
	            // $message->from($setting->emial_reset_pass,'Socrai Password Reset');
	            $message->from('admin@gmail.com','Your new Password');
	        });
    	}
    }

    public function edit($id)
    {
    	$user = DB::table('users')->where('id', $id)->get()->first();
    	// dd($user->name);
    	return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
    	$user = User::find($id);
    	// $request->validate([
	    //     // 'image' => 'image|mimes:jpeg,png,jpg|max:2048',
     //    ]);
    	if ($files = $request->file('image')) {
	    	$name=$files->getClientOriginalName();
	        $image = time().'.'.$request->image->getClientOriginalExtension();
	        $request->image->move(public_path() .'\img\upload', $image);
	       }
       else{
       	$image = $user->image;
       }
        $data = User::find($id);
        $data->name=$request->input('name');
        $data->email=$request->input('email');
        $data->contact=$request->input('contact');
        $data->bio=$request->input('bio');
        $data->image = $image;
        $data->save();
        Session::flash('message', 'Updated  successfully');
        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        $url = url()->previous();
    // dd($url);

        DB::table('user_loggings')->orderby('created_at','desc')->where('user_id',Auth::user()->id)->limit(1)->update([
            'last_active_url' => $url,
            'logout_at' => \Carbon\Carbon::now(),
        ]);
        

        $u = DB::table('user_loggings')->orderby('created_at','desc')->where('user_id', Auth::user()->id)->get()->first();

        $startTime = \Carbon\Carbon::parse($u->login_at);
        $endTime = \Carbon\Carbon::parse($u->logout_at);
       
        $totalDuration = $endTime->diffInMinutes($startTime);


        DB::table('user_loggings')->orderby('created_at','desc')->where('user_id',Auth::user()->id)->update([
            'duration' => $totalDuration,
        ]);


    	Auth::logout();
  		return redirect('/');
    }

    public function loginhistory()
    {
        
        $loginhistory = DB::table('user_loggings')->where('user_id', Auth::user()->id)->get()->all();
        return view('users.loginhistory', compact('loginhistory'));
    }

}