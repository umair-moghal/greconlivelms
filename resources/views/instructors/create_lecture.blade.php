@extends('layouts.app')
@section('content')



<div id="message">
    @if (Session::has('message'))
        <div class="alert alert-info">
        {{ Session::get('message') }}
        </div>
    @endif  
</div>
  <div class="breadcrumb_main">
    <ol class="breadcrumb">
      <li><a href = "{{asset('/dashboard')}}">Home</a></li>
      <li class = "active">Add New Lecture</li>
    </ol>
  </div>
  <div class="assignment">
    <div class="card-header main_ac">
      <h3>Add Lecture</h3>
      <div class="ac_add_form">
        @foreach ($errors->all() as $error)
          <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
        <form action="{{url('/lecture/create')}}" method="post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="course_id" value="{{$course->id}}">
          <input type="hidden" name="instructor_id" value="{{$instructor_id}}">
          <input type="hidden" name="week" value="{{$week}}">
          <div class="row">
            <div class="col-md-6 p_left">
                      <div class="custom_input_main">
                        <input type="text" class="form-control" value="{{ old('topic')}}" name="topic" required="" minlength="3" maxlength ="50" autofocus="">
                        <label>Topic <span class="red">*</span></label>
                      </div>
                          @error('topic')
                          <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div><br>
                      <div class="col-md-6 p_right">

                    <div class="custom_input_main select_plugin mobile_field">
                      <?php   
                      // dd($course);
                      $date = $course->start_date;
                      $weeks = $week-1;
                      // Create and modify the date.
                      $dateTime = DateTime::createFromFormat('Y-m-d', $date);
                      $dateTime->add(DateInterval::createFromDateString($weeks . ' weeks'));

                      

                      $dateTime_max = DateTime::createFromFormat('Y-m-d', $date);
                      $dateTime_max->add(DateInterval::createFromDateString($weeks+1 . ' weeks'));


                      // dd($dateTime->format('Y-m-d'));
                      ?>

<input type="date" id="date" name="lec_date" required min="{{$dateTime->format('Y-m-d')}}" max="{{$dateTime_max->format('Y-m-d')}}">

                    {{-- <select class="selectpicker" name="day">

                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>

                    </select> --}}

                    <label class="select_lable">Select Day</label>

                  </div>

                  </div>

                   <div class="form-check">
                              <input type="checkbox" name="send_notification"><label> Check to Send Notification for Resource Updates.</label>   
                            </div>

                            
            <div class="col-md-12">
              <div class="s_form_button text-center">
                <a href="{{ url()->previous() }}" class="btn cncl_btn">Cancel</a>
                <button type="submit" class="btn save_btn">Save<div class="ripple-container"></div></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(
      function() {
    
        //GET THE DATE FROM THE TEXT BOX
        var placeholder = $("#tbDate").val();
        //MAKE A DATE FROM THE TEXT BOX VALUE
        d = new Date(placeholder);
    
        //MAKE THE TEXT BOX A DATE PICKER
        $(".datepicker").datepicker({
          minDate: x(d), //SET THE MIN ALLOWED DATE FOR YOUR DATE PICKER
          maxDate: y(d), //SET THE MAX ALLOWED DATE FOR YOUR DATE PICKER
          numberOfMonths: 2,
          beforeShowDay: $.datepicker.noWeekends,
          dateFormat: 'yy-mm-dd'
        });
      });
    
    //FIND THE DAYS OF WEEK DESIRED FOR THE WEEK OF GIVEN DATE  
    function x(d) {
      var date = new Date(d);
      if (date.getDay() > 0) {
        date.setDate(date.getDate() - (date.getDay() - 1));
        return date;
      } else {
        return date;
      }
    }
    
    function y(d){
      var date = new Date(d);
      if (date.getDay() < 6) {
        date.setDate(date.getDate() + ((6 - date.getDay())));
        return date;
      } else {
        return date;
      }
    }
    
    
    </script>  


<script type="text/javascript">
  setTimeout(function() {
    $('#message').fadeOut('fast');
}, 2000);
</script>
 @endsection