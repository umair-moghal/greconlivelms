<!--   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>   -->

@extends('layouts.app')

@section('content')



<style>

  [type='color'] {

  -moz-appearance: none;

  -webkit-appearance: none;

  appearance: none;

  padding: 0;

  width: 15px;

  height: 15px;

  border: none;

}



[type='color']::-webkit-color-swatch-wrapper {

  padding: 0;

}



[type='color']::-webkit-color-swatch {

  border: none;

}



.color-picker {

  padding: 10px 15px;

  border-radius: 10px;

  border: 1px solid #ccc;

  background-color: #f8f9f9;

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

    <li class = "active">Edit Course</li>

      </ol>

    </div>

    <form class="form-horizontal" method="POST" action="{{ url('/course/update/'. $course->id) }}" enctype="multipart/form-data">

                    @csrf

        <div class="content_main">

          <div class="profile_main">

            <div class="profile mt-0">

              <div class="course card-header card-header-warning card-header-icon">

                

                <h3 class="main_title_ot">{{$course->course_name}}</h3>

                <div class="tab-content">

                  <form method="POST" action="/safetytips/create" enctype="multipart/form-data">

                    @csrf

                    @foreach ($errors->all() as $error)

                      <div class="alert alert-danger">{{ $error }}</div>

                    @endforeach

                    <div class="tab-pane active" id="tab_default_3">

                      <div class="s_profile_fields">

                        <div class="row">

                          <div class="col-md-6">

                            <div class="custom_input_main mobile_field">

                              <input type="text" class="form-control" name="cname"  value="{{old('cname', $course->course_name)}}" required=""  minlength="3" maxlength ="50" autofocus="">

                              <label>Course name<span class="red">*</span></label>

                            </div>

                            @error('cname')

                              <span class="invalid-feedback" role="alert">

                              <strong>{{ $cname }}</strong>

                              </span>

                            @enderror

                          </div>

                          <div class="col-md-6">

                            <div class="custom_input_main mobile_field">

                              <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg" autofocus="">

                              <label>Image<span class="red">*</span></label>

                              <img src="{{asset('/assets/img/upload/'.$course->image)}}" width="100" height="150" alt="" class="img-fluid">

                            </div>

                          </div>



                          @if(Auth::user()->role_id == '3')
                          <div class="col-md-4 ">

                              <div class="custom_input_main select_plugin mobile_field">

                                <select class="selectpicker" required="" name="ins">

                                    <?php
                                      $instructors = DB::table('instructor_school')->where('sch_u_id', Auth::user()->id)->get();
                                    ?>

                                      @foreach($instructors as $instructor)

                                      <?php
                                        $ins = DB::table('users')->where('id', $instructor->i_u_id)->get()->first();
                                      ?>


                                        <option @if($course->ins_id == $ins->id) selected @endif value="{{$ins->id}}">{{$ins->name}}</option>

                                      @endforeach

                                </select>

                                <label class="select_lable">Select Instructor</label>

                              </div>

                            </div>
                          @endif

                          <div class="col-md-6">

                            <div class="custom_input_main mobile_field">

                              <input type="date" class="form-control" name="sdate" value="{{old('sdate',$course->start_date)}}"  onchange="invoicedue(event);" class="mb-4" required="" autofocus="">

                              <label>Start Date

                                <span class="red">*</span></label>

                              </div>

                            </div>

                            <div class="col-md-6 ">

                              <div class="custom_input_main mobile_field">

                                <input type="date" class="form-control" name="edate" value="{{old('edate',$course->end_date)}}" onchange="invoicedue(event);" required="" autofocus="">

                                <label>End Date

                                  <span class="red">*</span></label>

                                </div>

                              </div>

                               <div class="col-md-6">

                            <div class="custom_input_main mobile_field">

                              <input type="text" class="form-control"  name="building" value="{{old('building',$course->building)}}" required="" minlength="3" maxlength ="50" autofocus="">

                              <label>Building Name

                                <span class="red">*</span></label>

                              </div>

                              @error('building')

                              <span class="invalid-feedback" role="alert">

                              <strong>{{ $building }}</strong>

                              </span>

                            @enderror

                            </div>



                            <div class="col-md-6">

                            <div class="custom_input_main mobile_field">

                              <input type="text" class="form-control"  name="rno" value="{{old('rno',$course->room_number)}}" required="" minlength="3" maxlength ="50" autofocus="">

                              <label>Room No.

                                <span class="red">*</span></label>

                              </div>

                              @error('rno')

                              <span class="invalid-feedback" role="alert">

                              <strong>{{ $rno }}</strong>

                              </span>

                            @enderror

                            </div>

                    <div class="col-md-4  colorpicker colorpicker-component">

                      <div class="custom_input_main mobile_field">

                        <span class="color-picker">

                          <label for="colorPicker" class="lable_color_picker">

                            <input type="color"   value="#1DB8CE" id="colorPicker">

                            <input type="hidden"  name="ccolor" value="#1DB8CE" id="colorPickerr">

                          </label>

                        </span>



                        <label>Course Color

                          <span class="red">*</span></label>

                        </div>

                      </div>



                      <div class="col-md-4">


                         <div class="custom_input_main select_plugin mobile_field">

                          <select class="selectpicker" name="sessions">

                            <option  {{ ( $course->sessions) == '1' ? 'selected' : '' }}  value="1" >One session  ( 9 weeks ) </option>

                              <option {{ ( $course->sessions) == '2' ? 'selected' : '' }}  value="2">Two sessions-One semester ( 18 weeks )</option>

                              <option {{ ( $course->sessions) == '3' ? 'selected' : '' }}  value="3">Three session  ( 27 weeks )</option>

                              <option {{ ( $course->sessions) == '4' ? 'selected' : '' }}  value="4">Four sessions-Two semesters ( 36 weeks )</option>

                          </select>

                          <label class="select_lable">Sessions</label>

                        </div>

                            

                              

                            </div>
                     <div class="col-md-4">

                      <div class="custom_input_main select_plugin mobile_field">

                          <select class="selectpicker" name="unlock_week">

                              <option {{ ( $course->sessions) == '0' ? 'selected' : '' }}  value="0">Monday Morning</option>

                              <option {{ ( $course->sessions) == '1' ? 'selected' : '' }}  value="1">1 Day Ago</option>

                              <option {{ ( $course->sessions) == '2' ? 'selected' : '' }}  value="2">2 Day Ago</option>

                          </select>

                          <label class="select_lable">Unlock Upcoming Week Resources</label>

                        </div>


                            

                             

                            </div>


                            
							@if(count($courseavailablegrades)>0)

                    <div class="second_heading_scale">
                      <h3 class="main_title_ot">Course Grading Scale ( % )</h3>
                      <p style="font-size:10px;">NOTE: Sum of following must equal 100%.</p>
                    </div>
<?php
			 foreach($courseavailablegrades  as $index => $coursegrade){
				 //print_r($coursegrade);exit;
					$courseassignedgrades = DB::table('course_assigned_grade_percentages')->where('available_course_grades_id' , $coursegrade->id)->where('course_id' , $course->id)->get();
$checked = '';
$ass_grade_percentage = '';

if(sizeof($courseassignedgrades)>0) { 
$checked = 'checked';
 $ass_grade_percentage = $courseassignedgrades[0]->grade_percentage;

}
?>    
	<div class="col-md-4">
                      <div class="custom_input_main mobile_field">

                      
                      <input type="text" class="form-control grade_percentage"  value="<?=old('grade_percentage',$ass_grade_percentage)?>" name="coursegrade_options_<?=$coursegrade->id?>"   autofocus="">


                      <input type="checkbox" <?=$checked?> name="selected_grade_options[]" value="<?php echo $coursegrade->id;?>"><label><?php echo $coursegrade->name;?>(%)<?=$ass_grade_percentage?>

                        <span class="red">*</span></label>

                      </div>
                    </div>
<?php  
			 }
			
			
?>			
@endif



                            </div>

                            <div class="row">

                              <div class="col-md-12">

                                <div class="custom_input_main mobile_field">

                                  <textarea name="cdescription" cols="8" id="txtEditor" value="{!!old('cdescription')!!}" style="height: 35px;width: 100%;" required="">

                                    {{old('cdescription',$course->course_description)}}

                                  </textarea>

                                  <label>Enter Description <span class="red">*</span></label>

                                </div>

                              </div>

                            </div>

                            <div class="form-check">
                              <input type="checkbox" name="send_notification"><label> Check to Send Notification for Course Updates.</label>   
                            </div>

                            <div class="s_form_button text-center">

                              <a href="{{url('/course')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                              <button type="submit" class="btn save_btn checkers">Update</button>

                            </div>

                          </div>

                        </div>

                      </form>

                    </div>

                    

                  </div>

                </div>

              </div>

        </div>

    </form>



<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <script>
     $(".checkers").mouseover(function(){
      if(parseInt($(".quiz_percent").val()) + parseInt($(".test_percent").val()) + parseInt($(".assignment_percent").val()) != 100){
        // alert('Sum of Quizzes, Tests and Assignments must be equal to 100 %');
      }
    });

CKEDITOR.replace( 'txtEditor' );

</script>







<script>

   document.querySelectorAll('input[type=color]').forEach(function(picker) {



  var targetLabel = document.querySelector('label[for="' + picker.id + '"]'),

    codeArea = document.createElement('span');



  codeArea.innerHTML = picker.value;

  targetLabel.appendChild(codeArea);



  picker.addEventListener('change', function() {

    codeArea.innerHTML = picker.value;

    // alert(picker.value);

    document.getElementById("colorPickerr").value() = picker.value ;

    targetLabel.appendChild(codeArea);

  });

});

  </script>

<!-- <script src="{{asset('js/bootstrap-colorpicker.min.js')}}"></script> -->

                <!-- <script src="//unpkg.com/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script> -->

                <!-- <script src="{{asset('dist/js/bootstrap-colorpicker.js')}}"></script> -->

                <!-- <script>

                    $(function () {

                      // Basic instantiation:

                      $('#demo-input').colorpicker();

                      

                      // Example using an event, to change the color of the #demo div background:

                      $('#demo-input').on('colorpickerChange', function(event) {

                        $('#demo').css('background-color', event.color.toString());

                      });

                    });

                </script> -->

                  <script type="text/javascript">

                    setTimeout(function() {

                      $('#message').fadeOut('fast');

                  }, 30000);

                  </script>

                 <!--  <script type="text/javascript">

  $('.colorpicker').colorpicker({});

</script> -->

@endsection

             