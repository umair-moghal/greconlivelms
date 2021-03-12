@extends('layouts.app')

@section('content')


<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li>Terms/Sessions</li>

    <li class = "active">All Students</li>

  </ol>

</div>




  <div class="content_main">

    <div class="all_courses_main">

      

      <div class="course_table mt-0">

        <div class="course card-header card-header-warning card-header-icon">

          

          <h3>All Students</h3>

          @if(count($stds)>0)

            <div class="table_filters">

              <div class="table_search">

                <input type="text" name="search" id="search" value="" placeholder="Search...">

                <a href="#"> <i class="fa fa-search"></i> </a>

              </div>

              <div class="table_select">

                <select class="selectpicker">

                  <option>All Students</option>

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

                  <th scope="col">Name</th>

                  <th scope="col">Image</th>

                  <th scope="col">Action</th>

                </tr>

              </thead>

              <tbody id="mybody">

                @foreach($stds as $index =>$std)

                <?php
                  $stdd = DB::table('students')->where('s_u_id', $std->s_u_id)->get()->first();
                  $student = DB::table('users')->where('id', $std->s_u_id)->get()->first();
                ?>

                <tr>


                  <th scope="row">#{{$index+1}}</th>

                  <td class="first_row">

                    <div class="course_td">

                      <p>{{$student->name}}</p>

                    </div>

                  </td>

                  <td class="first_row">
                    
                    <div class="course_td">

                      <img src="{{asset('assets/img/upload/'.$student->image)}}" width="50" alt="" class="img-fluid">

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
                        <a href="javascript:void(0);" data-id="<?php echo $student->id; ?>" class="dropdown-item delete"><i class="fa fa-trash"></i>Remove</a>

                      </div>

                    </li>

                  </td>

                </tr>

                @endforeach

              </tbody>

            </table>   

           @else

            <p>There is no Student</p>

          @endif

        </div>

      </div>

    </div>

  </div>

<script type="text/javascript">

        $( "body" ).on( "click", ".delete", function () {

            var task_id = $( this ).attr( "data-id" );

            var form_data = {

                id: task_id

            };

            swal({

                title: "Do you want to Remove this Student",

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

                        url: '<?php echo url("/class/destroystudent"); ?>',

                        data: form_data,

                        success: function ( msg ) {

                            swal( "@lang('Student Removed Successfully')", '', 'success' )

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

