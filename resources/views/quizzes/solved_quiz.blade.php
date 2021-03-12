@extends('layouts.app')

@section('content')


<style>
	.main_question_div h4 {
	    margin-bottom: 0;
    	font-weight: 500;
	}
	.main_question_div p {
	    font-weight: 400;
    	font-size: 18px;
	}
	.main_question_div {
    	margin-top: 10px;
	}
</style>

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li><a href = "{{url('/classes')}}">Terms/Sessions</a></a></li>

    <li>Courses</li>

    <li>Course weekly details</li>

    <li class = "active">Solved quiz</li>

  </ol>

</div>

<div id="message">

  @if (Session::has('message'))

    <div class="alert alert-info">

      {{ Session::get('message') }}

    </div>

  @endif

</div>

<div class="content_main">

  <div class="all_courses_main">

    <?php
    	$qname = DB::table('quizzes')->where('id', $qid)->get()->first();
    	$check_quiz_questions_marks = DB::table('obtained_marks_quiz')->where('quiz_id', $qid)->get()->first();
    	$quiz_qa_marks = $check_quiz_questions_marks->questions_marks;

    ?>

    <div class="course_table mt-0">

      <div class="course card-header card-header-warning card-header-icon">
        <h3>Challenge({{$qname->name}}) View
        	
        	@if(count($student_quiz_details) > 0)
	            @foreach($student_quiz_details as $index => $q)

	                <?php 


	                  if($q->type == "question/answer")
	                    {
	                      $opts = $q->options;
	                      $file = $q->file;
	                      // dd($file);
	                      // $fileName = $q->file->getClientOriginalName();

	                    }
	                  else
	                    {
	                      $opts = unserialize($q->options);
	                    }
	                    if($q->type == "mcq")
	                    {
	                      $qcorrect = unserialize($q->correct);
	                    }
	                ?>

	                <div id="firstdiv">
	                  <div class="main_question_div">
	                  	<h4>Q# : {{$index+1}}</h4>
	                    <p>{{$q->label}}</p>
	                  </div>
	                  @if($q->type == 'mcq')

	                  <input type="hidden" name="mcqlabel" value="{{$q->label}}">
	                  <input type="hidden" name="question_id[]" value="{{$q->id}}">
	                    <div class="row">
	                      <div class="col-md-3">

	                      	<button type="button" class="btn inst_quiz @if(isset($q->correct) && in_array($opts['opt1'], $qcorrect)) btn-primary @endif"> {{$opts['opt1']}} <input type="checkbox" value="{{$opts['opt1']}}" name="correct{{$q->id}}[]" class="btn check_if_check" /></button>

	                        <!-- <label>{{$opts['opt1']}}</label>
	                        <input type="checkbox" value="{{$opts['opt1']}}" name="correct{{$q->id}}[]" class="btn check_if_check" {{ (isset($q->correct) && in_array($opts['opt1'], $qcorrect)) ? 'checked' : '' }}/> -->
	                      </div>
	                      <div class="col-md-3">

	                      	<button type="button" class="btn inst_quiz @if(isset($q->correct) && in_array($opts['opt2'], $qcorrect)) btn-primary @endif"> {{$opts['opt2']}} <input type="checkbox" value="{{$opts['opt2']}}" name="correct{{$q->id}}[]" class="btn check_if_check"/> </button>

	                        <!-- <label>{{$opts['opt2']}}</label>
	                        <input type="checkbox" value="{{$opts['opt2']}}" name="correct{{$q->id}}[]" class="btn check_if_check" {{ (isset($q->correct) && in_array($opts['opt2'], $qcorrect)) ? 'checked' : '' }}/> -->
	                      </div>
	                      <div class="col-md-3">

	                      	<button type="button" class="btn inst_quiz @if(isset($q->correct) && in_array($opts['opt3'], $qcorrect)) btn-primary @endif">{{$opts['opt3']}}  <input type="checkbox" value="{{$opts['opt3']}}" name="correct{{$q->id}}[]" class="btn check_if_check"/></button>

	                        <!-- <label>{{$opts['opt3']}}</label>
	                        <input type="checkbox" value="{{$opts['opt3']}}" name="correct{{$q->id}}[]" class="btn check_if_check" {{ (isset($q->correct) && in_array($opts['opt3'], $qcorrect)) ? 'checked' : '' }}/> -->
	                      </div>
	                      <div class="col-md-3">

	                      	<button type="button" class="btn inst_quiz @if(isset($q->correct) && in_array($opts['opt4'], $qcorrect)) btn-primary @endif">{{$opts['opt4']}} <input type="checkbox" value="{{$opts['opt4']}}" name="correct{{$q->id}}[]" class="btn check_if_check"/></button>

	                       <!--  <label>{{$opts['opt4']}}</label>
	                        <input type="checkbox" value="{{$opts['opt4']}}" name="correct{{$q->id}}[]" class="btn check_if_check" {{ (isset($q->correct) && in_array($opts['opt4'], $qcorrect)) ? 'checked' : '' }}/> -->
	                      </div>
	                    </div>
	                  @elseif($q->type == 't/f')
	                  <input type="hidden" name="tfabel" value="{{$q->label}}">
	                  <input type="hidden" name="question_id[]" value="{{$q->id}}">
	                    <div>
	                      <div class="row">
	                        <div class="col-md-3 ">


	                         <!--  <label>{{$opts['true']}}</label>

	                          <input type="radio" value="true" name="correcttf{{$q->id}}" class="btn" required="required" {{ (isset($q->correct) && $q->correct == 'true') ? 'checked' : '' }} /> -->

	                          <button type="button" class="btn t_f_btn @if(isset($q->correct) && $q->correct == 'true') btn-primary  @endif">{{$opts['true']}} 
	                          	<input type="radio" value="true" name="correcttf{{$q->id}}" class="btn" required="required" />
	                           </button>
	                                             
	                        </div>
	                        <div class="col-md-3">


	                        	<!-- <label>{{$opts['false']}}</label>
	                          	<input type="radio" value="false" name="correcttf{{$q->id}}" class="btn" required="required" {{ (isset($q->correct) && $q->correct == 'false') ? 'checked' : '' }} /> -->

	                          	<button type="button" class="btn t_f_btn @if(isset($q->correct) && $q->correct == 'false') btn-primary  @endif"> {{$opts['false']}} 

	                          		<input type="radio" value="false" name="correcttf{{$q->id}}" class="btn" required="required" />
	                          	</button>

	                        </div>
	                      </div>
	                    </div>
	                    @elseif($q->type == 'question/answer')
	                    	
	                    	<!-- <input type="hidden" name="qalabel" value="{{$q->label}}">
	                    	<input type="hidden" name="question_id[]" value="{{$q->id}}"> -->
	                    	<div>
		                      	<div class="row">
			                        <div class="col-md-12 ">

			                          <textarea class="form-control" readonly="" name="ans" value="{!! $q->correct !!}" autofocus="" required="" style="height: 100px !important;    padding: 8px;
										border-radius: 4px;">{!! $q->correct !!}</textarea>
			                                    
			                                    
			                        </div>
			                        @if($q->file != null)

				                        <div class="col-md-6 ">

				                           <a class ="btn btn-primary"  href="{{asset('storage/'.$q->file)}}" download >{{$file}}</a>
				                                    
				                                    
				                        </div>
				                    @endif
			                        <div class="w-100">

			                        	@if($quiz_qa_marks > 0)
			                        		<?php

			                        		$qa_marksss = DB::table('individual_quiz_questions_obtained_marks')->where('quiz_id', $qid)->where('question_id', $q->id)->get()->first();
			                        		?>

				                        	<form method="POST" action="/quiz/updatequizmarks" enctype="multipart/form-data">



				                        	@csrf

					                        <input type="hidden" name="quiz_id" value="{{$qid}}">
					                        <input type="hidden" name="student_id" value="{{$stdid}}">
					                        <input type="hidden" name="question_id[]" value="{{$q->id}}">

					                        <?php
					                          $orignal_q = DB::table('quizzes')->where('id', $qid)->get()->first();

					                          $orignal_qa_marks = $orignal_q->mr_per_qa;
					                        ?>

					                        



					                        <div class="col-md-12 ">
					                        	<div class="second_heading_scale pl-0">
					                          <h3 class="main_title_ot">Question Marks</h3>
					                          <p style="font-size:10px;">NOTE: Please enter marks between 0-{{$orignal_qa_marks}}.</p>
					                        </div>
					                          <div class="custom_input_main mobile_field">
					                            <input type="number" class="form-control"  value="{{$qa_marksss->marks}}" name="mrks{{$q->id}}" required="" autofocus="">

					                             <label>Essay Marks<span class="red">*</span></label>                          </div>
					                          @error('mrks')
					                            <span class="invalid-feedback" role="alert">
					                            <strong>{{ $message }}</strong>
					                            </span>
					                          @enderror
					                        </div>

					                        @else


					                        <form method="POST" action="/quiz/updatequizmarks" enctype="multipart/form-data">



				                        	@csrf

					                        <input type="hidden" name="quiz_id" value="{{$qid}}">
					                        <input type="hidden" name="student_id" value="{{$stdid}}">
					                        <input type="hidden" name="question_id[]" value="{{$q->id}}">

					                        <?php
					                          $orignal_q = DB::table('quizzes')->where('id', $qid)->get()->first();

					                          $orignal_qa_marks = $orignal_q->mr_per_qa;
					                        ?>

					                        



					                        <div class="col-md-12 ">
					                        	<div class="second_heading_scale pl-0">
					                          <h3 class="main_title_ot">Question Marks</h3>
					                          <p style="font-size:10px;">NOTE: Please enter marks between 0-{{$orignal_qa_marks}}.</p>
					                        </div>
					                          <div class="custom_input_main mobile_field">
					                            <input type="number" class="form-control"  value="{{old('marks')}}" name="mrks{{$q->id}}" required="" autofocus="">

					                             <label>Essay Marks<span class="red">*</span></label>                          </div>
					                          @error('mrks')
					                            <span class="invalid-feedback" role="alert">
					                            <strong>{{ $message }}</strong>
					                            </span>
					                          @enderror
					                        </div>

					                        @endif
			                                    
			                                    
			                        </div>
		       
		                    	</div>


	                        
	                    	</div>
	                  	@endif
	                  
	                </div> 
	            @endforeach
            	<div class="end_btn text-center mt-4">
            		<button type="submit" class="btn save_btn btn-primary">Save</button>
				                    </form>
				@endif


          			<a  href="{{url('/quiz/attempted_by/'. $qid .'/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}"><button type="button" class="btn btn-info">Go Back</button></a>
            	</div>

      </div>

    </div>

  </div>

</div>

<!-- <script>
	$(document).ready(function() {
	    if($('.check_if_check').is(":checked")) {
	        $('.inst_quiz').addClass("btn-primary");
	    } else {
		        $('.inst_quiz').removeClass("btn-primary");
	    }	
	});
</script> -->


<script type="text/javascript">
  
$(':radio,:checkbox').click(function(){
    return false;
});

</script>

@endsection