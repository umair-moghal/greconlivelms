<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

class UserGuideController extends Controller
{
    public function index()
    {
        $guides = DB::table('userguides')->orderBy('id', 'desc')->take(4)->get()->all();

        return view ('user_guide.index', compact('guides'));
    }
   
    public function store(Request $request)
    {

    	if ($file = $request->file('image')) {

            $name=$file->getClientOriginalName();

            $image = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path() .'/assets/img/upload', $image);

            

       }
    	$user_guide = array(
    		 'image' => $image,
    		 'title' => $request->title,
    		 'description' => $request->description,
    	);
    	DB::table('userguides')->insert($user_guide);
        Session::flash('message', 'User Guide Created.');

        return redirect('/userguide');
    }
    
    public function update(Request $request)
    {

        $userguide = DB::table('userguides')->where('id', $request->guide)->get()->first();

        if ($files = $request->file('image')) 
        {

            $path="assets/img/upload/$userguide->image";

            @unlink($path);

            $name=$files->getClientOriginalName();

            $image = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path() .'/assets/img/upload', $image);

           }

        else
        {

            $image = $userguide->image;

        }
        DB::table('userguides')->where('id', $request->guide)->update([

                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image' => $image,
            ]);

        Session::flash('message', 'User Guide Updated.');

        return redirect('/userguide');
    }

    public function destroy(Request $request)
    {
    	dd('sdfdsfsad');
        return view ('user_guide.index', compact('user'));
    }
}
