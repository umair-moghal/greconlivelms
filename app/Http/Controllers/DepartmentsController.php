<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Department;

use App\School;

use DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Session;



class DepartmentsController extends Controller

{

    public function index(){
        
           $user = Auth::user()->id;
           
           if(auth()->user()->role_id != '5'){
            $assigned_permissions =array();
            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');

            if($data != null){
                 foreach ($data as $value) {
                $assigned_permissions = explode(',',$value);
            }
            }
            if(!in_array('All Departments', $assigned_permissions)){
                return redirect('dashboard');
            }
           }
              
         
        if(auth()->user()->role_id == '3'){ 
                $user = Auth::user();
                $departments = DB::table('departments')->where('school_id' , $user->id)->orderBy('id', 'desc')->get();
                
        }

        if(auth()->user()->role_id == '5'){ 
            $user = Auth::user();
            $departments = DB::table('departments')->where('school_id' , $user->id)->orderBy('id', 'desc')->get();
            
    }
        
      
        return view ('departments.index', compact( 'departments'));

    }

    
    public function see_classes_of_department($id)
    {

           $classes = DB::table('classes')->where('department_id' , $id)->orderBy('id', 'desc')->get();
           return view('departments.all_classes_of_dept' , compact('classes', 'id'));           
        
    }
    
    public function addclass_to_department($id)
    {

           $classes = DB::table('classes')->where('department_id' , $id)->orderBy('id', 'desc')->get();


           $allClasses = DB::table('classes')->where('school_id', Auth::user()->id)->get();
		   $department_name = '';
		   $department_name = DB::table('departments')->where('id' , $id)->pluck('name')->first();
		  
		   if($department_name == null)
				
				return redirect('/departments');
			$department_subjects = DB::table('department_subjects')->where('department_id' , $id)->pluck('class_id');	
		    $arr_subjects[] = '';
			foreach($department_subjects as $department_subject){
				 $arr_subjects[] = $department_subject;
			}
			
			
			
		
		
           return view('departments.add_depart_to_class' , compact('allClasses' , 'id','department_name','arr_subjects'));           
        
    }
    public function storeclass_to_department(Request $request){
   
   
   
   if(!empty($request->clas_id)){
        
		DB::table('department_subjects')->where('department_id',$request->dep_id)->delete();
		foreach( $request->clas_id  as $clas_id){
            /*
			DB::table('classes')->where('id' , $clas_id)->update([
                'department_id' => $request->dep_id,
                ]);
			*/
			
			
		
		$department_subjects = array(
        	'department_id' => $request->dep_id,
        	'class_id' => $clas_id,
			'created_at'=>date('Y-m-d H:i:s'),
			'updated_at'=>date('Y-m-d H:i:s'),
        );
        $success = DB::table('department_subjects')->insert($department_subjects);
		
			
			
        }
          Session::flash('message', 'Selected Subjects added to department'. DB::table('departments')->where('id',$request->dep_id)->pluck('name')->first().'.');
          return redirect('/departments');
   }
   else{
       Session::flash('message', 'Please select a subject first!');

        return redirect()->back();
   }
   
   
    }


    public function create(){
           $user = Auth::user()->id;
            $assigned_permissions =array();
            $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');

            if($data != null){
                 foreach ($data as $value) {
                $assigned_permissions = explode(',',$value);
                 
            }
            }
            if(!in_array('Add Department', $assigned_permissions)){
                return redirect('dashboard');
            }

        $user = Auth::user();

    	return view ('departments.create', compact('user'));

    }
    public function store(Request $request){

        $this->validate($request, [

            'name'=>'required|min:1|max:100'

        ]);



        $id = $request->user()->id;

        $school=School::where('sch_u_id', $id)->first();
        $school->departments()->create([

            'name' => $request->name

        ]);

        

        Session::flash('message', 'Successfully Saved');

        return redirect('/departments');

    }

    public function destroy(Request $request){

        $id = $request->input("id");

        $department = department::find($id);

        $department->delete();

    }

    public function edit($id){

        $department = Department::find($id);

        $user = Auth::user();

    	return view ('departments.edit', ['department'=>$department], compact('user'));

    }



    public function update($id, Request $request){

        $department = Department::find($id);

        

        $this->validate($request, [

            'name'=>'required|min:1|max:100',

        ]);

        

        $department->name=$request->name;

        $department->save();

        Session::flash('message', 'Successfully Updated');

        return redirect('/departments');

    }

}

