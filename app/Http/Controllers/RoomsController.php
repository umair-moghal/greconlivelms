<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class RoomsController extends Controller
{
    public function index(){
        $rooms = Room::all();
        $user = Auth::user();
        return view ('rooms.index', ['rooms'=>$rooms], compact('user'));
    }

    public function create(){
        $user = Auth::user();
        return view ('rooms.create', compact('user'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'name'=>'required|min:3|max:255',
            'room_no'=>'required|min:1|max:25',
            'floor_no'=>'required|min:1|max:25',
        ]);

        $room=new Room;
        $room->name=$request->name;
        $room->room_no=$request->room_no;
        $room->floor_no=$request->floor_no;
        $room->save();
        Session::flash('message', 'Successfully Saved');
        return redirect('/rooms');
    }
    
    public function destroy(Request $request){
        $id = $request->input("id");
        $room = Room::find($id);
        $room->delete();
    }
   
    public function edit($id){
        $room = Room::find($id);
        $user = Auth::user();
        return view ('rooms.edit', ['room'=>$room], compact('user'));
    }

    public function update($id, Request $request){
        $room = Room::find($id);
        
        $this->validate($request, [
            'name'=>'required|min:3|max:255',
            'room_no'=>'required|min:1|max:25',
            'floor_no'=>'required|min:1|max:25',
        ]);

        $room->name=$request->name;
        $room->room_no=$request->room_no;
        $room->floor_no=$request->floor_no;
        $room->save();
        Session::flash('message', 'Successfully Updated');
        return redirect('/rooms');
    }

}