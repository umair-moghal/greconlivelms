@extends('layouts.app')

<link href="{{url('/assets/css/calendar.css')}}" rel="stylesheet" />
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>





@section('content')

<style>
	.checkbox_btn {
	    display: flex;
	    align-items: baseline;
	    justify-content: space-between;
	}
	.search_btn_btn button {
		padding: 10px !important;
    	border-radius: 50% !important;
	}
</style>



<div class="content_main">

    <div class="all_courses_main">

      

      <div class="course_table mt-0">

        <div class="course card-header card-header-warning card-header-icon">

          
        	<div class="align_heading d-flex align-items-center justify-content-between">
        		<h3>Students Statistics</h3>
        		<a href="/csv_student_enrollment"><button class="btn btn-primary">Export Excel</button></a>
        	</div>
          

            <div class="table_filters">

              <div class="table_search w-100">
            <form method="post" action="/reports/student_enrollment">
                @csrf
              	<div class="row">
              		<div class="col-md-4">
						<div class="custom_input_main select_plugin mobile_field">

                       @php
                        $courses_list = array();

                        if(auth()->user()->role_id == 5){
                          $course_ids = DB::table('course_students')->where('student_id',auth()->user()->id)->get()->pluck('course_id');
                          $courses_list = DB::table('courses')->whereIn('id',$course_ids)->get();
                        }elseif(auth()->user()->role_id == 4){
                          $courses_list = DB::table('courses')->where('ins_id',auth()->user()->id)->get();
                        }elseif(auth()->user()->role_id == 3){
                          $instructors = DB::table('instructor_school')->where('sch_u_id',auth()->user()->id)->get()->pluck('i_u_id');
                          $courses_list = DB::table('courses')->whereIn('ins_id',$instructors)->orderBy('course_name','asc')->get();
                        }
                      @endphp

                        <select class="selectpicker"  name="course" id="slct">

                          <option>Select Course</option>
                          @foreach($courses_list as $list)
                          <option value="{{$list->id}}" @if(isset($course) && $course == $list->id) selected @endif>{{$list->course_name}}</option>
                          @endforeach
                        </select>

                        <label class="select_lable">Courses</label>

                      </div>
              		</div>
              		<div class="col-md-4">
              			<div class="custom_input_main mobile_field" style="margin-top: 6px;">

                      <input type="text" @if(isset($name)) value="{{$name}}" @endif class="form-control" name="student_name">

                      <label>Search Student

                        <span class="grey">*</span></label>

                      </div>
              		</div>
              		<!-- <div class="col-md-3">
              			<div class="custom_input_main mobile_field" style="margin-top: 6px;">

                      <input type="text" class="form-control" name="instructor_name">

                      <label>Search Instructor

                        <span class="grey">*</span></label>

                      </div>
              		</div> -->
              		<div class="col-md-4 pl-lg-0">
              			<div class="checkbox_btn">
              				<div class="checkboxes_">
              					<div class="custom_checkbox">
				                    <input type="checkbox" id="1" class="vh" value="highest" name="highest">
				                    <label for="1">Highest Grades</label>
			                  	</div>
			                  	<div class="custom_checkbox">
				                    <input type="checkbox" id="2" class="vh" value="lowest" name="lowest">
				                    <label for="2">Lowest Grades</label>
				                  </div>
              				</div>
              				<div class="search_btn_btn">
              					<button type="submit" class="btn btn-primary rounded"><i class="fa fa-search"></i></button>
              				</div>
              			</div>
              		</div>
              	</div>
              </form>

                <!-- <input type="text" name="search" id="search" value="" placeholder="Search...">

                <a href="#"> <i class="fa fa-search"></i> </a> -->

                

              </div>
              



            </div>

            <table class="table table-hover" id="table-id">

              <thead>

                <tr>

                  <th scope="col">ID</th>

                  <th scope="col">Name</th>

                  <th scope="col">Subject</th>

                  <th scope="col">Course</th>

                  <th scope="col">Instructor</th>

                  <th scope="col">Attendance</th>

                  <th scope="col">Grades</th>

                  <!-- <th scope="col">Marked By</th> -->

                  <th scope="col">Created At</th>

                </tr>

              </thead>

              <tbody>
                @foreach($students as $student)
                @php
                  $stu = DB::table('students')->where('s_u_id',$student->id)->first();
                  $course = DB::table('course_students')->where('student_id',$student->id)->pluck('course_id')->first();
                  $course = DB::table('courses')->where('id',$course)->first();
                  $instructor = DB::table('users')->where('id',$course->ins_id)->first();

                @endphp
                <tr>
                  <td>{{$student->unique_id}}</td>
                  <td>{{$student->name}}</td>
                  <td>{{$stu->grade_level}}</td>
                  <td>{{$course->course_name}}</td>
                  <td>{{$instructor->name}}</td>
                  <td>{{$student->id}}</td>
                  <td>{{$student->id}}</td>
                  <td>{{$student->created_at}}</td>
                  
                </tr>
                @endforeach
              </tbody>

            

            </table>  

            
          

        </div>

      </div>

    </div>

  </div>

@endsection