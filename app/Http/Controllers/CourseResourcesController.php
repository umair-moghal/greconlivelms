<?php



namespace App\Http\Controllers;



use App\CourseResources;

use App\Course;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

use Carbon\Carbon;





class CourseResourcesController extends Controller

{

    public function index($insid, $cid, $week, $clasid){
        $course_id = $cid;

        $user = Auth::user();

        $instructor_id = $insid;

        $week = $week;

        $cresources=DB::table('resources')->where('course_id', $cid)->orderBy('id', 'desc')->get()->all();

        return view ('course_resources.index', compact ('user','cresources', 'course_id', 'week', 'instructor_id', 'clasid'));

    }



    public function resourcevideo($id){

        $id = $id;

        $user = Auth::user();

        $cresources=DB::table('resources')->where('course_id', $id)->get()->all();

        return view ('course_resources.videos', compact ('user','cresources', 'id'));

    }



    public function resourcevideos($insid, $cid, $week, $clasid){
        // dd('videos');



        $course_id = $cid;

        $user = Auth::user();
        $instructor_id = $insid;
        $week = $week;

        $cresources=DB::table('resources')->where('course_id', $cid)->get()->all();

        return view ('course_resources.videos', compact ('user','cresources', 'course_id', 'week', 'instructor_id', 'clasid'));

    }



    public function Storefile(Request $req)
    {

        $this->validate($req,

         [

        'file' => 'max:10000|mimes:doc,docx,ppt,pptx,txt,pdf|max:2048',

        'title'=>'required|min:3|max:20',

        'short_des'=>'required|min:10|max:5000',

    ]);

        $cress= new CourseResources;

        $cress->course_id=$req->input('course_id');

        $cress->instructor_id=$req->input('instructor_id');

        $cress->week=$req->input('week');

        $cress->day=$req->input('day');

        $cress->title=$req->input('title');

        $cress->short_description=$req->input('short_des');

        $file = $req->file('file');

        $fileName = time().'.'.$file->getClientOriginalName();

        $file->move(public_path('storage/'), $fileName);

        $cress->file=$fileName;

        $fileType =$file->getClientOriginalExtension();

        $cress->type=$fileType;

        $cress->save();

        $course_name = DB::table('courses')->where('id',$req->course_id)->pluck('course_name')->first();

        // if(isset($req->send_notification)){
        //     $std_ids = DB::table('course_students')->where('course_id',$req->course_id)->get()->pluck('student_id');
        //     foreach ($std_ids as $key => $std_id) {
        //        DB::table('notifications')->insert([
        //         'description' => 'Resource Added To '. $course_name,
        //         'created_by' => Auth::user()->id,
        //         'reciever' => $std_id,
        //         'type' => 'Resource Update',
        //       ]);
        //     }
           
        // }
    if(isset($req->send_notification)){
         DB::table('activities')->insert([
                        'title' => 'Resource Added Notification',
                        'description' => 'File Added To '. $course_name.' Notification',
                        'created_by' => auth()->user()->id,
                        'activity_name' => 'Resource',
                        'course_id' => $req->course_id,
                        'activity_for' => 1,                        
                        'activity_time' => Carbon::now(),
                        'link' => '/studentcourses',
        ]);
     }

        $id = $req->input('course_id');

        if($cress){

            Session::flash('message', 'File Stored Successfully');

            return redirect('/course/show_week_details/'. $req->instructor_id .'/'. $req->course_id .'/'. $req->week  .'/'. $req->class);

        }

    }



    public function Storevid(Request $req)
    {

        $this->validate($req,[

        'video' => 'max:2048|mimes:mp4,wmv',

        'title'=>'required|min:3|max:20',

        'short_des'=>'required|min:10|max:5000',

    ]);

        $cress= new CourseResources;

        $cress->course_id=$req->input('course_id');

        $cress->week=$req->input('week');

        $cress->instructor_id=$req->input('instructor_id');

        $cress->title=$req->input('title');

        $cress->day=$req->input('day');

        $cress->short_description=$req->input('short_des');

        if ($files = $req->file('video')) {


        $file = $req->file('video');

        $fileName = time().'.'.$file->getClientOriginalName();

        $file->move(public_path('storage/'), $fileName);

        $cress->file=$fileName;

        $fileType =$file->getClientOriginalExtension();

        $cress->type=$fileType;

        }
        else

        $cress->link=$req->input('link');

        $cress->save();

        $course_name = DB::table('courses')->where('id',$req->course_id)->pluck('course_name')->first();

        if(isset($req->send_notification)){
         DB::table('activities')->insert([
                'title' => 'Resource Added Notification',
                'description' => 'Video Added To '. $course_name.' Notification',
                'created_by' => auth()->user()->id,
                'activity_name' => 'Resource',
                'course_id' => $req->course_id,
                'activity_for' => 1,                        
                'activity_time' => Carbon::now(),
                'link' => '/studentcourses',
        ]);
     }

        $id = $req->input('course_id');

        if($cress){

            // dd($cress);

            Session::flash('message', 'Course Video Successfully');

            return redirect('/course/show_week_details/'. $req->instructor_id .'/'. $req->course_id .'/'. $req->week .'/'. $req->class);

        }

    }



    public function editfile($id, $main){

        $id = $id;

        $cress = CourseResources::find($id);

        $user = Auth::user();

        $week = $cress->week;

        $course_id = $main;

        $instructor_id = Auth::user()->id;

    	return view ('course_resources.edit', compact('user', 'cress', 'id', 'course_id', 'instructor_id', 'week'));

    }





    public function editvid($id, $main, $clasid)
    {

        $id = $id;

        $cress = CourseResources::find($id);

        $week = $cress->week;

        $course_id = $main;

        $instructor_id = Auth::user()->id;

    	return view ('course_resources.editvid', compact('cress', 'id', 'course_id', 'instructor_id', 'week', 'clasid'));

    }



    public function updateres($id, Request $request){



        $this->validate($request, [

            'file' => 'max:2048|mimes:doc,docx,ppt,pptx,rtf,pdf|max:2048',

            'title'=>'required|min:3|max:20',

            'short_des'=>'required|min:10|max:5000',

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

        $cress->title=$request->input('title');

        $cress->short_description=$request->input('short_des');

        $cress->week=$request->input('week');

        $cress->day=$request->input('day');

        $cress->course_id=$request->input('course_id');

        $cress->instructor_id=$request->input('instructor_id');

        $cress->file=$fileName;

        $cress->type=$fileType;

        $cress->save();

        $course_name = DB::table('courses')->where('id',$request->course_id)->pluck('course_name')->first();
        
        if(isset($request->send_notification)){
         DB::table('activities')->insert([
                'title' => 'Resource Added Notification',
                'description' => 'Resource Added To '. $course_name.' Notification',
                'created_by' => auth()->user()->id,
                'activity_name' => 'Resource',
                'course_id' => $request->course_id,
                'activity_for' => 1,                        
                'activity_time' => Carbon::now(),
                'link' => '/studentcourses',
        ]);
     }

        Session::flash('message', 'File Updated Successfully');

        return redirect('/course/show_week_details/'. $request->instructor_id .'/'. $request->course_id .'/'. $request->week);         

    }





    public function updatevid(Request $request)
    {
        // dd($request->all());

        $this->validate($request, ['video' => 'max:2048|mimes:mp4,wmv',

            'title'=>'required|min:3|max:20',

            'short_des'=>'required|min:10|max:5000',

        ]);



        $cress = CourseResources::find($request->id);

        $user = Auth::user();   

        $cress->title=$request->input('title');

        $cress->short_description=$request->input('short_des');

        if ($files = $request->file('video')) {

            $path="storage/$cress->file";

            File::delete($path);

            $file = $request->file('video');

            $fileName = time().'.'.$file->getClientOriginalName();  

            $file->move(public_path('storage/'), $fileName);

            $fileType =$file->getClientOriginalExtension();

        }

        else{

            $fileName = $cress->file;

            $fileType = $cress->type;

        }

        $cress->title=$request->input('title');

        $cress->short_description=$request->input('short_des');

        $cress->week=$request->input('week');

        $cress->day=$request->input('day');

        $cress->course_id=$request->input('course_id');

        $cress->instructor_id=$request->input('instructor_id');

        $cress->file=$fileName;

        $cress->type=$fileType;

        $cress->link=$request->input('link');

        $cress->save();

         $course_name = DB::table('courses')->where('id',$request->course_id)->pluck('course_name')->first();
        

        if(isset($request->send_notification)){
         DB::table('activities')->insert([
                'title' => 'Resource Added Notification',
                'description' => 'Video Updated To '. $course_name.' Notification',
                'created_by' => auth()->user()->id,
                'activity_name' => 'Resource',
                'course_id' => $request->course_id,
                'activity_for' => 1,                        
                'activity_time' => Carbon::now(),
                'link' => '/studentcourses',
        ]);
     }

        Session::flash('message', 'Course Video Updated Successfully');

         return redirect('/course/show_week_details/'. $request->instructor_id .'/'. $request->course_id .'/'. $request->week .'/'. $request->class);         

    }



    public function deleteres(Request $request)

    {

        $id = $request->input("id");

        $res = CourseResources::find($id);

        $path="storage/$res->file";

        File::delete($path);

        CourseResources::where("id", $id)->delete();

        

    }



    public function deletevid(Request $request)

    {

        $id = $request->input("id");

        $res = CourseResources::find($id);

        $path="storage/$res->file";

        File::delete($path);

        CourseResources::where("id", $id)->delete();



    }



    public function download($id){

        $cress = CourseResources::find($id);

        $path='http://127.0.0.1:8000/storage/';

        return response()->download(public_path('/storage/'. $cress->file));

        return Storage::download($path, $cress->file);

    }



    public function resources()

    {

        $user = Auth::user();

        $cress=DB::table('resources')->get()->all();

        return view ('course_resources.index', compact ('user','cress'));

    }

}

