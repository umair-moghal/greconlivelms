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

    <li class = "active">Edit Quiz</li>

  </ol>

</div>

<div class="content_main">
  <div class="profile_main">
    <div class="profile mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        <h3 class="main_title_ot">Edit Quiz</h3>
        <div class="tab-content">
          <form method="POST" action="{{url('/quiz/edit/'.$quiz->id .'/'. $clasid)}}" enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="course_id" value="{{$qcourse->id}}">
            <input type="hidden" name="instructor_id" value="{{$instructor_id}}">
            <input type="hidden" name="week" value="{{$week}}">
            <input type="hidden" name="class" value="{{$clasid}}">

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" type="text" name="name" value="{{$quiz->name}}" required minlength="1" maxlength="255" autofocus="">

                      <label>Quiz Name<span class="red">*</span></label>

                    </div>

                    @error('name')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-12">

                    <div class="custom_input_main select_plugin mobile_field">

                    <select class="selectpicker" name="duration">

                      <?php
                        $total = 180;
                      ?>

                      @for($i = 1; $i <= $total; $i++)
                        <option   @if($quiz->duration == $i) Selected @endif  value="{{$i}}">{{$i}} minutes</option>

                      @endfor

                    </select>

                    <label class="select_lable">Duration</label>

                  </div>

                  </div>


                  <div class="col-md-12">

                    <div class="custom_input_main select_plugin mobile_field">

                    <select class="selectpicker" name="day">

                      <option   @if($quiz->day == "monday") Selected @endif  value="monday">Monday</option>

                      <option   @if($quiz->day == "tuesday") Selected @endif  value="tuesday">Tuesday</option>

                      <option   @if($quiz->day == "wednesday") Selected @endif  value="wednesday">Wednesday</option>

                      <option   @if($quiz->day == "thursday") Selected @endif  value="thursday">Thursday</option>

                      <option   @if($quiz->day == "friday") Selected @endif  value="friday">Friday</option>


                    </select>

                    <label class="select_lable">Day</label>

                  </div>

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" type="time" name="stime" value="{{$quiz->start_time}}" required minlength="1" maxlength="255" autofocus="">

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

                      <input class="form-control" type="time" name="etime" value="{{$quiz->start_time}}" required autofocus="">

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

                      <input type="date" class="form-control" name="date" value="{{$quiz->quiz_date}}" onchange="invoicedue(event);" class="mb-4" required="" autofocus="">

                      <label>Quiz Date

                        <span class="red">*</span></label>

                      </div>

                    </div>

                    <div class="row px-3"> 

                      <label class="mb-1">

                        <h6 class="mb-0 text-sm" style="color:black; margin-right: 10px">Negative Marking</h6>

                      </label> 

                      <label class="mb-1">

                          <h6 class="mb-0 text-sm" style="color:black; margin-right: 10px">Yes</h6>

                      <input type="radio" value="1" name="nm" class="mb-4" {{ (isset($quiz->negative_marking) && $quiz->negative_marking == '1') ? 'checked' : '' }}>

                      </label> 

                      <label class="mb-1">

                          <h6 class="mb-0 text-sm" style="color:black; margin-right: 10px">No</h6>

                      <input type="radio" value="0" name="nm" class="mb-4" {{ (isset($quiz->negative_marking) && $quiz->negative_marking == '0') ? 'checked' : '' }}>

                      </label> 

                          

                    </div>
                    <div class="col-md-12">
                    <h3 class="main_title_ot">Set Marks</h3>
                    </div>
                    <br>
                    <br><br>


                  <div class="col-md-6 p_left">

                    <div class="custom_input_main select_plugin mobile_field">

                      <input type="number" name="mcqmarks" value="{{$quiz->mr_per_mcq}}" required  autofocus="">

                    <label class="select_lable">Marks per mcq's</label>

                  </div>

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main select_plugin mobile_field">

                      <input type="number" name="tfmarks" value="{{$quiz->mr_per_tf}}" required  autofocus="">

                    <label class="select_lable">Marks per true/false</label>

                  </div>

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main select_plugin mobile_field">

                      <input type="number" name="qmarks" value="{{$quiz->mr_per_qa}}" required  autofocus="">

                    <label class="select_lable">Marks per question</label>

                  </div>

                  </div>

                  </div>

                  </div>

                  <div class="s_form_button text-center">

                    <a  href="{{ url()->previous() }}"><button type="button" class="btn cncl_btn">Cancel</button></a>

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

@endsection