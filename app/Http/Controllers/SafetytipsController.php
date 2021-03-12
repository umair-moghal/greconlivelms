<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Safetytip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SafetyTipsController extends Controller
{
    public function index(){
        $safetytips = Safetytip::all();
        $user = Auth::user();
        return view ('safetytips.index', ['safetytips'=>$safetytips], compact('user'));
    }

    public function create(){
        $user = Auth::user();
    	return view ('safetytips.create', compact('user'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'title'=>'required|min:3|max:50',
            'description'=>'required|min:10'
        ]);

        $safetytip=new Safetytip;
        $safetytip->title=$request->title;
        $safetytip->description=$request->description;
        $safetytip->save();
        Session::flash('message', 'Successfully Saved');
        return redirect('/safetytips');
    }

    public function destroy(Request $request){
        $id = $request->input("id");
        $safetytip = Safetytip::find($id);
        $safetytip->delete();
    }

    public function edit($id){
        $safetytip = Safetytip::find($id);
        $user = Auth::user();
    	return view ('safetytips.edit', ['safetytip'=>$safetytip], compact('user'));
    }

    public function update($id, Request $request){
        $safetytip = Safetytip::find($id);
        
        $this->validate($request, [
            'title'=>'required|min:3|max:50',
            'description'=>'required|min:10'
        ]);

        $safetytip->title=$request->title;
        $safetytip->description=$request->description;
        $safetytip->save();
        Session::flash('message', 'Successfully Updated');
        return redirect('/safetytips');
    }
}