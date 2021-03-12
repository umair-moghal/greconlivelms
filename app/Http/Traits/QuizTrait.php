<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

use App\Quiz;

trait QuizTrait {

    
    public function show_solved_quiz($id)
    {
        $coursequiz = DB::table('quizzes')->where('course_id', $id)->pluck('id');
        $quizzes = DB::table('solved_quizzes')->whereIn('quiz_id', $coursequiz)->where('student_id', Auth::user()->id)->orderBy('id', 'desc')->pluck('quiz_id')->unique();
        return view('quizzes.solved_quizzes', compact('quizzes'));
    }
}