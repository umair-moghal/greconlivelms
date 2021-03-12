@extends('layouts.app')

@section('content')


<style type="text/css">
  
  .box{
    padding:60px 0px;
}

.box-part{
    background:#eef2fb;
    border-radius:0;
    padding:60px 10px;
    margin:30px 0px;
}
.text{
    margin:20px 0px;
}

.fa{
     color:#4183D7;
}
.show_detail_tags {
    background: #3399ff;
    padding: 2rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #fff;
}
</style>

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li>Terms/Sessions</li>

    <li><a href = "{{ url()->previous() }}">{{$course->course_name}} Course</a></li>

    <li class = "active">All Weekly Details</li>

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

      

      <div class="course_table no_before_table mt-0">

        <div class="course card-header card-header-warning card-header-icon">

          

          <h3>{{$course->course_name}} Weekly Details</h3>
          
            <div class="show_detail_tags mt-3">
              <div class="top_tag text-center">
                <h5>Unique Identifier: <span>{{$course->unique_identifier}}</span></h5>
              </div>	
              <div class="container">
                <div class="row">
                 @if(count($course_assigned_grade_percentages)>0)
					  @foreach($course_assigned_grade_percentages as $index =>$grades)
				  <div class="col-md-3" text-center>
                    <p>{{$grades->grade_title}}:  <span>{{$grades->grade_percentage}}%</span></p>
                  </div>
				 
					  @endforeach
				   @endif
                  <div class="col-md-3 text-center">
                    <p>Room No: <span>{{$course->room_number}}</span></p>
                  </div>
                </div>
              </div>
            </div>

          
          @if($weeks > 0)

            <div class="table_filters">

            <!--   <div class="table_search">

                <input type="text" name="search" id="search" value="" placeholder="Search...">

                <a href="#"> <i class="fa fa-search"></i> </a>

              </div> -->

             <!--  <div class="table_select">

                <select class="selectpicker">

                  <option>All Classes</option>

                  <option>Today </option>

                  <option>Macro Economics I</option>

                  <option>Macro Economics II</option>

                </select>

              </div> -->

            </div>

              <div class="box">
                <div class="container">
                  <div class="row">
                   
                   @if(auth()->user()->role_id == '5')



                        <?php
                        $i = 1;
                        if(isset($instructor_id)){


                        $quizzes = DB::table('quizzes')->where([
                              ['instructor_id', '=', $instructor_id],
                              ['course_id', '=', $course->id],
                              ['week', '=', $i],
                          ])->count();
                        $lectures = DB::table('lectures')->where([
                              ['instructor_id', '=', $instructor_id],
                              ['course_id', '=', $course->id],
                              ['week', '=', $i],
                          ])->count();
                        $links = DB::table('courselink')->where([
                              ['instructor_id', '=', $instructor_id],
                              ['course_id', '=', $course->id],
                              ['week', '=', $i],
                          ])->count();
                        $videos = DB::table('resources')->where([
                              ['instructor_id', '=', $instructor_id],
                              ['course_id', '=', $course->id],
                              ['week', '=', $i],
                          ])->count();
                        $downloadables = DB::table('resources')->where([
                              ['instructor_id', '=', $instructor_id],
                              ['course_id', '=', $course->id],
                              ['week', '=', $i],
                          ])->count();
                      }
                      else{
                        $quizzes = 0;
                        $lectures = 0;
                        $links = 0;
                        $videos = 0;
                        $downloadables = 0;
                      }

                      ?>


                      <div class="col-md-4">
                      <a href="{{url('/course/show_week_details/'. $instructor_id .'/'. $course->id .'/'. $i .'/'. $clasid)}}">
                        <div class="member aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
                            <div class="pic">
                                <img src="{{asset('/assets/img/upload/'.$course->image)}}" width="50" alt="" class="img-fluid">
                            </div>
                            <div class="member-info">
                                <h4>Week {{$i}}</h4>
                                <p><span class="make_circle">{{$links}}</span> Links</p>
                                <p><span class="make_circle">{{$videos}}</span> Videos</p>
                                <p><span class="make_circle">{{$quizzes}}</span> Quizzes</p> 
                                <p><span class="make_circle">{{$lectures}}</span> Lectures</p>
                                <p><span class="make_circle">{{$downloadables}}</span> Downloadables</p>
                                <div class="img_buttons">
                                    <a class="btn btn-primary" href="{{url('/course/show_week_details/'. $instructor_id .'/'. $course->id .'/'. $i.'/'. $clasid)}}">View Resources</a>
                                </div>
                            </div>
                        </div>
                      </a>
                    </div>




                   @else
                    @for($i = 1; $i <= 9; $i++)


                      <?php
                        $quizzes = DB::table('quizzes')->where([
                              ['instructor_id', '=', $instructor_id],
                              ['course_id', '=', $course->id],
                              ['week', '=', $i],
                          ])->count();
                        $lectures = DB::table('lectures')->where([
                              ['instructor_id', '=', $instructor_id],
                              ['course_id', '=', $course->id],
                              ['week', '=', $i],
                          ])->count();
                        $links = DB::table('courselink')->where([
                              ['instructor_id', '=', $instructor_id],
                              ['course_id', '=', $course->id],
                              ['week', '=', $i],
                          ])->count();
                        $videos = DB::table('resources')->where([
                              ['instructor_id', '=', $instructor_id],
                              ['course_id', '=', $course->id],
                              ['week', '=', $i],
                          ])->count();
                        $downloadables = DB::table('resources')->where([
                              ['instructor_id', '=', $instructor_id],
                              ['course_id', '=', $course->id],
                              ['week', '=', $i],
                          ])->count();

                      ?>
                    <div class="col-md-4">
                      <a href="{{url('/course/show_week_details/'. $instructor_id .'/'. $course->id .'/'. $i .'/'. $clasid)}}">
                        <div class="member aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
                            <div class="pic">
                                <img src="{{asset('/assets/img/upload/'.$course->image)}}" width="50" alt="" class="img-fluid">
                            </div>
                            <div class="member-info">
                                <h4>Week {{$i}}</h4>
                                <span><p class="make_circle">{{$links}}</p> Links</span>
                                <span> <p class="make_circle">{{$videos}}</p> Videos</span>
                                <span> <p class="make_circle">{{$quizzes}}</p> Quizzes</span>
                                <span> <p class="make_circle">{{$lectures}}</p> Lectures</span>
                                <span> <p class="make_circle">{{$downloadables}}</p> Downloadables</span>
                                <div class="img_buttons">
                                    <a class="btn btn-primary" href="{{url('/course/show_week_details/'. $instructor_id .'/'. $course->id .'/'. $i.'/'. $clasid)}}">View Resources</a>
                                </div>
                            </div>
                        </div>
                      </a>
                    </div>
                    @endfor
                    @endif
                  </div>    
                </div>
              </div>
              @if($weeks > 9)
                <p align="center" style="color: red">Next session weeks will appear soon.</p>
              @endif

           @else

            <p>There is nothing related course</p>

          @endif

        </div>

      </div>

    </div>

  </div>



<script>

    $(document).ready(function(){

      $("#search").on("keyup", function() {

        var value = $(this).val().toLowerCase();

        // alert(value);

        $("#mybody tr").filter(function() {

          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

        });

      });

    });

  </script>

<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

</script>

<script type="text/javascript">

  setTimeout(function() {

    $('#message').fadeOut('fast');

}, 2000);

</script>

          <!-- <script src="{{url('backend/sweetalerts/sweetalert2.all.js')}}"></script> -->


@endsection