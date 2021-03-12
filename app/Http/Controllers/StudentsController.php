<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Student;

use App\User;

use File;

use Maatwebsite\Excel\Facades\Excel;

use App\Imports\ProjectsImport;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

use Maatwebsite\Excel\Concerns\WithValidation;

use Throwable;

use Illuminate\Support\Facades\DB;



class StudentsController extends Controller

{
    public function import(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
          [
              'select_file'      => $request->select_file,
              'extension' => strtolower($request->select_file->getClientOriginalExtension()),
          ],
          [
              'select_file'          => 'required',
              'extension'      => 'required|in:xlsx,xls',
          ]
        );
        if ($validator->fails()) 
        {
             return back()->withErrors($validator);
           }

        // dd('wala');   
       // $file=$request->file('select_file')->store('import');
       //Excel::import(new ProjectsImport, request()->file('file'));
       //   (new ProjectsImport)->import($file);

          // dd($request->all());

            $curr_user_id = Auth::user()->id;
            $school_id =  Auth::user()->id;
            $check_user_role = Auth::user()->role_id;
            if($check_user_role == 4){
                $school_id = DB::table('instructor_school')->where('i_u_id' ,$curr_user_id )->pluck('sch_u_id')->first();
            }
            // dd($curr_user_id . "school_id =>>  ".$school_id);


          // $iep = $request->iep;
          $grade = $request->grade_level;

                     $iep = $request->iep;
                        if($request->iep == null){
                          $iep= '';
                        }

         $path = request()->file('select_file')->getRealPath();
         $path1 = request()->file('select_file')->store('temp'); 
         $path=storage_path('app').'/'.$path1; 

        $customerArr =  Excel::toArray(new ProjectsImport, $path);
        // excel data array
        // dd($customerArr);

        $csvArr = $customerArr[0];
        $csvArr = $csvArr;
               $ses_err_message = "";
               $imported_user_count = 0;
               $missing_entry_check = 'true';
               $sec_check = 'false';   
        // dd($csvArr);
          $indexes = array_keys($csvArr);
          // dd($indexes);
        
          
        


            if(  !in_array("name", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            if(  !in_array("last_name", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            if(  !in_array("last_name", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            if(  !in_array("gender", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }

            if(  !in_array("email", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            if(  !in_array("password", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            if(  !in_array("alergy", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            if(  !in_array("parent_first_name", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            if(  !in_array("parent_last_name", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            if(  !in_array("relation", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            if(  !in_array("phone", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            if(  !in_array("address", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
             if(  !in_array("parent_email", $indexes) )
            {
                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }
            


            if( $sec_check == 'true'){
                $missing_entry_check = 'false';
            }


            if($missing_entry_check == 'false'){
                  $ses_err_message.= 'please provide proper header fields in EXCEL file to import Users ;';
            }

            $imported_user_count = 0;
             if( count($csvArr) > 0 )
                {
                  // dd($csvArr);
                    foreach ($csvArr as $datum) {

                        $alergy = $datum['alergy'];
                        if($datum['alergy'] == null){
                          $datum['alergy'] = '';
                        }

                       



                        if($missing_entry_check == 'false'){
                            break;
                        }

                        if( !isset($datum['name']) ){
                             $ses_err_message.= 'Name field is undefined ; ';
                             continue;
                           }
                            if( !isset($datum['last_name']) || $datum['last_name'] == '' ){
                              $ses_err_message.= 'Last Name field is undefined for name ' . $datum['name'] .';' ;
                             continue;
                           }
                            if( !isset($datum['record_no']) || $datum['record_no'] == '' ){
                              $ses_err_message.= 'Record number field is undefined for name ' . $datum['name'] .';' ;
                             // $ses_err_message.= 'Name field is undefined ; ';
                             continue;
                           }
                            if( !isset($datum['gender']) || $datum['gender'] == '' ){
                             // $ses_err_message.= 'Gender field is undefined ; ';
                              $ses_err_message.= 'Gender number field is undefined for name ' . $datum['name'] .';' ;

                             continue;
                           }
                            if( !isset($datum['email'])  || $datum['email'] == '' ){
                             // $ses_err_message.= 'Name field is undefined ; ';
                              $ses_err_message.= 'Email number field is undefined for name ' . $datum['name'] .';' ;

                             continue;
                           }
                            if( !isset($datum['home_address'])  || $datum['home_address'] == '' ){
                             // $ses_err_message.= 'Name field is undefined ; ';
                              $ses_err_message.= 'Home Address field is undefined for name ' . $datum['name'] .';' ;

                             continue;
                           }
                            if( !isset($datum['parent_first_name'])  || $datum['parent_first_name'] == '' ){
                             // $ses_err_message.= 'Name field is undefined ; ';
                              $ses_err_message.= 'Parent First Name field is undefined for name ' . $datum['name'] .';' ;

                             continue;
                           }
                            if( !isset($datum['parent_last_name'])  || $datum['parent_last_name'] == '' ){
                             // $ses_err_message.= 'Name field is undefined ; ';
                              $ses_err_message.= 'Parent Last Name field is undefined for name ' . $datum['name'] .';' ;

                             continue;
                           }

                             if( !isset($datum['relation'])  || $datum['relation'] == '' ){
                             // $ses_err_message.= 'Name field is undefined ; ';
                              $ses_err_message.= 'Relation field is undefined for name' . $datum['name'] .';' ;

                             continue;
                           }
                             if( !isset($datum['phone'])   || $datum['phone'] == ''){
                             // $ses_err_message.= 'Name field is undefined ; ';
                              $ses_err_message.= 'Record number field is undefined for name ' . $datum['name'] .';' ;

                             continue;
                           }
                             if( !isset($datum['address'])  || $datum['address'] == '' ){
                             // $ses_err_message.= 'Name field is undefined ; ';
                              $ses_err_message.= 'Address field is undefined for name ' . $datum['name'] .';' ;

                             continue;
                           }
                             if( !isset($datum['parent_email'])  || $datum['parent_email'] == '' ){
                             // $ses_err_message.= 'Name field is undefined ; ';
                              $ses_err_message.= 'Parent Email field is undefined for name  ' . $datum['name'] .';' ;

                             continue;
                           }

                            $gender = strtolower( $datum['gender'] );
                            $gender_flag = false;  
                            if($gender != 'male' && $gender != 'female' && $gender != 'm' && $gender != 'f'){
                               $ses_err_message.= 'data is invalid at Gender field at name :'.$datum['name'] .'  only  M, F, Male and Female are allowed ;' ;
                               continue;
                            }

                            // if()

                           $gender = strtolower( $datum['gender'] );
                           if($gender == 'male' ||  $gender == 'm' ){
                            $gender = 'male';
                           }
                            if($gender == 'female' || $gender == 'f' ){
                            $gender = 'female';
                           }
                          

                            if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $datum['email'])){
                                  $ses_err_message.= 'Please provide proper email at name  ' . $datum['name'].';';
                                  continue;
                               }
                              if (!Db::table('users')->where('email', '=', $datum['email'])->first())
                              {


                                  // $data = array(
                                  //                 'name' => $datum['name'],
                                  //                 'email' => $datum['email'],
                                  //                 'password' => bcrypt('password'),
                                  //                 // 'created_by_admin'=> 1,
                                  //                 // 'image'=>'abc.png'
                                  //              );

                                $data = array(
                                            'name' => $datum['name'],
                                            'email' => $datum['email'],
                                            'password' => bcrypt('password'),
                                            'contact' => $datum['phone'],
                                            'role_id' => 5,
                                        );
                                 $rr =  DB::table('users')->insert($data);

                                   if($rr){

                                      $inserted_user = DB::table('users')->orderBy('id','desc')->first();
                                      $unique_id = $inserted_user->name."".$inserted_user->id;
                                      DB::table('users')->where('id', $inserted_user->id)->update([
                                          'unique_id' => $unique_id,
                                      ]);
                                      $imported_user_count++;

                                      DB::table('students')->insert([
                                           'last_name'     => $datum['last_name'],
                                           's_u_id'     => $inserted_user->id,
                                           'school_id'     => $school_id,
                                           'record_no'   => $datum['record_no'],
                                           'gender'   => $gender,
                                           'grade_level'   => $grade,
                                           'home_address'   => $datum['home_address'],
                                           'alergy'   => $alergy,
                                           'iep'   => $iep,
                                           'parent_first_name'   => $datum['parent_first_name'],
                                           'parent_last_name'   => $datum['parent_last_name'],
                                           'address'   => $datum['address'],
                                           'phone'   => $datum['phone'],
                                           'relation'   => $datum['relation'],
                                           'parent_email'   => $datum['parent_email'],

                                      ]);
                                  }
                              }
                              else{
                                   $ses_err_message.= 'Email already exists at name  ' . $datum['name'].';';
                              }
                           



                      }
                   } 


                    $ses_err_message.= 'Total uploaded students :  ' . $imported_user_count.';';

                   Session::flash('question_import_error',  $ses_err_message);
                   return redirect("studentcreate");



        // return redirect('/students')->with('message', 'File imported Successfully');
    }

    public function addsample()
    {
        return view('students.sample');
    }

   public function storesample(Request $request)
    {
        
        $sample = DB::table('student_excel_samples')->count();
        

        if($sample > 0)
        {
            $this->validate($request, [

                'file' => 'max:10000|mimes:xlsx|max:2048',
                

            ]);
            $file = $request->file('file');

            $fileName = time().'.'.$file->getClientOriginalName();

            $file->move(public_path('storage/'), $fileName);

            $fileType =$file->getClientOriginalExtension();

            DB::table('student_excel_samples')->update([
                'file' => $fileName,
                'type' => $fileType,
                'school_id' => Auth::user()->id,
            ]);
            Session::flash('message', 'File Updated Successfully');
            return view('students.sample');

        }
        else{

              $this->validate($request, [

                  'file' => 'max:10000|mimes:xlsx|max:2048',
              ]);
                


            $file = $request->file('file');
            $fileName = time().'.'.$file->getClientOriginalName();
            $file->move(public_path('storage/'), $fileName);
            $fileType =$file->getClientOriginalExtension();
             $sample = array(
                  'file' => $fileName,
                  'type' => $fileType,
                  'school_id' => Auth::user()->id,
              );
            DB::table('student_excel_samples')->insert($sample);
            Session::flash('message', 'File Stored Successfully');
            return view('students.sample');
        }
    }


    public function students()

    {

          $user = Auth::user()->id;
           if(Auth::user()->role_id == 3)
           {
            $students = DB::table('students')->where('school_id', Auth::user()->id)->orderBy('id' , 'desc')->get()->all();

           }
           else
           {

            $students = DB::table('students')->orderBy('id' , 'desc')->get()->all();
           }
            //echo '<pre>';print_r($students);exit;
        $schools  = DB::table('schools')->get()->all();

        return view('students.index', compact('students', 'user', 'schools'));

    }


    public function create()

    {
        $user = Auth::user()->id;
        


        // $schools = DB::table('schools')->get()->all();

        // $instructors = DB::table('users')->where('id', 4)->get()->all();

        // $sup = DB::table('school_super')->where('sch_u_id',  Auth::user()->id)->get()->pluck('sup_u_id')->toArray();

        $sample = DB::table('student_excel_samples')->first();
        
        $alergies = DB::table('alergies')->where('school_id', Auth::user()->id)->orderBy('name', 'asc')->get();
        
        return view ('students.create', compact('user', 'sample','alergies'));

    }

    public function store(Request $request)

    {
        $this->validate($request, [

            'sname' => 'required|min:1|max:20',

            'lname' => 'required|min:1|max:50',

            'email' => 'required|unique:users|max:255',

            'Phone' => 'required',

            'password' => 'required|string|confirmed',

            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10000',

            'add' => 'required|min:3|max:200',

            'hadd' => 'required|min:3|max:200',

            'grade_level' => 'required',

            

            'gender' => 'required',

            'record_no' => 'required',

        ]);

        if ($file = $request->file('image')) {

            $name=$file->getClientOriginalName();

            $image = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path() .'/assets/img/upload', $image);

       }
        // dd($image);
        

        $udata = new User();

        $udata->name=$request->input('sname');

        $udata->role_id=$request->input('role');

        $udata->email=$request->input('email');

        $udata->contact=$request->input('Phone');

        $udata->image= $image;

        $udata->password = Hash::make($request['password']);

        $udata->save();

        $grade_level = $request->grade_level;

        $alergy = $request->input('alergy');



        

        $sdata = new Student();

        $sdata->s_u_id = $udata->id;

        if(auth()->user()->user_role == 4){
          $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();
           $sdata->school_id = $school_id;

        }else{
           $sdata->school_id = Auth::user()->id;

        }

       
        $sdata->last_name = $request->lname;

        $sdata->record_no = $request->record_no;

        $sdata->home_address = $request->hadd;

        $sdata->gender = $request->gender;

        $sdata->grade_level = $grade_level;

        $sdata->alergy = $alergy;

        $sdata->iep = $request->iep;

        $sdata->parent_first_name = $request->pfname;

        $sdata->parent_last_name = $request->plname;

        $sdata->parent_email = $request->pemail;

        $sdata->relation = $request->relation;

        $sdata->phone = $request->Phone;

        $sdata->address = $request->add;

        $sdata->save();

        $success = DB::table('users')->where('id' , $udata->id)->update([
            'unique_id' => $udata->name . '' . $udata->id,
        ]);

            Session::flash('message', 'Student saved successfully');

            return redirect('/students');

    }



    public function show($id)

    {

        $user = Auth::user();

        $studentsdetail = DB::table('students')->where('s_u_id',$id)->get()->all();

        return view('students.show', compact('studentsdetail', 'user'));

    }



    public function edit($id)

    {

        $user = Auth::user();

        $student = DB::table('users')->join('students','students.s_u_id','=','users.id')->where('users.id',$id)->first();
       $alergies = DB::table('alergies')->where('school_id', Auth::user()->id)->orderBy('name', 'asc')->get();

        return view('students.edit', compact('student', 'user','alergies'));

    }

   public function update(Request $request, $id)

    {
        $student = DB::table('students')->where('id',$id)->get()->first();
		
        $user = DB::table('users')->where('id',$student->s_u_id)->get()->first();
//echo '<pre>';print_r($_FILES);exit;
        $this->validate($request, [

            'sname' => 'required|min:3|max:20',


            'phno' => 'required',

            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,

           // 'Image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',


            'add' => 'required|min:3|max:200',



        ]);



        if ($files = $request->file('image')) {

            $path="assets/img/upload/$user->image";

            @unlink($path);

            $name=$files->getClientOriginalName();

            $image = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path() .'/assets/img/upload', $image);

           }

           else{

            $image = $user->image;

           }

           $udata = User::find($student->s_u_id);

           $udata->name=$request->input('sname');

           $udata->email=$request->input('email');

           $udata->contact=$request->input('phno');

           $udata->image=$image;

           $udata->save();


            $data = Student::find($id);

            $data->last_name=$request->input('lname');

            $data->record_no=$request->input('record_no');

            $data->home_address=$request->input('hadd');

            $data->address=$request->input('add');

            $data->gender=$request->input('gender');

            $data->iep=$request->input('iep');

            $data->alergy=$request->input('alergy');

            $data->grade_level=$request->input('gl');

            $data->parent_first_name=$request->input('pfname');

            $data->parent_last_name=$request->input('plname');

            $data->relation=$request->input('relation');

            $data->phone=$request->input('phno');

            $data->parent_email=$request->input('pemail');

            $data->save();

            Session::flash('message', 'Updated successfully');

            return redirect('/students');

    }

   public function destroy(Request $request)

      {

          $id = $request->id;   

          $user = DB::table('users')->where('id',$id)->get()->first();

          $path="assets/img/upload/$user->image";

          File::delete($path);

          DB::table('instructor_student')->where('s_u_id',$id)->delete();

          DB::table('students')->where('s_u_id',$id)->delete();

          DB::table('users')->where('id',$id)->delete();

          Session::flash('message', 'Student deleted successfully');

      }

}

