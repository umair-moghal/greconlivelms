@extends('layouts.app')

@section('content')

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li>Notifications</li>

   

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

        

        <h3>All Notifications</h3>

       

           <div class="table_filters">

              <div class="table_search w-100">
              <form method="post" action="/notifications_search_bar">
                @csrf
                <div class="row">
                  <div class="col-md-3">

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

                        <select class="selectpicker" name="course" id="slct">
                          <option>Select Course</option>
                          @foreach($courses_list as $list)
                          <option value="{{$list->id}}" @if(isset($course) && $course == $list->id) selected @endif>{{$list->course_name}}</option>
                          @endforeach

                        </select>

                        <label class="select_lable">Courses</label>

                      </div>
                  </div>


                  <div class="col-md-3">

                  <div class="custom_input_main select_plugin mobile_field">

                        <select class="selectpicker" name="type" id="slct">
                          <option @if(isset($type)) value="{{$type}}" @endif>@if(isset($type)) {{$type}} @else Select Type @endif</option>
                          <option value="US Holiday">US Holiday</option>
                           <option value="Instructor">Instructor</option>
                           <option value="Events">Events</option>
                           <option value="Resource">Resource</option>
                           <option value="Message">Message</option>
                        </select>

                        <label class="select_lable">Type</label>

                      </div>
                  </div>

                  <div class="col-md-2">
                    <div class="custom_input_main mobile_field" style="margin-top: 6px;">

                      <input type="date" @if(isset($from_date)) value="{{$from_date}}" @endif class="form-control" name="from_date">

                      <label>From Date

                        <span class="grey">*</span></label>

                      </div>
                  </div>
                  <div class="col-md-2">
                    <div class="custom_input_main mobile_field" style="margin-top: 6px;">

                      <input type="date" @if(isset($to_date)) value="{{$to_date}}" @endif class="form-control" name="to_date">

                      <label>To Date

                        <span class="grey">*</span></label>

                      </div>
                  </div>
                  <div class="col-md-2 pl-lg-0">
                    <div class="checkbox_btn">
                      <!-- <div class="checkboxes_">
                        <div class="custom_checkbox">
                            <input type="checkbox" id="1" class="vh" value="Animal dander" name="alergy[]">
                            <label for="1">Highest Grades</label>
                          </div>
                          <div class="custom_checkbox">
                            <input type="checkbox" id="2" class="vh" value="Animal dander" name="alergy[]">
                            <label for="2">Lowest Grades</label>
                          </div>
                      </div> -->
                      <div class="search_btn_btn">
                        <button type="submit" class="btn btn-primary rounded"><i class="fa fa-search"></i></button>

                         <a href="/notifications"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Clear</button></a>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- <input type="text" name="search" id="search" value="" placeholder="Search...">

                <a href="#"> <i class="fa fa-search"></i> </a> -->
              </form>
                

              </div>
              



            </div>

          <table class="table table-hover" id="table-id">

            <thead>

              <tr>

                <th scope="col">Notification</th>

                <th scope="col"> Description</th>

                <th>Created By</th>

                <th scope="col">Course Name</th>

                <th scope="col">Notification Type</th>

                <th scope="col">Link</th>

                <th scope="col">Time</th>

                <th scope="col">Action</th>

              </tr>

            </thead>

            <tbody id="mybody">
              
              @foreach($notifications as $noti)

              @php
                $creator_name = DB::table('users')->where('id',$noti->created_by)->pluck('name')->first();

                $course_name = DB::table('courses')->where('id',$noti->course_id)->pluck('course_name')->first();
              @endphp
              <tr>
                <td>{{$noti->title}}</td>
                <td>{{$noti->description}}</td>
                 <td>{{$creator_name}}</td>
                <td>@if($noti->course_id) {{$course_name}} @else N/A @endif</td>
                <td>{{$noti->activity_name}}</td>
                <td>@if($noti->link) {{$noti->link}} @else N/A @endif</td>
                <td>{{$noti->activity_time}}</td>
                 <td>
                  @if($noti->link)
                  <a href="{{$noti->link}}"><button class="btn btn-primary btn-sm">View</button></a>
                  @endif

                </td>
             
             

              </tr>
              @endforeach
              
           

            </tbody>

          </table>
           
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