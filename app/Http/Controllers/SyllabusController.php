<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SyllabusController extends Controller
{
    public function upload_syllabus($id)
    {
        $syllabus = DB::table('syllabus')->where('course_id', $id)->get()->all();
        return view('syllabus.index', compact('syllabus', 'id'));
    }

    public function store_syllabus(Request $request)
    {

        $this->validate($request, [
            'file' => 'max:10000|mimes:doc,docx,ppt,pptx,txt,xlsx,pdf|max:2048',

            'desc'=>'required|min:10|max:5000',
        ]);
        if ($files = $request->file('file')) {

            $name=$files->getClientOriginalName();

            $file = time().'.'.$request->file->getClientOriginalExtension();

            $request->file->move(public_path() .'/assets/img/documents/', $name);

       }
        $syllabus = array(
            'document' => $name,
            'description' => $request->desc,
			'type' => 'resource',
            'course_id' => $request->course_id,
        );
        $success = DB::table('syllabus')->insert($syllabus);

        $course_name = DB::table('courses')->where('id',$request->course_id)->pluck('course_name')->first();
        if(isset($request->send_notification)){
            $std_ids = DB::table('course_students')->where('course_id',$request->course_id)->get()->pluck('student_id');
            foreach ($std_ids as $key => $std_id) {
               DB::table('notifications')->insert([
                'description' => 'Resource Added To '. $course_name,
                'created_by' => Auth::user()->id,
                'reciever' => $std_id,
                'type' => 'Resource Update',
              ]);
            }
           
        }

        if($success)
        {
            session::flash('message', 'Syllabus uploaded successfully');
            return redirect('/upload_syllabus/'. $request->course_id);
        }
        else
        {
            session::flash('message', 'Oops! Syllabus cannot uploaded.');
            return redirect('/upload_syllabus/'. $request->course_id);
        }
    }

    public function edit($id)
    {
        $syllabus = DB::table('syllabus')->where('id', $id)->get()->first();
        return view('syllabus.edit', compact('syllabus'));
    }

    public function update($id, Request $request)
    {
        $syllabus = DB::table('syllabus')->where('id', $id)->get()->first();
        //echo '<pre>';print_r($syllabus);exit;
		$this->validate($request, [
            'file' => 'max:10000|mimes:doc,docx,ppt,pptx,txt,xlsx,pdf|max:2048',

            'desc'=>'required|min:10|max:5000',
        ]);



        if ($files = $request->file('file')) 
        {

            $path="assets/img/documents/$syllabus->document";

            @unlink($path);

            $file = $request->file('file');

            $filename = time().'.'.$file->getClientOriginalName();  

            $file->move(public_path() .'/assets/img/documents', $filename);

        }

        else
        {

            $filename = $syllabus->document;

        }


        $success = DB::table('syllabus')->where('id', $id)->update([
            'document' => $filename,
            'description' => $request->input('desc'),
        ]);

        $course_name = DB::table('courses')->where('id',$request->course_id)->pluck('course_name')->first();
        if(isset($request->send_notification)){
            $std_ids = DB::table('course_students')->where('course_id',$request->course_id)->get()->pluck('student_id');
            foreach ($std_ids as $key => $std_id) {
               DB::table('notifications')->insert([
                'description' => 'Resource Added To '. $course_name,
                'created_by' => Auth::user()->id,
                'reciever' => $std_id,
                'type' => 'Resource Update',
              ]);
            }
           
        }
        
        if($success){
            Session::flash('message', 'Syllabus Updated successfully');
             return redirect('/upload_syllabus/'. $syllabus->course_id);
        }else{
            Session::flash('message', 'Something went wrong');
            return redirect('/upload_syllabus/'. $syllabus->course_id);
        }
    }

    public function destroy(Request $request)

    {

        $id = $request->id;

        $syllabus = DB::table('syllabus')->where('id',$id)->get()->first();

        $path="assets/img/documents/$syllabus->document";

        File::delete($path);

        DB::table('syllabus')->where('id',$id)->delete();

        Session::flash('message', 'Syllabus deleted successfully');

    }   
}