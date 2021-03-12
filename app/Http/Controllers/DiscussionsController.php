<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Discussion;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Session;

use DB;

class DiscussionsController extends Controller

{

    public function index(){

        

         $user = Auth::user()->id;

          if(auth()->user()->role_id != '5'){

            $assigned_permissions =array();

            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');

            if(auth()->user()->role_id == '4')
            {
                $data = DB::table('module_permissions_store_instructors')->where('user_id' , $user)->pluck('allowed_module');
            }

            if($data != null){

                 foreach ($data as $value) {

                $assigned_permissions = explode(',',$value);

                 

            }

            }

            if(!in_array('All Discussions', $assigned_permissions)){

                return redirect('dashboard');

            }

          }

            

            

        $discussions = Discussion::all();

        $user = Auth::user();

        return view ('discussions.index', ['discussions'=>$discussions], compact('user'));

    }



    public function create(){

            $user = Auth::user()->id;

            $assigned_permissions =array();

            $data = DB::table('module_permissions_store_instructors')->where('user_id' , $user)->pluck('allowed_module');



            if($data != null){

                 foreach ($data as $value) {

                $assigned_permissions = explode(',',$value);

                 

            }

            }

            if(!in_array('Add Discussion', $assigned_permissions)){

                return redirect('dashboard');

            }

            

            

        $user = Auth::user();

    	return view ('discussions.create', compact('user'));

    }



    public function store(Request $request){

        $this->validate($request, [

            'title'=>'required|min:3|max:255',

            'image'=>'required|max:5000',

            'description'=>'required|min:10'

        ]);



        $discussion=new Discussion;



        $image = $request->file('image');

        $imageName = time().'.'.$image->getClientOriginalName();  

        $image->move(public_path('assets/img/discussions'), $imageName);



        $discussion->title=$request->title;

        $discussion->image=$imageName;

        $discussion->description=$request->description;

        $discussion->save();

        Session::flash('message', 'Successfully Saved');

        return redirect('/discussions');

    }



    public function destroy(Request $request){

        $id = $request->input("id");

        $discussion = Discussion::find($id);

        $path="assets/img/discussions/$discussion->image";

        File::delete($path);

        $discussion->delete();

    }



    public function edit($id){

        $discussion = Discussion::find($id);

        $user = Auth::user();

    	return view ('discussions.edit', ['discussion'=>$discussion], compact('user'));

    }



    public function update($id, Request $request){

        $discussion = Discussion::find($id);

        

        $this->validate($request, [

            'title'=>'required|min:3|max:255',

            'image'=>'max:5000',

            'description'=>'required|min:10'

        ]);



        if ($files = $request->file('image')) {

            $path="assets/img/discussions/$discussion->image";

            File::delete($path);

            $image = $request->file('image');

            $imageName = time().'.'.$image->getClientOriginalName();  

            $image->move(public_path('assets/img/discussions'), $imageName);

           }

           else{

            $imageName = $discussion->image;

           }

        

        $discussion->title=$request->title;

        $discussion->image=$imageName;

        $discussion->description=$request->description;

        $discussion->save();

        Session::flash('message', 'Successfully Updated');

        return redirect('/discussions');

    }

}

