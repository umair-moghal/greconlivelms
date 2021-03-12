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

    <li class = "active">Course Grades</li>

  </ol>

</div>


  <div class="content_main">

    <div class="all_courses_main">

      

      <div class="course_table mt-0">

        <div class="course card-header card-header-warning card-header-icon">

          

          <h3>All Grades</h3> <a class="btn btn-info" style="float: right;" href="{{url('/setgrades/'.$id)}}">Add New</a>
          
          

          @if(count($grades)>0)

            <div class="table_filters">

             

             

            </div>

            <table class="table table-hover" id="table-id">

              <thead>

                <tr>

                  <th scope="col">Sr.no</th>

                  <th scope="col">Range</th>

                  <th scope="col">Grade</th>

                  <th scope="col">Action</th>

                </tr>

              </thead>

              <tbody id="mybody">

                @foreach($grades as $index =>$g)
                

                <tr>

                  <th scope="row">#{{$index+1}}</th>

                  <td class="first_row">

                    <div class="course_td">

                      <p>{{$g->marks_from}} - {{$g->marks_to}}</p>

                    </div>

                  </td>

                  <td class="first_row">
                    {{$g->grade}}
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

                        <a class="dropdown-item" href="{{url('/editgrades/' . $g->id)}}"><i class="fa fa-cogs"></i>Edit</a>

                        <a href="javascript:void(0);" data-id="<?php echo $g->id; ?>" class="dropdown-item delete"><i class="fa fa-trash"></i>Delete</a>

                      </div>

                    </li>

                  </td>

                </tr>

                @endforeach

              </tbody>

            </table>   

           @else

            <p>There is no Grade yet created</p>

          @endif

        </div>

      </div>

    </div>

  </div>

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
  <script type="text/javascript">
    setTimeout(function() {
      $('#message').fadeOut('fast');
  }, 2000);
  </script>

 <script type="text/javascript">

    $("body").on( "click", ".delete", function () {

    var task_id = $( this ).attr( "data-id" );

    console.log(task_id);

    var form_data = {

    id: task_id

    };

    swal({

    title: "Do you want to delete this grade?",

    type: 'info',

    showCancelButton: true,

    confirmButtonColor: '#F79426',

    cancelButtonColor: '#d33',

    confirmButtonText: 'Yes',

    showLoaderOnConfirm: true

    }).then( ( result ) => {

    if ( result.value == true ) {

    $.ajax( {

    type: 'get',

    url: '<?php echo url("/grade/delete"); ?>',

    data: form_data,

    success: function ( msg ) {

    swal( "@lang('Grade Deleted')", '', 'success' )

    setTimeout( function () {

    location.reload();

    }, 1000 );

    }

    } );

    }

    } );

    } );

  </script>
@endsection