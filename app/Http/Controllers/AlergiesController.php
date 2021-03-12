<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Alergies;

use DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Session;



class AlergiesController extends Controller

{

    public function index(){
        
           $user = Auth::user()->id;
           
          
              
         
        if(auth()->user()->role_id == '3'){ 
                $user = Auth::user();
                $alergies = DB::table('alergies')->where('school_id' , $user->id)->orderBy('id', 'desc')->get();
                
        }

        
        
      
        return view ('alergies.index', compact( 'alergies'));

    }

    
  
   


    public function create(){
           $user = Auth::user()->id;
           
        $user = Auth::user();

    	return view ('alergies.create', compact('user'));

    }
    public function store(Request $request){

        $this->validate($request, [

            'name'=>'required|min:1|max:100'

        ]);



        
        

        $data = array(
                'name' => $request->name,
                'school_id' => Auth::user()->id,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
				'added_by_role_id'=>Auth::user()->role_id
            );
            
            DB::table('alergies')->insert($data);
			
			
			

        Session::flash('message', 'Successfully Saved');

        return redirect('/alergies');

     }

    public function destroy(Request $request){

        $id = $request->input("id");

        $alergies = Alergies::find($id);

        $alergies->delete();

    }

    public function edit($id){

        $alergies = Alergies::find($id);

        $user = Auth::user();

    	return view ('alergies.edit', ['alergies'=>$alergies], compact('user'));

    }



    public function update($id, Request $request){

        $alergies = Alergies::find($id);

        

        $this->validate($request, [

            'name'=>'required|min:1|max:100',

        ]);

        

        $alergies->name=$request->name;

        $alergies->save();

        Session::flash('message', 'Successfully Updated');

        return redirect('/alergies');

    }

}

