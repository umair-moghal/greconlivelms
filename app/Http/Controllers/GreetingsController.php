<?php

namespace App\Http\Controllers;

use App\greetings;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class GreetingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $greetings = DB::table('greetings')->get()->all();
        return view('/greetings.index', compact('greetings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/greetings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'title'=>'required',
            'description'=>'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $image = $request->file('image');

        $imageName = time().'.'.$image->getClientOriginalName();

        $request->image->move(public_path() .'/assets/img/upload', $imageName);

        $greetings = DB::table('greetings')->insert([

        'title' => $request->title,

        'description'=> $request->description,

        'image'=> $imageName,
        
        ]);

        if($greetings){

            return redirect('/greetings/index')->with('message', 'Greeting message created successfully');
    
            }else{
    
            Session::flash('message', 'Something went wrong');
    
            return back();
            }

 }

    /**
     * Display the specified resource.
     *
     * @param  \App\greetings  $greetings
     * @return \Illuminate\Http\Response
     */
    public function show(greetings $greetings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\greetings  $greetings
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $greeting = DB::table('greetings')->where('id',$id)->first();
        return view('greetings.edit', compact('greeting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\greetings  $greetings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'title'=>'required|max:50',
            'description'=>'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($files = $request->file('image')) {
        $path="assets/img/upload/$request->image";
        File::delete($path);
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalName();
        $request->image->move(public_path() .'/assets/img/upload', $imageName);
        $greetings = DB::table('greetings')->where('id', $id)->update([
            'title' => $request->title,
            'description'=> $request->description,
            'image'=> $imageName,
            ]);
        }else {
        $greetings = DB::table('greetings')->where('id', $id)->update([
             'title' => $request->title,
             'description'=> $request->description,
            ]);
        }
        if($request){
        return redirect('/greetings/index')->with('message', 'Greeting Successfully Update');
        }else{
        Session::flash('message', 'Something went wrong');
        return back();
        }
    
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\greetings  $greetings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id = $request->id;

        $greeting = DB::table('greetings')->where('id',$id)->get()->first();

        DB::table('greetings')->where('id',$id)->delete();
    }
}
