<?php

namespace App\Http\Controllers;


use App\Quiz;
use App\Http\Traits\QuizTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class QuizController extends Controller
{

    use QuizTrait;

    public function student_quizzes($id)
    {
        $quizes = DB::table('solved_quizzes')->pluck('quiz_id');
        // $cdate = \Carbon\Carbon::now();
        // $date = $cdate->toDateString();
        // $quizzess = DB::table('quizzes')->where('course_id', $id)->where('quiz_date', $date)->whereNotIn('id', $quizes)->orderBy('id', 'desc')->get()->all();
        $quizzess = DB::table('quizzes')->where('course_id', $id)->whereNotIn('id', $quizes)->orderBy('id', 'desc')->get()->all();

        $quizzes = [];

        foreach($quizzess as $qz)
        {
            $quizQuestions = DB::table('quiz_questions')->where('quiz_id', $qz->id)->get()->toArray();
            if(!empty($quizQuestions))
                {
                    $quizzes[] =  $qz;
                }
        }

        // $result = array_intersect($quizzes, $quizQuestions);


        $ctime = \Carbon\Carbon::now();
        $time = $ctime->toTimeString();


        return view('quizzes.student_quizzes', compact('quizzes', 'time', 'id'));
    }

    public function show_quiz_to_student($id, $cid)
    {
        $questions = DB::table('quiz_questions')->where('quiz_id', $id)->orderBy('sort_order', 'desc')->get()->all();
        
        $quiz_details  = DB::table('quizzes')->where('id', $id)->get()->first();        
        return view ('quizzes.show_quiz_to_student', compact('questions', 'id', 'quiz_details', 'cid'));
    }


    public function attempted_by($qid, $insid, $cid, $week, $clasid)
    {
        $attempted_by = DB::table('solved_quizzes')->where('quiz_id', $qid)->pluck('student_id')->unique()->toArray();

        $students = DB::table('users')->whereIn('id', $attempted_by)->get()->all();

        return view ('quizzes.attempted_by_students', compact('students', 'qid', 'insid', 'cid', 'week', 'clasid'));
    }

    public function view_attempted_quiz($stdid, $qid, $insid, $cid, $week ,$clasid)
    {
        $student_quiz_details = DB::table('solved_quizzes')->where('solved_quizzes.quiz_id', $qid)->where('solved_quizzes.student_id', $stdid)->join('questions', 'questions.id', 'solved_quizzes.question_id')->get()->unique();

        return view ('quizzes.solved_quiz', compact('student_quiz_details', 'qid', 'insid', 'cid', 'week', 'clasid', 'stdid'));
    }

    public function move_next_question($nid)
    {
        return redirect()->back()->with('data', $nid);
    }

    public function course_quizzes_result($id, $clsid)
    {

        $course_quizzes = DB::table('quizzes')->where('course_id', $id)->pluck('id')->toArray();
        if(count($course_quizzes) > 0)
        {
            $quizzes = DB::table('obtained_marks_quiz')->whereIn('quiz_id', $course_quizzes)->where('status', 1)->get();
            
            if(count($quizzes) > 0)
            {

                return view('courses.course_quizzes_result', compact('quizzes', 'id', 'clsid'));
            }
            else
            {
                Session::flash('message', ' You have not solve any quiz yet for this course.');

                return redirect()->back();
            }
        }
        else
        {
            Session::flash('message', 'This course has no quiz yet.');

            return redirect()->back();
        }


        return view('courses.course_quizzes_result', compact('quizzes'));
    }


    public function update_qa_marks(Request $request)
    {
        $orignal_q = DB::table('quizzes')->where('id', $request->quiz_id)->get()->first();

        $orignal_qa_marks = $orignal_q->mr_per_qa;
        $no_of_questions = DB::table('solved_quizzes')->where('solved_quizzes.quiz_id', $request->quiz_id)->where('solved_quizzes.student_id', $request->student_id)->join('questions', 'questions.id', 'solved_quizzes.question_id')->get()->pluck('question_id')->unique();
        foreach($no_of_questions as $qstn)
        { 
	    	$q = DB::table('questions')->where('id', $qstn)->get()->first();
        if($request->input('mrks'.$q->id) > $orignal_qa_marks)
	        {
	            Session::flash('message', 'Please enter correct marks in given range.');

	            return redirect()->back();
	        }
	        else
	        {

				 $no_of_questions = DB::table('solved_quizzes')->where('solved_quizzes.quiz_id', $request->quiz_id)->where('solved_quizzes.student_id', $request->student_id)->join('questions', 'questions.id', 'solved_quizzes.question_id')->get()->pluck('question_id')->unique();


	            $qstnanswer = DB::table('obtained_marks_quiz')->where('s_u_id', $request->student_id)->where('quiz_id', $request->quiz_id)->get()->first();

	            $finalQaMarks = 0;

	            foreach($no_of_questions as $qstn)
	            {    

	                $q = DB::table('questions')->where('id', $qstn)->get()->first();

	                if($q->type == 'question/answer')
	                {
	                    $finalQaMarks =  $finalQaMarks + $request->input('mrks'.$q->id); 

	                    DB::table('individual_quiz_questions_obtained_marks')->where('s_u_id', $request->student_id)->where('quiz_id', $request->quiz_id)->where('question_id', $qstn)->update([
	                        'marks' => $request->input('mrks'.$q->id),
	                    ]);

	                }
	            

	            }

	                $mcq_marks = $qstnanswer->mcq_marks;
	                $tf_marks = $qstnanswer->tf_marks;

	                $total_marks = $mcq_marks + $tf_marks + $finalQaMarks;


	                $updated_question = DB::table('obtained_marks_quiz')->where('s_u_id', $request->student_id)->where('quiz_id', $request->quiz_id)->update([
	                    'questions_marks' => $finalQaMarks,
	                    'total_marks' => $total_marks,
	                        'status' => 1,

	                ]);




	            $updated_marks = DB::table('obtained_marks_quiz')->where('s_u_id', $request->student_id)->where('quiz_id', $request->quiz_id)->get()->first();



	            $original_quiz_marks = DB::table('quizzes')->where('id', $request->quiz_id)->get()->first();
	            
	            $original_qa_marks = $original_quiz_marks->mr_per_qa; 
	            $original_mcq_marks = $original_quiz_marks->mr_per_mcq; 
	            $original_tf_marks = $original_quiz_marks->mr_per_tf; 

	            
	            $no_of_qa = 0;
	            $no_of_mcq = 0;
	            $no_of_tf = 0;
	            foreach ($no_of_questions as $qz) 
	            {
	                $q = DB::table('questions')->where('id', $qz)->get()->first();


	                if($q->type == 'question/answer')
	                {
	                    $no_of_qa = $no_of_qa + 1;
	                }

	                elseif($q->type == 'mcq')
	                {
	                    $no_of_mcq = $no_of_mcq + 1;
	                }

	                else
	                {
	                    $no_of_tf = $no_of_tf + 1;
	                }
	            }


	            $original_qa_marks = $no_of_qa * $original_qa_marks;
	            $original_mcq_marks = $no_of_mcq * $original_mcq_marks;
	            $original_tf_marks = $no_of_tf * $original_tf_marks;

	            $original_marks = $original_qa_marks + $original_mcq_marks + $original_tf_marks;



	            $total_marks = $updated_marks->total_marks;

	            $percntage = $total_marks/$original_marks * 100;


	            $qz_wait = DB::table('quizzes')->where('id', $request->quiz_id)->get()->first();


	            $wait = $qz_wait->wait;

	            $finalPercentage = $wait*$percntage / 100;


	            $marks  = DB::table('obtained_marks_quiz')->where('s_u_id', $request->student_id)->where('quiz_id', $request->quiz_id)->update([
	                    'percentage' => $percntage,
	                    'w_percentage' => $finalPercentage,
	                ]);


	            
	            $course_name = DB::table('courses')->where('id',$request->course_id)->pluck('course_name')->first();

	       
	             DB::table('activities')->insert([
	                    'title' => 'Quiz Marks Notification',
	                    'description' => 'Quiz Marks Added To '. $course_name.' Notification',
	                    'created_by' => auth()->user()->id,
	                    'activity_name' => 'Results',
	                    'course_id' => $request->course_id,
	                    'activity_for' => 5,
	                    'message_reciever' =>  $request->student_id,                       
	                    'activity_time' => Carbon::now(),
	                    'link' => '/student/results',
	            ]);


	            Session::flash('message', 'Updated Quiz Marks');

	            return redirect('/course');
	        }
        }


    }

    public function solved_quiz_by_student(Request $request)
    {
        $quiz_id = $request->quiz_id;
        $no_of_questions = $request->question_id;


        foreach($no_of_questions as $q)
        {    
            $question = DB::table('questions')->where('id', $q)->get()->first();
            
            $correct = null;
            $fileName = null;

            if( $question->type == 'question/answer' )
            {
                if($request->input('ans'.$question->id))
                {
                    $correct = $request->input('ans'.$question->id);

                }
                if($request->file('file'.$question->id))
                {            
                    $file = $request->file('file'.$question->id);

                    $fileName = time().'.'.$file->getClientOriginalName();

                    $file->move(public_path('storage/'), $fileName);

                }
            
            }
            elseif($question->type == 't/f')
            {
                $correct = $request->input('correcttf'.$question->id);
            }
            
            elseif($question->type == 'mcq')
            {
                $crct = $request->input('correct'.$question->id);
                $correct = serialize($crct);
            }
            $data = array(
                'quiz_id' => $quiz_id,
                'question_id' => $q,
                'correct' => $correct,
                'file' => $fileName,
                'student_id' => Auth::user()->id,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            );
            $success = DB::table('solved_quizzes')->insert($data);
        }


        $quiz_questions = DB::table('solved_quizzes')->where('solved_quizzes.quiz_id', $quiz_id)->where('student_id', Auth::user()->id)->join('questions', 'questions.id', 'solved_quizzes.question_id')->get()->unique();



        $qstn_marks = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->get()->first();

            
            if($qstn_marks == null)
            {
                $obtained_marks = array(
                    's_u_id' => Auth::user()->id,
                    'quiz_id' => $quiz_id,
                    'mcq_marks' => 0,
                    'tf_marks' => 0,
                    'questions_marks' => 0,
                    'status' => 1,
                );
                $success = DB::table('obtained_marks_quiz')->insert($obtained_marks);
            }

                foreach($quiz_questions as $qq)
                {
                    if($qq->type == 'question/answer' )
                    {
                        DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->update([
                                's_u_id' => Auth::user()->id,
                                'quiz_id' => $quiz_id,
                                'questions_marks' => 0,
                                'status' => 0,
                            ]);

                        $individual_marks = array(
                                's_u_id' => Auth::user()->id,
                                'quiz_id' => $quiz_id,
                                'question_id' => $qq->id,
                                'marks' => 0,
                            );
                            DB::table('individual_quiz_questions_obtained_marks')->insert($individual_marks);

                        // $correct = $qq->options;
                        // $correct_option = $qq->correct;
                        // if($correct == $correct_option)
                        // {
                        //     $qstnanswer = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->get()->first();


                        //     $qmarks = $qstnanswer->questions_marks;
                        //     $marks = DB::table('quizzes')->where('id', $quiz_id)->get()->first();
                        //     $qa_marks = $marks->mr_per_qa;
                        //     $final_q_marks = $qmarks + $qa_marks;

                        //     $success = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->update([
                        //         's_u_id' => Auth::user()->id,
                        //         'quiz_id' => $quiz_id,
                        //         'questions_marks' => $final_q_marks,
                        //     ]);

                        //     $individual_marks = array(
                        //         's_u_id' => Auth::user()->id,
                        //         'quiz_id' => $quiz_id,
                        //         'question_id' => $qq->id,
                        //         'marks' => $qa_marks,
                        //     );
                        //     DB::table('individual_quiz_questions_obtained_marks')->insert($individual_marks);
                        // }
                        // else
                        // {
                        //     $qstnanswer = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->get()->first();
                            
                        //     $qmarks = $qstnanswer->questions_marks;

                        //     $success = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->update([
                        //             'questions_marks' => $qmarks,
                        //         ]);

                        //     $individual_marks = array(
                        //         's_u_id' => Auth::user()->id,
                        //         'quiz_id' => $quiz_id,
                        //         'question_id' => $qq->id,
                        //         'marks' => 0,
                        //     );
                        //     DB::table('individual_quiz_questions_obtained_marks')->insert($individual_marks);

                        // }
                    }
                    elseif($qq->type == 'mcq')
                    {

                        $q_type = $qq->type;
                            
                        $qstn_option = unserialize($qq->options);

                        $correct_option = unserialize($qq->correct); 

                        $a = 0;
                        
                        foreach($qstn_option['correct'] as $corr)
                        {
            
                            $correct = $qstn_option[$corr];

                            if(in_array($correct, $correct_option))
                            {
                                $a = 1;
                            }
                            else
                            {
                                $a = 0;
                            }
                        }

                            if($a == 1)
                            {
                                $q_type = $qq->type;

                                $qstnanswer = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->get()->first();
                        
                                $mcqmarks = $qstnanswer->mcq_marks;


                                $marks = DB::table('quizzes')->where('id', $quiz_id)->get()->first();
                                $mcq_marks = $marks->mr_per_mcq;
                                $final_m_marks = $mcqmarks + $mcq_marks;

                                $success = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->update([
                                    's_u_id' => Auth::user()->id,
                                    'quiz_id' => $quiz_id,
                                    'mcq_marks' => $final_m_marks,
                                ]);

                                $ind_mcq_marks = DB::table('individual_quiz_questions_obtained_marks')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->where('question_id', $qq->id)->get()->first();
                                if($ind_mcq_marks == null)
                                {

                                    $individual_marks = array(
                                        's_u_id' => Auth::user()->id,
                                        'quiz_id' => $quiz_id,
                                        'question_id' => $qq->id,
                                        'marks' => $mcq_marks,
                                    );
                                    DB::table('individual_quiz_questions_obtained_marks')->insert($individual_marks);
                                }
                                else
                                {
                                    DB::table('individual_quiz_questions_obtained_marks')->update([
                                        's_u_id' => Auth::user()->id,
                                        'quiz_id' => $quiz_id,
                                        'question_id' => $qq->id,
                                        'marks' => $mcq_marks,
                                    ]);
                                }

                            }
                
                            else
                            {
                                $q_type = $qq->type;

                                $qstnanswer = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->get()->first();
                        
                                $mcqmarks = $qstnanswer->mcq_marks;
                                
                                $success = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->update([
                                        'mcq_marks' => $mcqmarks,
                                    ]);

                                $ind_mcq_marks = DB::table('individual_quiz_questions_obtained_marks')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->where('question_id', $qq->id)->get()->first();
                                if($ind_mcq_marks == null)
                                {

                                    $individual_marks = array(
                                        's_u_id' => Auth::user()->id,
                                        'quiz_id' => $quiz_id,
                                        'question_id' => $qq->id,
                                        'marks' => 0,
                                    );
                                    DB::table('individual_quiz_questions_obtained_marks')->insert($individual_marks);
                                }
                                else
                                {
                                    DB::table('individual_quiz_questions_obtained_marks')->update([
                                        's_u_id' => Auth::user()->id,
                                        'quiz_id' => $quiz_id,
                                        'question_id' => $qq->id,
                                        'marks' => 0,
                                    ]);
                                }

                            }
                        
                    }
                    else
                    {
                        $qstn_option = unserialize($qq->options);
                        $correct_option = $qq->correct;
                          if($qstn_option['correct'] == $correct_option)
                            {


                                $qstnanswer = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->get()->first();
                            
                                $tfmarks = $qstnanswer->tf_marks;
                                
                                $marks = DB::table('quizzes')->where('id', $quiz_id)->get()->first();
                                $tf_marks = $marks->mr_per_tf;
                                $final_tf_marks = $tfmarks + $tf_marks;

                                $success = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->update([
                                    's_u_id' => Auth::user()->id,
                                    'quiz_id' => $quiz_id,
                                    'tf_marks' => $final_tf_marks,
                                ]);

                                $individual_marks = array(
                                        's_u_id' => Auth::user()->id,
                                        'quiz_id' => $quiz_id,
                                        'question_id' => $qq->id,
                                        'marks' => $tf_marks,
                                    );
                                DB::table('individual_quiz_questions_obtained_marks')->insert($individual_marks);
                            }
                
                            else
                            {
                                $qstnanswer = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->get()->first();
                            
                                $tfmarks = $qstnanswer->tf_marks;

                                
                                $success = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->update([
                                        'tf_marks' => $tfmarks,
                                    ]);
                                $individual_marks = array(
                                        's_u_id' => Auth::user()->id,
                                        'quiz_id' => $quiz_id,
                                        'question_id' => $qq->id,
                                        'marks' => 0,
                                );
                                DB::table('individual_quiz_questions_obtained_marks')->insert($individual_marks);

                            }
                    } 
                }
            

            $quiz = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->get()->first();
        
            $mcq_marks = $quiz->mcq_marks;
            $tf_marks = $quiz->tf_marks;
            $qa_marks = $quiz->questions_marks;

            $total_marks = $mcq_marks + $tf_marks + $qa_marks;


            $original_quiz_marks = DB::table('quizzes')->where('id', $quiz_id)->get()->first();

            $original_mcq_marks = $original_quiz_marks->mr_per_mcq; 
            $original_tf_marks = $original_quiz_marks->mr_per_tf; 
            $original_qa_marks = $original_quiz_marks->mr_per_qa; 

            
            $no_of_qa = 0;
            $no_of_mcq = 0;
            $no_of_tf = 0;
            foreach ($quiz_questions as $q) 
            {


                if($q->type == 'question/answer')
                {
                    $no_of_qa = $no_of_qa + 1;
                }

                elseif($q->type == 'mcq')
                {
                    $no_of_mcq = $no_of_mcq + 1;
                }

                else
                {
                    $no_of_tf = $no_of_tf + 1;
                }
            }

            $original_qa_marks = $no_of_qa * $original_qa_marks;
            $original_mcq_marks = $no_of_mcq * $original_mcq_marks;
            $original_tf_marks = $no_of_tf * $original_tf_marks;

            $original_marks = $original_qa_marks + $original_mcq_marks + $original_tf_marks;



            $percntage = $total_marks/$original_marks * 100;

            $q_wait = $original_quiz_marks->wait;

            $waited_percentage = $q_wait* $percntage / 100;


            $success = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $quiz_id)->update([
                        'total_marks' => $total_marks,
                        'percentage' => $percntage,
                        'w_percentage' => $waited_percentage,
                    ]);


            // $course = DB::table('courses')->where('id', $request->course_id)->first();

            $course = DB::table('courses')->where('id', $request->course_id)->first();
            $course_instructor = DB::table('users')->where('id', $course->ins_id)->first();
            // dd($course_instructor);
            

            $user = DB::table('users')->where('id', Auth::user()->id)->first();
            
            $student_name  = $user->name;

            $success = DB::table('notifications')->insert([
                'description' => 'Quiz submitted by '. $student_name,
                'created_by' => Auth::user()->id,
                'reciever' => $course_instructor->id,
                'type' => 'Quiz',
              ]);

            Session::flash('message', 'Quiz submitted successfully');
            return redirect('/studentcourses');




            // return $this->solved_quiz_result($quiz_id, $school_id);
        
    }


    public function index($id)
    {
        $quizzes = DB::table('quizzes')->where('instructor_id', Auth::user()->id)->where('course_id', $id)->orderBy('id', 'desc')->get();
        $course_id = $id;
        $instructor_id =  Auth::user()->id;
        return view('quizzes.index', compact('quizzes', 'course_id', 'instructor_id'));
    }

    public function solved_quiz_result($id, $sid)
    {
        $quiz = DB::table('obtained_marks_quiz')->where('s_u_id', Auth::user()->id)->where('quiz_id', $id)->get()->first();
        
        $total_marks = $quiz->total_marks;

        $percentage = $quiz->percentage;


        $grade = DB::table('grades')->where('school_id', $sid)->where([
                    ['marks_from', '<=', (int)$percentage],
                    ['marks_to', '>=', (int)$percentage],
                ])->first(); 


        return view('quizzes.solved_quizzes_obtained_marks', compact('total_marks', 'percentage', 'grade'));
    }



    public function addquestion_to_quiz($insid, $cid, $week, $qid, $clasid)
    {


        $quiz_id = $qid;

       	$all_questions = DB::table('questions')->where('instructor_id', $insid)->where('course_id', $cid)->get()->all();

       	$quiz_questions = DB::table('quiz_questions')->where('quiz_id', $qid)->pluck('question_id');	

       	$arr_questions[] = '';
			foreach($quiz_questions as $quiz_question){
				 $arr_questions[] = $quiz_question;
			}

        $coursequiz = DB::table('quizzes')->where('id', $qid)->get()->first();
        $course = DB::table('courses')->where('id', $coursequiz->course_id)->get()->first();

        return view ('quizzes.addquestion', compact('all_questions', 'quiz_id', 'course', 'week', 'insid', 'clasid', 'arr_questions'));
    }

    public function storequestion_to_quiz(Request $request)
    {
        if(!empty($request->question_id))
        {
             $so = '1';
             DB::table('quiz_questions')->where('quiz_id',$request->quiz_id)->delete();
            foreach( $request->question_id  as $question_id)
            {
                $quiz_questions = array(
                    'quiz_id' => $request->quiz_id,
                    'question_id' => $question_id,
                    'sort_order' => $so,
                );
                $so++;
                DB::table('quiz_questions')->insert($quiz_questions);
            }
          Session::flash('message', 'Selected questions added to quiz.');
          return redirect()->back();
        }
       else
        {
           Session::flash('message', 'No Question Selected');

            return back();
        }
    }

    public function show_quiz($id)
    {
        $questions = DB::table('quiz_questions')->where('quiz_id', $id)->orderBy('sort_order', 'desc')->get()->all();
        $quiz_details  = DB::table('quizzes')->where('id', $id)->get()->first();        
        return view ('quizzes.show_quiz', compact('questions', 'id', 'quiz_details'));
    }

    public function create($insid, $cid, $week, $clasid)
    {
        // dd('asd');
            // $quiz= new Quiz;
    
            // $table = $quiz->getTable();
            
            // $columns  = \Schema::getColumnListing($table);

            // dd($columns);
        $instructor_id = $insid;

        $course = DB::table('courses')->where('id',$cid)->first();
        return view ('quizzes.create', compact('course', 'instructor_id', 'week', 'clasid'));
    }


    public function store(Request $request)
    {
        $quiz = array(
            'quiz_date' => $request->date,
            'negative_marking' => $request->nm,
            'wait' => $request->gw,
            'name' => $request->name,
            'duration' => $request->duration,
            'day' => $request->day,
            'start_time' => $request->stime,
            'end_time' => $request->etime,
            'mr_per_mcq' => $request->mcqmarks,
            'mr_per_qa' => $request->qmarks,
            'mr_per_tf' => $request->tfmarks,
            'week' => $request->week,
            'instructor_id' => Auth::user()->id,
            'course_id' => $request->course_id,
        );
        // dd($quiz);
        $newquiz = DB::table('quizzes')->insertgetId($quiz);

         $course_name = DB::table('courses')->where('id',$request->course_id)->pluck('course_name')->first();
        if(isset($request->send_notification)){
            $std_ids = DB::table('course_students')->where('course_id',$request->course_id)->get()->pluck('student_id');
            foreach ($std_ids as $key => $std_id) {
               DB::table('notifications')->insert([
                'description' => 'Quiz Added To '. $course_name,
                'created_by' => Auth::user()->id,
                'reciever' => $std_id,
                'type' => 'Quiz Update',
              ]);
            }
           
        }
       
            Session::flash('message', 'Quiz created successfully.');
            return redirect('/quiz/addquestion/toquiz/'. $request->instructor_id .'/'. $request->course_id .'/'. $request->week .'/'. $newquiz .'/'. $request->class);
    }

    public function edit($id, $clasid)
    {
        $quiz = DB::table('quizzes')->where('id', $id)->get()->first();

        $week = $quiz->week;
        $course = DB::table('quizzes')->where('instructor_id', Auth::user()->id)->where('id', $id)->pluck('course_id');
        $qcourse = DB::table('courses')->where('id', $course)->get()->first();

        $instructor_id = Auth::user()->id;

        return view('quizzes.edit', compact('quiz', 'qcourse', 'instructor_id', 'week', 'clasid'));
    }

    public function update(Request $request, $id, $clasid)
    {
        $success = DB::table('quizzes')->where('id', $id)->update([
            'quiz_date' => $request->input('date') ?? '',
            'negative_marking' => $request->input('nm') ?? 0,
            'name' => $request->input('name') ?? '',
            'week' => $request->week ?? '',
            'duration' => $request->input('duration') ?? '',
            'day' => $request->input('day') ?? '',
            'start_time' => $request->input('stime') ?? '',
            'end_time' => $request->input('etime') ?? '',
            'mr_per_mcq' => $request->input('mcqmarks') ?? '',
            'mr_per_qa' => $request->input('qmarks') ?? '',
            'mr_per_tf' => $request->input('tfmarks') ?? '',
        ]);


        $course_name = DB::table('courses')->where('id',$request->course_id)->pluck('course_name')->first();
        if(isset($request->send_notification)){
            $std_ids = DB::table('course_students')->where('course_id',$request->course_id)->get()->pluck('student_id');
            foreach ($std_ids as $key => $std_id) {
               DB::table('notifications')->insert([
                'description' => 'Quiz Added To '. $course_name,
                'created_by' => Auth::user()->id,
                'reciever' => $std_id,
                'type' => 'Quiz Update',
              ]);
            }
           
        }
        
            Session::flash('message', 'Quiz Updated successfully');
            return redirect('/course/show_week_details/'. $request->instructor_id .'/'. $request->course_id .'/'. $request->week .'/'. $request->class);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        DB::table('quizzes')->where('id',$id)->delete();

        Session::flash('message', 'Quiz deleted successfully');
    }

    public function search_by_week($insid, $courseid, $week)
    {
        $week = $week;
        $course_id = $courseid;
        $instructor_id = $insid;

        $quizzes = DB::table('quizzes')->where('instructor_id', $instructor_id)->where('course_id', $course_id)->where('week', $week)->orderBy('id', 'desc')->get();
        return view('quizzes.index', compact('quizzes', 'course_id', 'instructor_id'));

    }

    public function edit_quiz_qiuestions($id)
    {
        $questions = DB::table('questions')->where('quiz_id', $id)->get();
        $quiz_questions = DB::table('quiz_questions')->where('quiz_id', $id)->pluck('question_id')->toArray();
        return view('courses.edit_quiz_questions', compact('questions', 'id', 'quiz_questions'));
    }

    public function update_quiz_qiuestions(Request $request, $id)
    {
        DB::table('quiz_questions')->where('quiz_id', $request->id)->delete();
                
          if(!empty($request->question_id))
        {
             $so = '1';
            foreach( $request->question_id  as $question_id)
            {
                $quiz_questions = array(
                    'quiz_id' => $request->quiz_id,
                    'question_id' => $question_id,
                    'sort_order' => $so,
                );
                $so++;
                DB::table('quiz_questions')->insert($quiz_questions);
            }
          Session::flash('message', 'Selected questions added to quiz.');
          return redirect()->back();
        }
       else
        {
           Session::flash('message', 'No Question Selected');

            return back();
        }
        
    }
}
