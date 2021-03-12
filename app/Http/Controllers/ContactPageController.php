<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ContactPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $contact = DB::table('contactpage')->where('id', 1)->first();
        return view('pages.contact', compact('contact', 'user'));
    }
    public function update(Request $request)
    {
        $contact = DB::table('contactpage')->where('id',1)->get()->first();
        
        $this->validate($request, [
            'title'=>'required|min:1|max:50',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email'=>'required|email|max:255',
            'phno'=>'required|min:12|max:12',
            'add'=>'required|min:3|max:200'
        ]);

        if ($files = $request->file('image')) {
            $path="assets/img/upload/$contact->image";
            @unlink($path);
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalName();  
            $image->move(public_path('assets/img/upload'), $imageName);
        }
        else{
         $imageName = $contact->image;
        }
           $data = ContactPage::find(1);
            $data->title=$request->input('title');
            $data->email=$request->input('email');
            $data->address=$request->input('add');
            $data->phone=$request->input('phno');
            $data->image = $imageName;
            $data->save();
            Session::flash('message', 'Updated Successfully');
            return redirect('/contactpage');
    }
}
