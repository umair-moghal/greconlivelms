@extends('layouts.app')

@section('content')

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li>Terms/Sessions</li>

    <li class = "active">All Courses</li>

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

        

        <h3>All Courses</h3>

        @if(count($courses)>0)

          <div class="table_filters">

            <div class="table_search">

              <input type="text" name="search" id="search" value="" placeholder="Search...">

              <a href="#"> <i class="fa fa-search"></i> </a>

            </div>

          </div>

          <table class="table table-hover" id="table-id">

            <thead>

              <tr>

                <th scope="col">Unique Identifier</th>

                <th scope="col">Name</th>

                <th scope="col">Action</th>

              </tr>

            </thead>

            <tbody id="mybody">

              @foreach($courses as $index =>$course)

                @php

                if($course->sessions == 1){
                   $session = 'One Session';
                }
                elseif($course->sessions == 2){
                   $session = 'Two Sessions - One Semester';
                }
                 elseif($course->sessions == 3){
                   $session = 'Three Sessions';
                }elseif($course->sessions == 4){
                   $session = 'Four Sessions - Two Semesters';
                }

                $ins_name = DB::table('users')->where('id',$course->ins_id)->pluck('name')->first();
                @endphp
              <tr>

             
                <td class="first_row">{{$course->unique_identifier}}</td>

                <td class="first_row">

                  <div class="course_td">

                      <img src="{{asset('/assets/img/upload/'.$course->image)}}" width="90" alt="" class="img-fluid">

                    <p>{{$course->course_name}}  {{date('d-m-Y', strtotime($course->start_date))}} - {{date('d-m-Y', strtotime($course->end_date))}}</p>
                   
                     

                  </div>
                  <br>
                  <p>
                       {{$session}} Term
                     </p>
                     @if(auth()->user()->role_id == 5 || auth()->user()->role_id == 3 )
                     <p>
                        <strong>Instructor: {{$ins_name}}</strong>
                     </p>
                     @endif

                </td>


                <td class="align_ellipse first_row" width="10%">

                  @if(Auth::user()->role_id == 3)
                    <a class="btn btn-sm btn-warning" href="{{url('/course/addstudent/' .$course->id .'/'. $course->clas_id)}}" >Add Students</a>
                  @endif
                  <a class="btn btn-sm btn-success" href="{{url('/course/showdetails/' .$course->id .'/'. $course->clas_id)}}" >Course View</a>
                  @if(Auth::user()->role_id == 4)
                    <a class="btn btn-sm btn-warning" href="{{url('/course/students/'.$course->id)}}">Students</a>
                  @endif
                  <a class="btn btn-sm btn-primary" href="{{url('/course/edit/'.$course->id)}}">Edit</a>
                  <a href="javascript:void(0);" data-id="<?php echo $course->id; ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> Delete</a>
                  @if(Auth::user()->role_id == 4)
                    <a class="btn btn-sm btn-primary" href="{{url('/show_student_attendance/'.$course->id)}}">Show attendance</a>

                    <a class="btn btn-sm btn-info" href="{{url('/upload_syllabus/'.$course->id)}}">Syllabus</a>
                  @endif

                </td>

              </tr>
              
              @endforeach

            </tbody>

          </table>
            @if(count($courses)>5)
            <div class="table_footer">
              <div class="table_pegination">
                <nav>
                  <ul class="pager pagination">
                    <li data-page="prev" class="pager__item pager__item--prev"><span class="pager__link fa fa-angle-left">
                    <span class="sr-only">(current)</span></span></li>
                    <li data-page="next" id="prev" class="pager__item pager__item--prev"><span class="pager__link fa fa-angle-right">
                    <span class="sr-only">(current)</span></span></li>
                  </ul>
                </nav>
              </div>
              <div class="table_rows">
                <div class="rows_main">
                  <p>Rows per page</p>
                  <select name="state" id="maxRows">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                  </select>
                </div>
              </div>
            </div>
            @endif

         @else

          <p>There is no Course</p>

        @endif

      </div>

    </div>

  </div>

</div>





<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

<div class="modal-dialog modal-dialog-centered" role="document">

  <div class="modal-content">

    <div class="cross_modal">

      <div class="modal_title">

        <h3>Select items to duplicate</h3>

      </div>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">

        <span aria-hidden="true" class="cross_btn">&times;</span>

      </button>

    </div>

    <div class="modal-body">

      <form method="POST" class="w-100" action="{{url('/course/replicate')}}">

        @csrf

        <input type="hidden" name="course_id" value=" " id="datasid">

        <div class="row">
          <div class="col-md-4">
            <button type="button" class="btn w-100 parent_input parent_input1" >
              Quizzes <input type="checkbox" value="quiz" name="selected[]" class="btn"/> <i class="fa fa-check-square-o"></i>
            </button>
          </div>
          <div class="col-md-4">
            <button type="button" class="btn w-100 parent_input parent_input2" >
              Links <input type="checkbox" value="links" name="selected[]" class="btn"/> <i class="fa fa-check-square-o"></i>
            </button>
          </div>
          <div class="col-md-4">
            <button type="button" class="btn w-100 parent_input parent_input3" >
              Downloadables <input type="checkbox" value="downloadables" name="selected[]" class="btn"/> <i class="fa fa-check-square-o" ></i>
            </button>
          </div>
        </div>

        <div class="s_form_button">

          <a href="/course"><button type="button" class="btn cncl_btn">Cancel</button></a>

          <button type="submit" class="btn save_btn">Save</button>

        </div>

      </form>

    </div>

  </div>

</div>

</div>

<script type="text/javascript">

    function dupid(dataid)
    {
      document.getElementById("datasid").value = dataid;
    }


</script>



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

                title: "Do you want to delete this Course",

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

                        url: '<?php echo url("course/delete"); ?>',

                        data: form_data,

                        success: function ( msg ) {

                            swal( "@lang('Course Deleted Successfully')", '', 'success' )

                            setTimeout( function () {

                                location.reload();

                            }, 900 );

                        }

                    } );

                }

            } );

        } );

</script>

<script>
  $('.parent_input , .parent_input2 , .parent_input3').click(function(event) {
    /* Act on the event */
    $(this).toggleClass('btn-success');
  });
  $('.parent_input1').click(function(event) {
    /* Act on the event */
     $('.parent_input1 i').toggle();
  });
  $('.parent_input2').click(function(event) {
    /* Act on the event */
     $('.parent_input2 i').toggle();
  });

  $('.parent_input3').click(function(event) {
    /* Act on the event */
     $('.parent_input3 i').toggle();
  });

</script>

<script>
    getPagination('#table-id');
  
    function getPagination(table) {
      var lastPage = 1;

      $('#maxRows')
        .on('change', function(evt) {
          //$('.paginationprev').html('');            // reset pagination

        lastPage = 1;
          $('.pagination')
            .find('li')
            .slice(1, -1)
            .remove();
          var trnum = 0; // reset tr counter
          var maxRows = parseInt($(this).val()); // get Max Rows from select option

          if (maxRows == 5000) {
            $('.pagination').hide();
          } else {
            $('.pagination').show();
          }

          var totalRows = $(table + ' tbody tr').length; // numbers of rows
          $(table + ' tr:gt(0)').each(function() {
            // each TR in  table and not the header
            trnum++; // Start Counter
            if (trnum > maxRows) {
              // if tr number gt maxRows

              $(this).hide(); // fade it out
            }
            if (trnum <= maxRows) {
              $(this).show();
            } // else fade in Important in case if it ..
          }); //  was fade out to fade it in
          if (totalRows > maxRows) {
            // if tr total rows gt max rows option
            var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
            //  numbers of pages
            for (var i = 1; i <= pagenum; ) {
              // for each page append pagination li
              $('.pagination #prev')
                .before(
                  '<li data-page="' +
                    i +
                    '" class="pager__item">\
                      <span class="pager__link">' +
                    i++ +
                    '<span class="sr-only">(current)</span></span>\
                    </li>'
                )
                .show();
            } // end for i
          } // end if row count > max rows
          $('.pagination [data-page="1"]').addClass('active'); // add active class to the first li
          $('.pagination li').on('click', function(evt) {
            // on click each page
            evt.stopImmediatePropagation();
            evt.preventDefault();
            var pageNum = $(this).attr('data-page'); // get it's number

            var maxRows = parseInt($('#maxRows').val()); // get Max Rows from select option

            if (pageNum == 'prev') {
              if (lastPage == 1) {
                return;
              }
              pageNum = --lastPage;
            }
            if (pageNum == 'next') {
              if (lastPage == $('.pagination li').length - 2) {
                return;
              }
              pageNum = ++lastPage;
            }

            lastPage = pageNum;
            var trIndex = 0; // reset tr counter
            $('.pagination li').removeClass('active'); // remove active class from all li
            $('.pagination [data-page="' + lastPage + '"]').addClass('active'); // add active class to the clicked
            // $(this).addClass('active');          // add active class to the clicked
          limitPagging();
            $(table + ' tr:gt(0)').each(function() {
              // each tr in table not the header
              trIndex++; // tr index counter
              // if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
              if (
                trIndex > maxRows * pageNum ||
                trIndex <= maxRows * pageNum - maxRows
              ) {
                $(this).hide();
              } else {
                $(this).show();
              } //else fade in
            }); // end of for each tr in table
          }); // end of on click pagination list
        limitPagging();
        })
        .val(5)
        .change();

      // end of on select change

      // END OF PAGINATION
    }

    function limitPagging(){
      // alert($('.pagination li').length)

      if($('.pagination li').length > 7 ){
          if( $('.pagination li.active').attr('data-page') <= 3 ){
          $('.pagination li:gt(5)').hide();
          $('.pagination li:lt(5)').show();
          $('.pagination [data-page="next"]').show();
        }if ($('.pagination li.active').attr('data-page') > 3){
          $('.pagination li:gt(0)').hide();
          $('.pagination [data-page="next"]').show();
          for( let i = ( parseInt($('.pagination li.active').attr('data-page'))  -2 )  ; i <= ( parseInt($('.pagination li.active').attr('data-page'))  + 2 ) ; i++ ){
            $('.pagination [data-page="'+i+'"]').show();

          }

        }
      }
      if($('.pagination li').length == 2){
        document.getElementsByClassName('pagination').hide();
      }
    }
    
  </script>

@endsection