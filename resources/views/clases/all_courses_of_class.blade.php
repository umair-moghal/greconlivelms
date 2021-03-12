@extends('layouts.app')

@section('content')


<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li>Terms/Sessions</li>

    <li class = "active">All Courses</li>

  </ol>

</div>




  <div class="content_main">

    <div class="all_courses_main">

      

      <div class="course_table mt-0">

        <div class="course card-header card-header-warning card-header-icon">

          

          <h3>All Courses</h3>

          @if(count($courses)>0)

            <div class="table_filters">

              <div class="table_search">

                <input type="text" name="search" id="search" value="" placeholder="Search...">

                <a href="#"> <i class="fa fa-search"></i> </a>

              </div>

              <div class="table_select">

                <select class="selectpicker">

                  <option>All Courses</option>

                  <option>Today </option>

                  <option>Macro Economics I</option>

                  <option>Macro Economics II</option>

                </select>

              </div>

            </div>

            <table class="table table-hover">

              <thead>

                <tr>

                  <th scope="col">ID</th>

                  <th scope="col">Course Name</th>

                  <th scope="col">Action</th>

                </tr>

              </thead>

              <tbody id="mybody">

                @foreach($courses as $index =>$course)

                <tr>


                  <th scope="row">#{{$index+1}}</th>

                  <td class="first_row">

                    <div class="course_td">

                      <p>{{$course->course_name}}</p>

                    </div>

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

                        <a class="dropdown-item" href="{{url('/classes')}}"><i class="fa fa-cogs"></i>Back</a>

                        <a href="javascript:void(0);" other-id = "<?php echo $id; ?>" data-id="<?php echo $course->id; ?>" class="dropdown-item delete"><i class="fa fa-trash"></i>Remove</a>

                      </div>

                    </li>

                  </td>

                </tr>

                @endforeach

              </tbody>

            </table>   

           @else

            <p>There is no Course</p>

          @endif

        </div>

      </div>

    </div>

  </div>

<script type="text/javascript">

        $( "body" ).on( "click", ".delete", function () {

            var task_id = $( this ).attr( "data-id" );
            var clasid = $( this ).attr( "other-id" );


            var form_data = {

                id: task_id,
                clas_id: clasid

            };

            swal({

                title: "Do you want to Remove this Course",

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

                        type: 'post',

                        headers: {

                            'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )

                        },

                        url: '<?php echo url("/class/destroycourse/"); ?>',

                        data: form_data,

                        success: function ( msg ) {

                            swal( "@lang('Course Removed Successfully')", '', 'success' )

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

