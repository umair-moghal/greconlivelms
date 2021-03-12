<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

class ResultsController extends Controller
{
	public function student_results()
	{
		dd('asdasda');
		
		return view('results.student_results');
	}
}