@extends('layouts.app')
<link href="{{asset('/assets/css/calendar.css')}}" rel="stylesheet" />
@section('content')
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


                <li class = "active">Attendance View</li>
              </ol>
            </div>
            <div class="content_main">
              <div class="school_clndr_main">
                
                <div class="calender card-header card-header-warning card-header-icon">
                  
                    <h3>Calendar View</h3>
                  


                      <div class="col-md-12">

                        <div class="top_clndr">

                          <div class="">

                            <div class="card-body p-0">

                              <div id="calendar"></div>

                            </div>

                          </div>

                        </div>

                      </div>


                  <br><br><br><br>
                  <h3>List View</h3> 
                  <a href="{{url('/export_student_attendance')}}"><button type="button" class="btn">Download Excel File</button></a>
                    @if(count($attendance)>0)
                      <div class="table_filters">
                        <div class="table_search">
                          <input type="text" name="search" id="search" value="" placeholder="Search...">
                          <a href="#"> <i class="fa fa-search"></i> </a>
                        </div>
                      </div>
                      <table class="table table-hover" id="table-id">
                        <thead>
                          <tr>
                            <th scope="col">Sr.no</th>
                            <th scope="col">Course</th>
                            <th scope="col">Lecture</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                          </tr>
                        </thead>
                        <tbody id="mybody">
                          @foreach($attendance as $index =>$atn)
                          <?php
                            $course = DB::table('courses')->where('id', $atn->course_id)->get()->first();
                            $lecture = DB::table('lectures')->where('id', $atn->lecture_id)->get()->first();
                          ?>
                          <tr>
                            <th scope="row">#{{$index+1}}</th>
                            <td class="first_row">
                              <div class="course_td">
                                <p>{{$course->course_name}}</p>
                              </div>
                            </td>
                            <td class="first_row">
                              {{$lecture->topic}}
                            </td>
                            <td class="first_row">
                              {{$atn->date}}
                            </td>
                            <td class="first_row">
                              {{$atn->time}}
                            </td>
                            <td class="first_row">
                              {{$atn->status}}
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      @if(count($attendance)>5)
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
                       @endif
                  

                    </div>

                    

                  </div>
                </div>
              </div>
            </div>






<script type="text/javascript">

  setTimeout(function() {

    $('#message').fadeOut('fast');

}, 2000);

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

<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

</script>
@endsection