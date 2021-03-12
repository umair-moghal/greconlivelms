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

    <li class = "active">All Terms/sections</li>

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

      

    	<div class="course_table mt-0">

        	<div class="course card-header card-header-warning card-header-icon">

          

	        	<h3>All Terms/sections</h3>

	        	@if(count($classes)>0)

	            <div class="table_filters">

	            </div>



	            <table class="table table-hover" style="overflow: hidden;">

	              	<thead>

		                <tr>

		                  <th scope="col">Sr.</th>

		                  <th scope="col">Term/Session</th>

		                  <th scope="col">No.of courses</th>

		                  <th scope="col">Action</th>

		                </tr>

	              	</thead>

	              	<tbody id="mybody">

	                	<?php $count = 1;  ?>

	                	@foreach($classes as $class)
	                    <?php
	                      // dd($class);

	                      $cls = DB::table('classes')->where('id', $class)->get()->first();
	                      // dd($cls);
	                      $courses = DB::table('courses')->where('clas_id', $class)->count();
	                    ?>
	                    <tr>


	                     	<th scope="row">#{{$count}}</th>
	                         <?php $count++; ?>

	                      	<td class="first_row">

		                        <div class="course_td">

		                          <p>{{$cls->name}}</p>

		                        </div>

	                      	</td>
	                      	<td class="first_row">{{$courses}}</td>

	                      	<td class="first_row">
                      
			                    <a href="{{url('/studentcourses/'. $cls->id)}}" class="btn btn-success btn-sm"> Show courses </a>
			                          
			                </td>

	                      	<!-- <td class="align_ellipse first_row">

		                        <li class="nav-item dropdown">

		                          <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

		                            <span class="material-icons">

		                              more_horiz

		                            </span>

		                            <div class="ripple-container"></div>

		                          </a>

		                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

		                            <a class="dropdown-item" href="{{url('/studentcourses/'. $cls->id)}}"> <i class="fa fa-eye"></i>Show Courses</a>

		                          </div>

		                        </li>

	                      	</td> -->

	                   	</tr>
	          
	                	@endforeach

	              	</tbody>

	            </table> 


           		@else

            		<p>There is no Term/Session</p>

          		@endif
          	</div>

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

