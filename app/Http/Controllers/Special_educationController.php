<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Session;

class Special_educationController extends Controller
{
   

    public function index($id){

        $special= DB::table('special_educations')->where('student_id',$id)->get();
		$student= DB::table('students')->where('id',$id)->select('last_name','record_no')->first();
       
		return view('special_education.index',compact('special','student'));
    }


    public function create($id){
        
		
        return view('special_education.create',compact('id'));
    }

    public function Store(Request $request){

        // dd($request);

        $this->validate($request, [

            'file' => 'mimes:doc,docx,ppt,pptx,pdf,mp4,wmv|max:2048',
            // 'parent_comments' => 'required',
            // 'text_information' => 'required',
            //'signature' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);


        // dd($request);



            $file = $request->file('file');

            $fileName = time().'.'.$file->getClientOriginalName();

            $file->move(public_path() .'/assets/img/upload', $fileName);

            $fileType = $file->getClientOriginalExtension();

            //$image = $request->file('image');

           // $imageName = time().'.'.$image->getClientOriginalName();

            //$request->image->move(public_path() .'/assets/img/upload', $imageName);

            // $students = DB::table('students')->where('s_u_id', auth()->user()->id)->get()->first();

            $schools = DB::table('schools')->where('sch_u_id', auth()->user()->id)->get()->first();

            $special_educations = DB::table('special_educations')->insert([
            
             'student_id' => $request->student_id,
            'upload_file' => $fileName,
            'parent_comments' => $request->comments,
            //'signature'=> $imageName,
            //'text_information'=> $request->text,
            'type' => $fileType,
            ]);

        if($special_educations){

            return redirect('/students')->with('message', 'Successfully Saved');
    
            }else{
    
            Session::flash('message', 'Something went wrong');
    
            return back();
            }

 }

    
    public function edit($id)

    {

        $user = Auth::user();

        $special_education = DB::table('special_educations')->where('id',$id)->first();

        return view('special_education.edit', compact('special_education', 'user'));

    }


    public function update(Request $request, $id){

        $this->validate($request, [

            'file' => 'max:10000|mimes:doc,docx,ppt,pptx,pdf,mp4,wmv|max:2048',
            'parent_comments' => 'required',
            'text_information' => 'required',
            'signature' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        // dd($request);  

        $path="assets/img/upload/$request->upload_file";

        File::delete($path);

        $file = $request->file('file');

        $fileName = time().'.'.$file->getClientOriginalName();

        $file->move(public_path() .'/assets/img/upload', $fileName);

        $fileType = $file->getClientOriginalExtension();

        

        $special_educations = DB::table('special_educations')->where('id', $id)->update([

        // 'student_id' => $students->s_u_id,
        'upload_file' =>  $fileName,
        'parent_comments' => $request->comments,
        
        'type' => $fileType,
        ]);


        // dd($special_educations);

        // $special_educations = DB::table('special_educations')->update([
        //     'student_id' => $students->s_u_id,
        //     'upload_file' => $fileName,
        //     'parent_comments' => $request->comments,
        //     'signature'=> $imageName,
        //     'text_information'=> $request->text,
        //     'type' => $fileType,
        //     ]);

        if($special_educations){

        return redirect('/special_education/index')->with('message', 'Successfully Update');

        }else{

        Session::flash('message', 'Something went wrong');

        return back();

    }



}

public function show($id)

    {

        // dd($id);

        // $user = Auth::user();

        

        // $special_education = DB::table('special_educations')->where('id',$id)->get()->first();

        // return view('special_education.show', compact('special_education', 'user'));

        $user = Auth::user();

        $special_education = DB::table('special_educations')->where('student_id',$id)->first();

        // dd($special_education);

        return view('special_education.show', compact('special_education', 'user'));

    }


    public function destroy(Request $request)

    {


        $id = $request->id;

        $sa = DB::table('special_educations')->where('id',$id)->get()->first();

        DB::table('special_educations')->where('id',$id)->delete();

        return view('/dashboard');

    }

    public function download($id){

        $special_educations = DB::table('special_educations')->where('id',$id)->get()->first();

        $path=' http://grecon.stepinnsolution.com/assets/img/upload/';

        // dd($special_educations);

        // http://grecon.stepinnsolution.com/assets/img/upload/1611311457_aaa.pdf

        return response()->download(public_path('/assets/img/upload/'. $special_educations->upload_file));

        // return Storage::download($path, $special_educations->file);

    }

    // public function notify(){

    //     $special= DB::table('special_educations')->get();

    //     $special = DB::table('special_educations')->where('is_rejected', 0)->get()->count();

    //     $speciall = DB::table('special_educations')->where('is_rejected', 0)->get();
        
    //     // @foreach($speciall as $sp)
    //     //   <a class="dropdown-item" href="#">{{DB::table('users')->where('id' , $sp->student_id)->pluck('name')->first()}}  responded to your email</a>
    //     // @endforeach
    // }

}
