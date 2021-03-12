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
</style>

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li class = "active">All Subjects</li>

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

          

          <h3>All Subjects</h3>
          <br><br>

          @if(count($classes)>0)

            <div class="table_filters">

          

            </div>


            @if(auth()->user()->role_id == '3')

            <table class="table table-hover" >

              <thead>

                <tr>

                  <th scope="col">Sr.</th>

                  <th scope="col">Name</th>
                  @if(auth()->user()->role_id != '5')

                  <!-- <th scope="col" colspan="2">Instructors</th> -->

                  <!-- <th scope="col"> Show Instructors</th> -->

                  <th scope="col"> Courses </th>

                  <!-- <th scope="col"> All courses</th> -->

                  <!-- <th scope="col" colspan="2"> Students</th>

                  <th scope="col"> Add Student </th> -->


                  <th scope="col">Action</th>
                  @endif

                </tr>

              </thead>

              <tbody id="mybody">

                <?php $count = 1;  ?>

                @foreach($classes as $class)

                    <?php
                      // $stds = DB::table('classes_students')->where('class_id', $class->id)->count();
                      $class_courses = DB::table('courses')->where('clas_id', $class->id)->pluck('id');
                      $noOfInstructors = DB::table('course_instructor')->wherein('course_id', $class_courses)->count();
                    ?>

                <tr>


                 <th scope="row">#{{$count}}   </th>
                     <?php $count++; ?>

                  <td class="first_row">

                    <div class="course_td">

                      <p>{{$class->name}}</p>

                    </div>

                  </td>
                  @if(auth()->user()->role_id != '5')

                 

                  <td>
                      
                    <a href="{{url('/class/addcourse/toclass/'.$class->id)}}" class="btn btn-success btn-sm"> View/Add course <span style="color:blue">{{$class->name}}</span> subject </a>
                          
                  </td>
                 

                  <td class="align_ellipse first_row">

                    <li class="nav-item dropdown">

                      <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <span class="material-icons">

                          more_horiz

                        </span>

                        <div class="ripple-container"></div>

                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">


                        <a class="dropdown-item" href="{{url('/class/edit/' . $class->id)}}"><i class="fa fa-cogs"></i>Edit</a>

                        <a href="javascript:void(0);" data-id="<?php echo $class->id; ?>" class="dropdown-item delete"><i class="fa fa-trash"></i>Delete</a>

                      </div>

                    </li>

                  </td>
                  @endif

                </tr>

                @endforeach

              </tbody>

            </table> 

            @elseif(auth()->user()->role_id == '4')

              <div class="box">
              <div class="container">
                <div class="row">
                  @foreach($classes as $class)
                    <?php
                      $stds = DB::table('classes_students')->where('class_id', $class->id)->count();
                      $class_courses = DB::table('courses')->where('clas_id', $class->id)->pluck('id');
                      $noOfInstructors = DB::table('course_instructor')->wherein('course_id', $class_courses)->count();
                      $noOfCourses = DB::table('courses')->where('clas_id', $class->id)->count();
                      $icon = DB::table('icons')->where('id', $class->icon_id)->get()->first();
                    ?>
                   <!--  <a href="{{url('/showcourseofclass/'.$class->id)}}">
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                           
                        <div class="box-part text-center">
                                    
                          <img src="{{asset('/assets/img/upload/'.$icon->image)}}" width="80" height="80" style="vertical-align: super; border-style: hidden; border-radius: 41px;">
                                    
                        <div class="title">
                          <h4><b>{{$class->name}}</b></h4>
                        </div>
                                    
                        <div class="text">
                          <h4>No.of Students: {{$stds}}</h4>
                          <h4>No.of Instructors: {{$noOfInstructors}}</h4>
                          <h4>No.of Courses: {{$noOfCourses}}</h4>
                        </div>
                                    
                        <a class="btn btn-primary btn-sm" href="{{url('/showcourseofclass/'.$class->id)}}">Show Courses</a>
                        <a class="btn btn-primary btn-sm" href="{{url('/showstudentsofclass/'.$class->id)}}">Show Students</a>            
                       </div>
                      </div>   
                    </a> -->

                    <div class="col-md-4">
                      <a href="{{url('/showcourseofclass/'.$class->id)}}">
                        <div class="member aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">
                            <div class="pic">
                                <img src="{{asset('/assets/img/upload/'.$icon->image)}}">
                            </div>
                            <div class="member-info">
                                <h4>{{$class->name}}</h4>
                                <span> <p class="make_round_no">{{$stds}} </p>: Students</span>
                                <span> <p class="make_round_no">{{$noOfInstructors}}</p> : Instructors </span>
                                <span> <p class="make_round_no">{{$noOfCourses}}</p> : Courses </span>
                                <div class="img_buttons">
                                    <a class="btn btn-primary" href="{{url('/showcourseofclass/'.$class->id)}}">Show Courses</a>
                                    <!-- <a class="btn btn-primary" href="{{url('/showstudentsofclass/'.$class->id)}}">Show Students</a> --> 
                                </div>
                            </div>
                        </div>
                      </a>
                    </div>


                  @endforeach
              </div>    
              </div>
            </div>

            @endif




           @else

            <p>There is no Subject</p>

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

<script type="text/javascript">

  $( "body" ).on( "click", ".delete", function () {

    var task_id = $( this ).attr( "data-id" );

    var form_data = {

        id: task_id

    };

    swal({

        title: "Do you want to delete this Class",

        //text: "@lang('category.delete_category_msg')",

        type: 'info',

        showCancelButton: true,

        confirmButtonColor: '#F79426',

        cancelButtonColor: '#d33',

        confirmButtonText: 'Yes',

        showLoaderOnConfirm: true

    }).then( ( result ) => {

        if ( result.value == true ) {

            $.ajax( {

                type: 'POST',

                headers: {

                    'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )

                },

                url: '<?php echo url("/class/delete"); ?>',

                data: form_data,

                success: function ( msg ) {

                    swal( "@lang('Class Deleted Successfully')", '', 'success' )

                    setTimeout( function () {

                        location.reload();

                    }, 900 );

                }

            } );

        }

    } );

  } );

</script>







@endsection

