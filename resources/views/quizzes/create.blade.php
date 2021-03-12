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

    <li class = "active">Create Quiz</li>

  </ol>

</div>

<div class="content_main">
  <div class="profile_main">
    <div class="profile mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        <h3 class="main_title_ot">Add New Quiz</h3>
        <div class="tab-content">
          <form method="POST" action="{{url('/quiz/create')}}" enctype="multipart/form-data">

            @csrf

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="hidden" name="course_id" value="{{$course->id}}">
                      <input type="hidden" name="instructor_id" value="{{$instructor_id}}">
                      <input type="hidden" name="week" value="{{$week}}">
                      <input type="hidden" name="class" value="{{$clasid}}">
                      <input class="form-control" type="text" name="name" value="{{old('name')}}" required minlength="1" maxlength="255" autofocus="">

                      <label>Quiz Name<span class="red">*</span></label>

                    </div>

                    @error('name')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>


                  <div class="col-md-6 p_right">

                    <div class="custom_input_main select_plugin mobile_field">

                    <select class="selectpicker" name="day">

                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>

                    </select>

                    <label class="select_lable">Select Day</label>

                  </div>

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main select_plugin mobile_field">

                    <select class="selectpicker" name="duration">
                      <?php
                        $total = 180;
                      ?>

                      @for($i = 1; $i <= $total; $i++)

                        <option value="{{$i}}">{{$i}} minutes</option>

                      @endfor

                    </select>

                    <label class="select_lable">Duration</label>

                  </div>

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" type="time" name="stime" value="{{old('stime')}}" required minlength="1" maxlength="255" autofocus="">

                      <label>Start Time<span class="red">*</span></label>

                    </div>

                    @error('stime')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" type="time" name="etime" value="{{old('etime')}}" required autofocus="">

                      <label>End Time<span class="red">*</span></label>

                    </div>

                    @error('etime')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                   
                 <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="date" class="form-control" name="date" value="{{old('date')}}" onchange="invoicedue(event);" class="mb-4" required="" autofocus="">

                      <label>Quiz Date

                        <span class="red">*</span></label>

                      </div>

                    </div>

                    <div class="col-md-6 p_right"> 

                      <label class="mb-0 align_raiokbox">

                        Negative Marking

                      </label> 


                      <div class="yes_no_radio_button">
                        <button type="button" class="btn radio_btn">No <input type="radio" value="1" name="nm" class="mb-4"> </button>
                        <button type="button" class="btn radio_btn">Yes <input type="radio" value="0" name="nm" class="mb-4" checked="checked"> </button>
                      </div>

                          

                    </div>
                    <div class="col-md-12">
                    <h3 class="main_title_ot">Set Marks</h3>
                    </div>
                    <br>
                    <br><br>


                  <div class="col-md-4 p_left">

                    <div class="custom_input_main select_plugin mobile_field">

                      <input type="number" class="form-control" name="mcqmarks" value="{{old('mcqmarks')}}">

                    <label class="select_lable">Marks per mcq's</label>

                  </div>

                  </div>

                  <div class="col-md-4 p_left">

                    <div class="custom_input_main select_plugin mobile_field">

                      <input type="number" class="form-control" name="tfmarks" value="{{old('tfmarks')}}">

                    <label class="select_lable">Marks per true/false</label>

                  </div>

                  </div>

                  <div class="col-md-4 p_left">

                    <div class="custom_input_main select_plugin mobile_field">

                      <input type="number" class="form-control" name="qmarks" value="{{old('qmarks')}}">

                    <label class="select_lable">Marks per question</label>

                  </div>

                  </div>

                  </div>

                  <div class="col-md-12">
                    <h3 class="main_title_ot">Set Grade wait</h3>
                  </div>
                    <br>
                    <br><br>

                      <?php
                        $assigned_grade = DB::table('course_assigned_grade_percentages')->where('course_id', $course->id)->get()->all();
                        // dd($assigned_grade);
                      ?>
                      <div class="col-md-12 ">
                        <div class="second_heading_scale pl-0">
                          <p style="font-size:10px;">NOTE: There should be atleast one quiz wait.</p>
                        </div>
                      </div>


                    <div class="col-md-6 p_right">

                    <div class="custom_input_main select_plugin mobile_field">

                    <select class="selectpicker" name="gw">
                        @foreach($assigned_grade as $asgnd_grade)
                          <option value="{{$asgnd_grade->grade_percentage}}">{{$asgnd_grade->grade_title}}</option>
                        @endforeach
                        
                    </select>

                    <label class="select_lable">Select Grade wait</label>
                    @error('gw')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  </div>

                   <div class="form-check">
                    <input type="checkbox" name="send_notification"><label> Check to Send Notification for Resource Updates.</label>   
                  </div>


                  <div class="s_form_button text-center">

                    <a  href="{{ url()->previous() }}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                    <button type="submit" class="btn save_btn">Add</button>

                  </div>
                  </div>
                </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- <script type="text/javascript">  
  $(document).ready(function(){
     $('#sub_button').hide();
  });
</script>
<script type="text/javascript">

  function showbtn()
  {
    $('#sub_button').show();
  }
</script> -->


<script>
   jQuery(document).ready(function() {
      $('.radio_btn').click(function() {
        /* Act on the event */
        $('.radio_btn').removeClass('active');
        $(this).addClass('active');
      }); 
      $('.week_btn').click(function(event) {
        /* Act on the event */
        $('.week_btn').removeClass('btn-primary');
        $(this).addClass('btn-primary');
      });
   });
</script>

@endsection