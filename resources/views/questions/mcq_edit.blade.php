@extends('layouts.app')

@section('content')

   <style>
   #lod{
   visibility:hidden;
   }
   </style>

<div id="message">

  @if (Session::has('message'))

    <div class="alert alert-info">

      {{ Session::get('message') }}

    </div>

  @endif

</div>

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li class = "active">Edit Multiple Choice</li>

  </ol>

</div>

<div class="content_main">
  <div class="profile_main">
    <div class="profile mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        <h3 class="main_title_ot">Edit MCQ</h3>
        <div class="tab-content">
          <?php
            $opts = unserialize($mcq->options);
          ?>
          <form method="POST" action="{{url('/mcq/update/'.$mcq->id)}}" enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="course_id" value="{{$courseid}}">
                <div class="quiz_head">
                <h5>Question</h5>
                <div class="quiz_form">
                  <div class="custom_input_main remove_ex_margin">
                    <textarea class="form-control" name="label" value="{!!old('label')!!}" autofocus="" required="" style="height: 100px !important;"> 
                      {{$mcq->label}}
                    </textarea>
                    <label>Topic <span class="red">*</span></label>
                  </div>
                </div>
                <div class="qa_quiz">
                  <div class="row">
                    <div class="col-md-10 p_left">
                      <div class="quiz_op">
                        <h4>Options</h4>
                      </div>
                      <div class="custom_input_main mobile_field">
                        <input type="text" class="form-control" name="opt1" value="{{$opts['opt1']}}" required="" >
                        <label>Option - 1.
                          <span class="red">*</span>
                        </label>
                        
                      </div>
                      <div class="custom_input_main mobile_field">
                        <input type="text" class="form-control" name="opt2" value="{{$opts['opt2']}}"  autofocus="">
                        <label>Option - 2.
                          <span class="red">*</span></label>
                          
                        </div>
                        <div class="custom_input_main mobile_field">
                          <input type="text" class="form-control" name="opt3" value="{{$opts['opt3']}}" autofocus="">
                          <label>Option - 3.
                            <span class="red"></span></label>
                            
                          </div>
                          <div class="custom_input_main mobile_field">
                            <input type="text" class="form-control" name="opt4" value="{{$opts['opt4']}}"  autofocus="">
                            <label>Option - 4.
                              <span class="red"></span></label>
                              
                            </div>
                    </div>
                      
                        <div class="col-md-2 p_right">
                          <div class="quiz_ans">
                            <h4>Answer</h4>
                          </div>
                          
                            <div class="cr_btn @if(in_array('opt1', $opts['correct'])) active_cr_btn @endif">
                              <button type="button" class="btn">
                              Correct 
                                  <input type="checkbox" value="opt1" name="correct[]" class="btn" {{ in_array('opt1', $opts['correct']) ? 'checked' : ' ' }}>
                              </button>
                            </div>
                            <div class="cr_btn @if(in_array('opt2', $opts['correct'])) active_cr_btn @endif">
                              <button type="button" class="btn">
                              Correct 
                              <input type="checkbox" value="opt2"  name="correct[]" class="btn"  {{ in_array('opt2', $opts['correct']) ? 'checked' : ' ' }}>
                              </button>
                            </div>
                            <div class="cr_btn @if(in_array('opt3', $opts['correct'])) active_cr_btn @endif">
                              <button type="button" class="btn">
                              Correct 
                              <input type="checkbox" value="opt3" name="correct[]" class="btn"  {{ in_array('opt3', $opts['correct']) ? 'checked' : ' ' }}>
                              </button>
                            </div>
                            <div class="cr_btn @if(in_array('opt4', $opts['correct'])) active_cr_btn @endif">
                              <button type="button" class="btn">
                              Correct 
                              <input type="checkbox" value="opt4" name="correct[]" class="btn"  {{ in_array('opt4', $opts['correct']) ? 'checked' : ' ' }}>
                              </button>
                            </div>

                        </div>
                        </div>
                      </div>
                    </div>




                      <?php
                        $course = DB::table('courses')->where('id', $courseid)->get()->first();
                        $weeks = $course->weeks;
                      ?>

                    <div class="col-md-12">
                    @for($i = 1; $i <= $weeks; $i++)

                      <input type="radio" name="week" value="{{$i}}" id="wk" onclick="showbtn()" required="" @if($mcq->week == $i) Checked @endif>


                      <label class="select_lable">Week {{$i}}</label>

                    @endfor

                  </div>

                    <div class="s_form_button text-center">

                      <a  href="{{url('/mcq/create/'.$courseid)}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                      <button type="submit" class="btn save_btn">Update</button>

                    </div>
                  </div>
                </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

  <script type="text/javascript">
      jQuery(document).ready(function($) {
      $('.cr_btn').click(function(){
        if ($(this).hasClass("active_cr_btn")) {
          $(this).removeClass("active_cr_btn");
        }
        else {
          $(this).addClass("active_cr_btn");
        }
    });
    });
  </script>

@endsection