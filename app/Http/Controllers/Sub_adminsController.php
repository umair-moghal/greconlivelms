<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Password;

use SweetAlert;

use Illuminate\Support\Facades\Mail;

use Alert;

use Input;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;

use App\User;

use App\Sub_admin;

class Sub_adminsController extends Controller
{

    public function create()

    {

    	$user = Auth::user();

    	return view ('sub_admin.create', compact('user'));

    }

    public function store(Request $request)

    { 

        
        $this->validate($request, [

            'email' => 'required|unique:users|email',
            'sa_name' => 'required',
            'contact' => 'required',
            'details' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required_with:password|same:password',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',

        ]);


        if ($files = $request->file('image')) {

            $image = $request->file('image');

            $imageName = time().'_'.$image->getClientOriginalName();

            $path = public_path('public/assets/img/upload/');

            $request->image->move($path, $imageName);

        }

        $sbadmns = new User();
        
        $sbadmns->image=$imageName;

        $sbadmns->name=$request->sa_name;

        $sbadmns->role_id=2;

        $sbadmns->email=$request->email;

        $sbadmns->contact=$request->contact;

        $sbadmns->bio=$request->details;

        $sbadmns->password = Hash::make($request['password']);

        $sbadmns->save();


        DB::table('users')->where('id' , $sbadmns->id)->update([
            'unique_id' => $sbadmns->name . '' . $sbadmns->id,
        ]);
      
     

            Session::flash('message', 'Sub Admin create successfully');

            return redirect('/subadmin/show');

       


        

    }



    public function show()

    {
        $sbadmns = DB::table('users')->where('role_id', 2)->get()->all();

        return view('sub_admin.index', compact('sbadmns'));

    }

    
    public function edit($id)

    {

    	$user = Auth::user();

        $sbadmn = DB::table('users')->where('id',$id)->first();

        return view('sub_admin.edit', compact('sbadmn', 'user'));

    }

    public function update(Request $request, $id){

        $sbadmn = User::find($id);

        $this->validate($request, [

            'email' => 'required|string|email|max:255|unique:users,email,'.$sbadmn->id,
            'sa_name' => 'required',
            'contact' => 'required',
            'details' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',

        ]);

        if ($files = $request->file('image')) {

            $path= public_path('public/assets/img/upload/'.$sbadmn->image);

            $image = $request->file('image');

            $imageName = time().'.'.$image->getClientOriginalName();  

            $image->move(public_path('public/assets/img/upload'), $imageName);

        }

        else{

            $imageName = $sbadmn->image;

        }

        $sbadmn->image=$imageName;

        $sbadmn->name=$request->sa_name;

        // $sbadmn->role_id=$request->role;

        $sbadmn->email=$request->email;

        $sbadmn->contact=$request->contact;

        $sbadmn->bio=$request->details;

        $sbadmn->save();

        if($sbadmn){

        return redirect('/subadmin/show')->with('message', 'Successfully Updated');

        }else{

        Session::flash('message', 'Something went wrong');

        return back();
        }



    }


    public function destroy(Request $request)

    {

        $id = $request->id;

        $sa = DB::table('users')->where('id',$id)->get()->first();

        DB::table('users')->where('id',$id)->delete();
    }

}
