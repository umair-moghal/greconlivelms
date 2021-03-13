<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\School;

use App\User;

use File;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;



class SchoolsController extends Controller

{

    

    public function store_permission_school(Request $request){

        

        // dd($request);

       $is_assigned_any_permissions = DB::table('module_permissions_users')->where('user_id' , $request->id)->first();

       if($is_assigned_any_permissions != null){

       $data = $request->permiss;

       if($data == null)

       {

              $data = ['nodata , nodata'];

       }

            $new = implode(',', $data);

            $result = DB::table('module_permissions_users')->where('user_id' , $request->id)->update([ 

                "user_id" => $request->id,

               "allowed_module" => $new

            ]);



             Session::flash('message', 'Permissions are updated for school');

             return redirect('/schools');

            // dd($result . 'record updated');

       }

       elseif ($is_assigned_any_permissions == null) {

            # code...

            $data = $request->permiss;

            if($data == null)

               {

                     $data = ['nodata , nodata'];

               }

            $new = implode(',', $data);

            $result = DB::table('module_permissions_users')->insert([ 

                "user_id" => $request->id,

               "allowed_module" => $new

            ]);

            // dd('permission set');

             Session::flash('message', 'Permissions are updated for school');

             return redirect('/schools');



        } 

    }

    

    public function change_permission_school($id){

        

        

       $user = Auth::user();

        $granted_permissions;

        $granted_permissions = DB::table('module_permissions_users')->where('user_id' , $id)->first();

        if($granted_permissions == null)

             {

             $granted_permissions = [' ' , ' '];

             

             }

         elseif ($granted_permissions != null) {

                 # code...

                 $granted_permissions = explode(',',$granted_permissions->allowed_module);

              

             } 

       $title = "Change School Permissions";

       $permissions = DB::table('module_permissions')->pluck('module');

       $page = 'school';

       return view('permissions.addd_remove_permission',compact('user' , 'page' ,'title' , 'id' , 'permissions' , 'granted_permissions'));

    }

    public function schools()

    {

        // dd('walla');

    	$user = Auth::user();

        // $schools = DB::table('school_super')->where('sup_u_id', Auth::user()->id)->paginate(5);

        $schools = DB::table('school_super')->where('sup_u_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('schools.index', compact('schools', 'user'));

    }

    public function create()

    {

    	$user = Auth::user();

    	return view ('schools.create', compact('user'));

    }

    public function store(Request $request)

    { 

        $this->validate($request, [

            'sname' => 'required|min:3|max:200',

            'name' => 'required|min:3|max:200',

            'district' => 'required|min:3|max:50',

            'password' => 'required|string|confirmed',

            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10000',

            'simage' => 'required|mimes:jpeg,png,jpg,gif,svg|max:10000',

            'phno' => 'required',

            's_id' => 'required',

            'sadd' => 'required|min:3|max:200',


        ]);

        if ($files = $request->file('image')) {

            $name=$files->getClientOriginalName();

            $image = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path() .'/assets/img/upload', $image);

       }

       if ($files = $request->file('simage')) {

            $name=$files->getClientOriginalName();

            $simage = time().'.'.$request->simage->getClientOriginalExtension();

            $request->simage->move(public_path() .'/assets/img/upload', $simage);

       }

        $udata = new User();

        $udata->name = $request->input('name');

        $udata->role_id = 3;

        $udata->email = $request->input('email');

        $udata->contact = $request->input('phno');

        $udata->image = $image;

        $udata->password = Hash::make($request['password']);

        $udata->save();



        $sdata = new School();

        $sdata->sch_u_id = $udata->id;

        $sdata->district = $request->district;

        $sdata->school_identification_number = $request->s_id;

        $sdata->phone = $request->phno;

        $sdata->school_address = $request->sadd;

        $sdata->school_name = $request->sname;

        $sdata->school_image = $simage;

        $sdata->save();

        

        

        $sup_sch_data = array(

            'sch_u_id' => $sdata->sch_u_id,

            'sup_u_id' => Auth::user()->id,

        );
        $AAgrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 95.5, 
            'marks_to' => 100, 
            'grade' => 'A+', 
        );

        $Agrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 90.5, 
            'marks_to' => 95, 
            'grade' => 'A', 
        );
        $BBgrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 80.5, 
            'marks_to' => 90, 
            'grade' => 'B+', 
        );
        $Bgrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 75.5, 
            'marks_to' => 80, 
            'grade' => 'B', 
        );
        $CCgrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 70.5, 
            'marks_to' => 75, 
            'grade' => 'C+', 
        );
        $Cgrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 60.5, 
            'marks_to' => 70, 
            'grade' => 'C', 
        );
        $DDgrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 55.5, 
            'marks_to' => 60, 
            'grade' => 'D+', 
        );
        $Dgrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 45.5, 
            'marks_to' => 55, 
            'grade' => 'D', 
        );
        $EEgrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 30.5, 
            'marks_to' => 45, 
            'grade' => 'E+', 
        );
        $Egrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 20.5, 
            'marks_to' => 30, 
            'grade' => 'E', 
        );
        $Fgrade = array(
            'school_id' => $sdata->sch_u_id,
            'marks_from' => 0, 
            'marks_to' => 20, 
            'grade' => 'F', 
        );

        $success = DB::table('grades')->insert($AAgrade);
        $success = DB::table('grades')->insert($Agrade);
        $success = DB::table('grades')->insert($BBgrade);
        $success = DB::table('grades')->insert($Bgrade);
        $success = DB::table('grades')->insert($CCgrade);
        $success = DB::table('grades')->insert($Cgrade);
        $success = DB::table('grades')->insert($DDgrade);
        $success = DB::table('grades')->insert($Dgrade);
        $success = DB::table('grades')->insert($EEgrade);
        $success = DB::table('grades')->insert($Egrade);
        $success = DB::table('grades')->insert($Fgrade);


        $success = DB::table('school_super')->insert($sup_sch_data);
        
        $success = DB::table('users')->where('id' , $udata->id)->update([
            'unique_id' => $udata->name . '' . $udata->id,
        ]);

        

        // dd($sdata);

        $all_perm = DB::table('module_permissions')->pluck('module')->toArray();

        // dd($all_perm);

          

          

            $new = implode(',', $all_perm);

            $result = DB::table('module_permissions_users')->insert([ 

                 "user_id" => $sdata->sch_u_id,

                 "allowed_module" => $new

            ]);

        

        if($success){

            Session::flash('message', 'School create successfully');

            return redirect('/schools');

        }else{

            Session::flash('message', 'Something went wrong');

            return redirect()->back();

        }

    }



    public function show($id)

    {

        $user = Auth::user();

        $schooldetail = DB::table('schools')->where('sch_u_id',$id)->get()->first();
        $schooluser = DB::table('users')->where('id',$id)->get()->first();
        $grades = DB::table('grades')->where('school_id', $id)->get()->all();
        $departments = DB::table('departments')->where('school_id', $id)->get()->all();

        return view('schools.view', compact('schooldetail', 'user', 'grades', 'departments', 'schooluser'));

    }

    public function school_grades_scale($id)

    {
        $user = Auth::user();

        $grades = DB::table('grades')->where('school_id', $id)->get()->all();

        return view('schools.grades_scale_view', compact('grades'));

    }



    public function edit($id)

    {

    	$user = Auth::user();

        $school = DB::table('users')->join('schools','schools.sch_u_id','=','users.id')->where('users.id',$id)->first();

        return view('schools.edit', compact('school', 'user'));

    }



   public function update(Request $request, $id)

    {

        $school = DB::table('schools')->where('id',$id)->get()->first();

        $user = DB::table('users')->where('id',$school->sch_u_id)->get()->first();

       $this->validate($request, [

            'name' => 'required|min:3|max:200',

            'sname' => 'required|min:3|max:200',

            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,

            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',

            'district' => 'required|min:3|max:50',

            'phno' => 'required',

            's_id' => 'required',

            'sadd' => 'required|min:3|max:200',

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

           if ($files = $request->file('simage')) {

            $name=$files->getClientOriginalName();

            $simage = time().'.'.$request->simage->getClientOriginalExtension();

            $request->simage->move(public_path() .'/assets/img/upload', $simage);

           }

           else{

            $simage = $school->school_image;

           }

           $udata = User::find($school->sch_u_id);

           $udata->name=$request->input('name');

           $udata->email=$request->input('email');

           $udata->contact=$request->input('phno');

           $udata->image=$image;

           $udata->save();



            $sdata = School::find($id);

            $sdata->school_name=$request->input('sname');

            $sdata->school_address=$request->input('sadd');

            $sdata->school_image=$simage;

            $sdata->district=$request->input('district');

            $sdata->phone=$request->input('phno');

            $sdata->school_identification_number=$request->input('s_id');

            $success = $sdata->save();

        if($success){

            Session::flash('message', 'Student updated successfully');

            return redirect('/schools');

        }else{

            Session::flash('message', 'Something went wrong');

            return back();

        }

    }



    public function destroy(Request $request)

    {

        $id = $request->id;  

        $user = DB::table('users')->where('id',$id)->get()->first();

        $path="assets/img/upload/$user->image";

        File::delete($path); 

        DB::table('school_super')->where('sch_u_id',$id)->delete();

        DB::table('users')->where('id',$id)->delete();

        DB::table('schools')->where('sch_u_id',$id)->delete();

        Session::flash('message', 'School deleted successfully');

        }

}

