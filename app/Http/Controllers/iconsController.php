<?php



namespace App\Http\Controllers;

use App\Icon;

use DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

// use Illuminate\support\Facades\DB;

//use Illuminate\support\Facades\Session;



class iconsController extends Controller

{



    public function iconpage(){

            // dd('iconpage');

            $user = auth()->user()->id;

            $assigned_permissions =array();

            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');

            // dd($data);



            if($data != null){

                 foreach ($data as $value) {

                $assigned_permissions = explode(',',$value);

                 

            }

            }

            if(!in_array('Add New Icon', $assigned_permissions)){

                return redirect('dashboard');

            }

            

        

        $user = Auth::user();

        return view ('icons.createicon', compact ('user'));

    }



    public function showicon(){

        

        $user = Auth::user()->id;

            $assigned_permissions =array();

            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');



            if($data != null){

                 foreach ($data as $value) {

                $assigned_permissions = explode(',',$value);

                 

            }

            }

            if(!in_array('Icons List', $assigned_permissions)){

                return redirect('dashboard');

            }

            

       $user = Auth::user();

        $icons = Icon::orderBy('ID', 'asc')->get();

        return view('icons.viewicon', compact('icons', 'user'));

    }



    public function createicon(Request $req){

        $this->validate($req, [

        'title'=>'required',

        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

    ]);



        $icon= new Icon;

        $icon->title=$req->input('title');



        if ($files = $req->file('image')) {

            $name=$files->getClientOriginalName();

            $image = time().'.'.$req->image->getClientOriginalExtension();

            // $request->image->move(public_path('storage/'), $image);

            $req->image->move(public_path() .'/assets/img/upload', $image);

       }
        $icon->image=$image;

        $icon->save();

        if($icon){

        // Session::flash('message', 'Successfully Saved');

        return redirect('/viewicon')->with('message','Successfully Saved');

            }

        }



    public function editicon($id)

    {

        $user = Auth::user();

        $data=Icon::where('id',$id)->get()->first();

        return view('icons.editicon',compact('data', 'user'));

    }



    public function updateicon(Request $request, $id){

        $icon = Icon::find($id);



        $this->validate($request, [

            'title'=>'required',

            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

         if ($files = $request->file('image')) {

            $path="assets/img/upload/$icon->image";

            @unlink($path);

            $name=$files->getClientOriginalName();

            $image = time().'.'.$request->image->getClientOriginalExtension();

            // $request->image->move(public_path('storage/'), $image);

            $request->image->move(public_path() .'/assets/img/upload', $image);

           }

           else{

            $image = $icon->image;

           }

        $icon->title=$request->input('title');

        $icon->image=$image;

        $icon->save();

        if($icon){

        //Session::flash('message', '');

        return redirect('/viewicon')->with('message', 'Successfully Updated');

        }



    }

        

    public function deleteicon(Request $request)

    {

        $id = $request->input("id");

        $icon = Icon::find($id);

        $path="assets/img/icons/$icon->image";

        // unlink($path);

        Icon::where("id", $id)->delete();

    }

}

    