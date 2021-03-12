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
        $guides = DB::table('userguides')->orderBy('id', 'desc')->take(4)->get();
        return view ('user_guide.index', compact('guides'));
    }
    // public function create()
    // {

    //     return view ('user_guide.index', compact('user'));
    // }
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
        return view ('user_guide.index');
    }
    public function edit($id)
    {
    	dd('sdfdsfsad');
        return view ('user_guide.index', compact('user'));
    }
    public function update(Request $request)
    {
    	dd('sdfdsfsad');
        return view ('user_guide.index', compact('user'));
    }
    public function destroy(Request $request)
    {
    	dd('sdfdsfsad');
        return view ('user_guide.index', compact('user'));
    }
}
