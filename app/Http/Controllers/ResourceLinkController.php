<?php



namespace App\Http\Controllers;



use App\ResourceLink;

use App\Course;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;



class ResourceLinkController extends Controller

{

    public function index($id){

        $id = $id;

        $user = Auth::user();

        $cresources=DB::table('resources')->where('course_id', $id)->get()->all();

        

        return view ('course_resources.index', compact ('user','cresources', 'id'));

    }



    public function resourcevideo($id){

        $id = $id;

        $user = Auth::user();

        $cresources=DB::table('resources')->where('course_id', $id)->get()->all();

        return view ('course_resources.videos', compact ('user','cresources', 'id'));

    }



    public function resourcelink($id){

        $id = $id;

        $user = Auth::user();

        $cresources=DB::table('resources')->where('course_id', $id)->get()->all();

        return view ('course_resources.links', compact ('user','cresources', 'id'));

    }

    public function Store(Request $req){

        //dd($req);

        $this->validate($req,

         [

        'title'=>'required|min:3|max:20',

        'short_des'=>'required|min:10|max:5000',

        'link'=>'required',

    ]);

        $cress= new CourseResources;

        $cress->course_id=$req->input('course_id');

        $cress->title=$req->input('title');

        $cress->short_description=$req->input('short_des');

        $file = $req->file('file');

        $fileName = time().'.'.$file->getClientOriginalName();

        $file->move(public_path('storage/'), $fileName);

        $cress->file=$fileName;

        $fileType =$file->getClientOriginalExtension();

        $cress->type=$fileType;

        $cress->resource=$req->input('resource');

        $cress->save();

        $id = $req->input('course_id');

        if($cress){

            Session::flash('message', 'Resource Stored Successfully');

            return redirect('/courseresourse/'.$id);

        }

    }



    public function edit($id){

        $id = $id;

        $cress = CourseResources::find($id);

        $user = Auth::user();

    	return view ('course_resources.edit', compact('user', 'cress', 'id'));

    }



    public function update($id, Request $request){



        $this->validate($request, [

            'title'=>'required|min:3|max:20',

            'short_des'=>'required|min:10|max:5000',

            'link'=>'required',

        ]);



        $cress = CourseResources::find($id);

        $user = Auth::user();   

        if ($files = $request->file('file')) {

            $path="storage/$cress->file";

            File::delete($path);

            $file = $request->file('file');

            $fileName = time().'.'.$file->getClientOriginalName();  

            $file->move(public_path('storage/'), $fileName);

            $fileType =$file->getClientOriginalExtension();

        }

        else{

            $fileName = $cress->file;

            $fileType = $cress->type;

        }

        $cress->course_id=$request->input('course_id');

        $cress->title=$request->input('title');

        $cress->short_description=$request->input('short_des');

        $cress->file=$fileName;

        $cress->type=$fileType;

        $cress->resource=$request->input('resource');

        $cress->save();

        $id = $request->input('course_id');

        Session::flash('message', 'Resource Updated Successfully');

        return redirect('/courseresourse/'.$id);        

    }



    public function deleteres(Request $request)

    {

        $id = $request->input("id");

        CourseResources::where("id", $id)->delete();

    }



    // public function download($id){

    //     $cress = CourseResources::find($id);

    //     $path='http://127.0.0.1:8000/storage/';

    //     return response()->download(public_path('/storage/'. $cress->file));

    //     return Storage::download($path, $cress->file);

    // }



    // public function resources()

    // {

    //     $user = Auth::user();

    //     $cress=DB::table('resources')->get()->all();

    //     return view ('course_resources.index', compact ('user','cress'));

    // }

}

