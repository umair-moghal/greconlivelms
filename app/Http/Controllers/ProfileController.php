<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;



class ProfileController extends Controller

{

    public function show_profile()

    {

    	$user = Auth::user();

    	return view ('profile.show', compact('user'));

    }



    public function updatecontact(Request $request)

    {
        //dd($request);
        $user = User::find($request->id);

        $this->validate($request, [

            'contact' => 'required',

        ]);

        $data = User::find($request->id);

        $data->contact=$request->input('contact');

        $data->save();

        Session::flash('message', 'Updated  successfully');

        return redirect('/showprofile');

    }



    public function edit_profile()

    {

    	$user = Auth::user();

        // $password = Crypt::decrypt($user->password);

    	return view ('profile.edit', compact('user'));

    }



    public function updateprofile(Request $request, $id)

    {

        // dd($request->file('image'));
    	$user = User::find($id);

    	$this->validate($request, [

            'name' => 'required|min:2|max:20',

            'contact' => 'required',

            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            

        ]);

    	if ($files = $request->file('image')) {

	    	$name=$files->getClientOriginalName();

	        $image = time().'.'.$request->image->getClientOriginalExtension();

	        $request->image->move(public_path() .'/assets/img/upload', $image);

	       }

       else{

       	$image = $user->image;

       }
       if($request->input('oldpassword'))
       {

       	$this->validate($request, [

            'password' => 'required',
        ]);

        $oldpassword = $request->oldpassword;
        $opass = Hash::make($oldpassword);

        $u = DB::table('users')->where('id', $id)->first();
        if(Hash::check($request->oldpassword, $u->password))
        {
            if($request->input('password'))

               {

                $this->validate($request, [

                    'password' => 'required|confirmed',

                ]);

                $password=$request->input('password');

               }    

                else 
                {
                    $user = User::find($id);

                    $password = $user->password;

                }

                 $data = User::find($id);

		        $data->name=$request->input('name');

		        $data->email=$request->input('email');

		        $data->contact=$request->input('contact');

		        $data->password=$password;

		        $data->bio=$request->input('bio');

		        $data->image = $image;

		        $data->save();

		        Session::flash('message', 'Updated  successfully');

		        return redirect('/showprofile');

   			}
	        else
	        {
	            Session::flash('message', 'Old password does not match');

	            return redirect('/editprofile');
	        }
       }
       else
       {

       	if($request->input('password'))

	       {

	        $this->validate($request, [

	            'password' => 'required|confirmed',

	        ]);

	        $password=$request->input('password');

	       }    

        else {
            $user = User::find($id);

            $password = $user->password;

            }

       	$data = User::find($id);

        $data->name=$request->input('name');

        $data->email=$request->input('email');

        $data->contact=$request->input('contact');

        $data->password=$password;

        $data->bio=$request->input('bio');

        $data->image = $image;

        $data->save();

        Session::flash('message', 'Updated  successfully');

        return redirect('/showprofile');

       }




    }

}

