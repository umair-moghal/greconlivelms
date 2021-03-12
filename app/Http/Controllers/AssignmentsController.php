<?php



namespace App\Http\Controllers;

use App\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;



class AssignmentsController extends Controller

{
	public function index($id)
	{

	}

    public function create($id)
    {
    	$course = DB::table('courses')->where('id',$id)->first();
    	return view ('assignments.create', compact('course'));

    }

	public function store(Request $request)
	{
		
	}

	public function edit($id)
	{
		
	}

	public function update(Request $request, $id)
	{
		
	}

    public function destroy(Request $request)
    {
    	$id = $request->id;

        DB::table('assignments')->where('id',$id)->delete();

        Session::flash('message', 'Assignment deleted successfully');
    }

}