<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Option;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MCQImport;
use App\Imports\TfImport;
use App\Imports\QaImport;

class QuestionsController extends Controller
{

    public function upload_quiz_questions($insid, $courseid, $week, $qid)
    {
        $week = $week;
        $course_id = $courseid;
        $instructor_id = $insid;

        return view ('questions.upload_quiz_questions', compact('course_id', 'instructor_id', 'week', 'qid'));
    }

    public function upload_quiz_mcq(Request $request)
    {
        $validator = Validator::make(
          [
              'file'      => $request->file,
              'extension' => strtolower($request->file->getClientOriginalExtension()),
          ],
          [
              'file'          => 'required',
              'extension'      => 'required|in:xlsx,xls',
          ]
        );
        if ($validator->fails()) 
        {
             return back()->withErrors($validator);
           }


        $file=$request->file('file')->store('import');


        $import = new MCQImport;
        Excel::import($import, request()->file('file'));
        $rows = $import->getRowCount(); 

        $excel_records = DB::table('questions')->limit($rows)->orderBy('id', 'desc')->get();

        foreach ($excel_records as $er) {
            $success = DB::table('questions')->where('id', $er->id)->update([
                'course_id' => $request->course_id,
                'instructor_id' => $request->instructor_id,
                'week' => $request->week,
                'quiz_id' => $request->qid,
            ]);
        }
        if($success){
            return redirect()->back()->with('message', 'File imported Successfully');
            
        }else{
            return redirect()->back()->with('message', 'Something went wrong');
        }

    }

    public function upload_quiz_tf(Request $request)
    {
        {
        $validator = Validator::make(
          [
              'file'      => $request->file,
              'extension' => strtolower($request->file->getClientOriginalExtension()),
          ],
          [
              'file'          => 'required',
              'extension'      => 'required|in:xlsx,xls',
          ]
        );
        if ($validator->fails()) 
        {
             return back()->withErrors($validator);
           }


        $file=$request->file('file')->store('import');


        $import = new TFImport;
        Excel::import($import, request()->file('file'));
        $rows = $import->getRowCount(); 

        $excel_records = DB::table('questions')->limit($rows)->orderBy('id', 'desc')->get();

        foreach ($excel_records as $er) {
            $success = DB::table('questions')->where('id', $er->id)->update([
                'course_id' => $request->course_id,
                'instructor_id' => $request->instructor_id,
                'week' => $request->week,
                'quiz_id' => $request->qid,
            ]);
        }
        if($success){
            return redirect()->back()->with('message', 'File imported Successfully');
            
        }else{
            return redirect()->back()->with('message', 'Something went wrong');
        }

    }
    }

    public function upload_quiz_qa(Request $request)
    {
        {
        $validator = Validator::make(
          [
              'file'      => $request->file,
              'extension' => strtolower($request->file->getClientOriginalExtension()),
          ],
          [
              'file'          => 'required',
              'extension'      => 'required|in:xlsx,xls',
          ]
        );
        if ($validator->fails()) 
        {
             return back()->withErrors($validator);
           }


        $file=$request->file('file')->store('import');


        $import = new QaImport;
        Excel::import($import, request()->file('file'));
        $rows = $import->getRowCount(); 

        $excel_records = DB::table('questions')->limit($rows)->orderBy('id', 'desc')->get();

        foreach ($excel_records as $er) {
            $success = DB::table('questions')->where('id', $er->id)->update([
                'course_id' => $request->course_id,
                'instructor_id' => $request->instructor_id,
                'week' => $request->week,
                'quiz_id' => $request->qid,
            ]);
        }
        if($success){
            return redirect()->back()->with('message', 'File imported Successfully');
            
        }else{
            return redirect()->back()->with('message', 'Something went wrong');
        }

    }
    }

    public function search_by_week($insid, $courseid, $week)
    {
        $week = $week;
        $course_id = $courseid;
        $instructor_id = $insid;
        $course = DB::table('courses')->where('id', $course_id)->get()->first();

        $mcqs = DB::table('questions')->where('type', 'mcq')->where('instructor_id', $instructor_id)->where('course_id', $course_id)->where('week', $week)->orderBy('id', 'desc')->get()->all();
        $instructor_id = Auth::user()->id;
        return view ('questions.mcq', compact('user', 'mcqs', 'course', 'instructor_id'));

    }

    public function filterall($id, $qid)
    {
        $questions = DB::table('questions')->where('course_id', $id)->get()->all();
        $course = DB::table('courses')->where('id', $id)->get()->first();
        $quiz_id = $qid;
        return view ('quizzes.addquestion', compact('questions', 'course', 'quiz_id'));
    }

    public function filterrecent($id, $qid)
    {
        $questions = DB::table('questions')->where('course_id', $id)->orderBy('created_at', 'desc')->get()->all();
        $course = DB::table('courses')->where('id', $id)->get()->first();
        $quiz_id = $qid;
        return view ('quizzes.addquestion', compact('questions', 'course', 'quiz_id'));
    }

    public function filternotused($id, $qid)
    {
        $qs = DB::table('quiz_questions')->pluck('question_id');
        $questions = DB::table('questions')->where('course_id', $id)->whereNotIn('id', $qs)->get()->all();
        $course = DB::table('courses')->where('id', $id)->get()->first();
        $quiz_id = $qid;
        return view ('quizzes.addquestion', compact('questions', 'course', 'quiz_id'));
    }

    public function mcqcreate($insid, $cid, $week, $qid)
    {
        $user = Auth::user();
        $course = DB::table('courses')->where('id',$cid)->first();
        $mcqs = DB::table('questions')->where('type', 'mcq')->where('week', $week)->where('instructor_id', $insid)->where('course_id', $course->id)->where('quiz_id', $qid)->orderBy('id', 'desc')->get()->all();
        $instructor_id = Auth::user()->id;
        $week = $week;
        $qid = $qid;
        return view ('questions.mcq', compact('user', 'mcqs', 'course', 'instructor_id', 'week', 'qid'));
    }

    public function mcqstore(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'correct' => 'required',
        ]);

        $user = Auth::user();
        $type = "mcq";
        $carray = $request->input('correct');

        $opts = array(
            'opt1' => $request->input('opt1'),
            'opt2' => $request->input('opt2'),
            'opt3' => $request->input('opt3'),
            'opt4' => $request->input('opt4'),
            'correct' => $carray,
        );
        $mcq = new Question();
        $mcq->label=$request->input('label');
        $mcq->type=$type;
        $mcq->course_id=$request->course_id;
        $mcq->instructor_id=$request->instructor_id;
        $mcq->quiz_id=$request->qid;
        $mcq->week=$request->week;
        $mcq->options=serialize($opts);
        $mcq->save();
        Session::flash('message', 'Question create successfully');
        return redirect('/mcq/create/'. $request->instructor_id .'/'. $request->course_id .'/'. $request->week .'/'. $request->qid);
    }



    public function qcreate($insid, $cid, $week, $qid)
    {
        $user = Auth::user();
        $course = DB::table('courses')->where('id',$cid)->first();
        $questions = DB::table('questions')->where('type', 'question/answer')->where('week', $week)->where('instructor_id', $insid)->where('course_id', $course->id)->where('quiz_id', $qid)->orderBy('id', 'desc')->get()->all();
        $instructor_id = Auth::user()->id;
        $week = $week;
        $qid = $qid;
        return view ('questions.question_answer', compact('user', 'questions', 'course','instructor_id', 'week', 'qid'));
    }

    public function qstore(Request $request)
    {
        $this->validate($request, [
            'label' => 'required',
            'ans' => 'required',
        ]);

        $user = Auth::user();
        $type = "question/answer";

        $q = new Question();
        $q->label=$request->input('label');
        $q->type=$type;
        $q->course_id=$request->course_id;
        $q->instructor_id=$request->instructor_id;
        $q->quiz_id=$request->qid;
        $q->week=$request->week;
        $q->options = $request->input('ans');
        $q->save();
        Session::flash('message', 'Question create successfully');
        return redirect('/q/create/'. $request->instructor_id .'/'. $request->course_id .'/'. $request->week .'/'. $request->qid);
    }


    public function tfcreate($insid, $cid, $week, $qid)
    {
        $user = Auth::user();
        $course = DB::table('courses')->where('id',$cid)->first();
        $tfs = DB::table('questions')->where('type', 't/f')->where('week', $week)->where('instructor_id', $insid)->where('course_id', $course->id)->where('quiz_id', $qid)->orderBy('id', 'desc')->get()->all();
        $instructor_id = Auth::user()->id;
        $week = $week;
        $qid = $qid;
        return view ('questions.tf', compact('user', 'tfs', 'course','instructor_id', 'week', 'qid'));
    }

    public function tfstore(Request $request)
    {
        $user = Auth::user();
        $type = "t/f";

        $carray = $request->input('correct');

        $opts = array(
        	'true' => 'true',
            'false' => 'false',
            'correct' => $carray,
        );

        $tf = new Question();
        $tf->label=$request->input('label');
        $tf->type=$type;
        $tf->course_id=$request->course_id;
        $tf->instructor_id=$request->instructor_id;
        $tf->week=$request->week;
        $tf->quiz_id=$request->qid;
        $tf->options=serialize($opts);
        $tf->save();
        Session::flash('message', 'True False create successfully');
        return redirect('/tf/create/'. $request->instructor_id .'/'. $request->course_id .'/'. $request->week .'/'. $request->qid);
    }

    public function mcq_edit($id, $courseid)
    {
        $courseid = $courseid;
        $mcq = DB::table('questions')->where('id', $id)->get()->first();
        return view('questions.mcq_edit', compact('mcq', 'courseid'));
    }

    public function mcq_update(Request $request, $id)
    {
        $mcq = Question::find($id);
        $this->validate($request, [
            'label' => 'required',
            'correct' => 'required',
        ]);

        $user = Auth::user();
        $type = "mcq";
        $carray = $request->input('correct');

        $opts = array(
            'opt1' => $request->input('opt1'),
            'opt2' => $request->input('opt2'),
            'opt3' => $request->input('opt3'),
            'opt4' => $request->input('opt4'),
            'correct' => $carray,
        );
        $success = DB::table('questions')->where('id', $id)->update([
            'label' => $request->input('label'),
            'week' => $request->input('week'),
            'type' => $type,
            'course_id' => $request->course_id,
            'options' => serialize($opts),
        ]);
        if($success){
            Session::flash('message', 'MCQ Updated successfully');
            return redirect('/q/create/'. $request->course_id);
        }else{
            Session::flash('message', 'Something went wrong');
            return redirect()->back();
        }
    }

    public function q_edit($id, $courseid)
    {
        $courseid = $courseid;
        $q = DB::table('questions')->where('id', $id)->get()->first();
        return view('questions.q_edit', compact('q', 'courseid'));
    }

    public function q_update(Request $request, $id)
    {

        $q = Question::find($id);
        $this->validate($request, [
            'label' => 'required',
            'ans' => 'required',
        ]);

        $type = "question/answer";

        $q->label=$request->input('label');
        $q->type=$type;
        $q->course_id=$request->input('course_id');
        $q->options=$request->input('ans');

        $success = $q->save();
        if($success){
            Session::flash('message', 'Question Updated successfully');
            return redirect('/q/create/'. $request->course_id);
        }else{
            Session::flash('message', 'Something went wrong');
            return redirect()->back();
        }
    }

    public function tf_edit($id, $courseid)
    {
        $courseid = $courseid;
        $tf = DB::table('questions')->where('id', $id)->get()->first();
        return view('questions.tf_edit', compact('tf', 'courseid'));
    }

    public function tf_update(Request $request, $id)
    {
        $tf = Question::find($id);

        $opts = array(
            'true' => 'true',
            'false' => 'false',
            'correct' => $request->input('correct'),
        ); 

        $type = "t/f";
        $tf->label=$request->input('label');
        $tf->type=$type;
        $tf->course_id=$request->input('course_id');
        $tf->options=serialize($opts);

        $success = $tf->save();
        if($success){
            Session::flash('message', 'True False Updated successfully');
            return redirect('/q/create/'. $request->course_id);
        }else{
            Session::flash('message', 'Something went wrong');
            return redirect()->back();
        }
    }
}