@extends('layouts.app')

@section('content')

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li><a href = "#">Quizzes/Tests</a></li>

    <li class = "active">Add Quizzes/Tests</li>

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

  <div class="card-header assesment_main">

    <h3>Add Quizzes/Tests</h3>

    <div class="main_quiz">

      <div class="quiz_tabs">

        <ul class="nav nav-tabs ">
          <li class="quiz_tab_link">
            <a href="{{url('/mcq/create/'. $instructor_id .'/'. $course->id .'/'. $week .'/'. $qid)}}">
            Multiple Choice </a>
          </li>
          <li class="quiz_tab_link no_radius  active">
            <a href="{{url('/q/create/'. $instructor_id .'/'. $course->id .'/'. $week .'/'. $qid)}}">
            Essays</a>
          </li>
          <li class="quiz_tab_link second">
            <a href="{{url('/tf/create/'. $instructor_id .'/'. $course->id .'/'. $week .'/'. $qid)}}">
            True/False </a>
          </li>
          
        </ul>

        <div class="tab-content">

          	<div class="tab-pane active" id="tab_default_1">

          		<form method="POST" action="{{url('/q/store')}}">

          			@csrf
                <input type="hidden" name="course_id" value="{{$course->id}}">
                <input type="hidden" name="instructor_id" value="{{$instructor_id}}">
                <input type="hidden" name="week" value="{{$week}}">
                <input type="hidden" name="qid" value="{{$qid}}">

		            <div class="quiz_head">

		              <h5>Essays</h5>

		              <div class="quiz_form">

		                <div class="custom_input_main remove_ex_margin">

		                  <textarea class="form-control" name="label" value="{!!old('label')!!}" autofocus="" required="" style="height: 100px !important;"> </textarea>

		                  <label>Essay <span class="red">*</span></label>

		                </div>

		              </div>

		              <div class="qa_quiz">

		                <div class="row">

		                  <div class="col-md-10 p_left">

		                    <div class="quiz_op">

		                      <h4>Answer</h4>

		                    </div>

		                    <div class="col-md-12">

		                      <div class="custom_input_main mobile_field">

		                      	<textarea class="form-control" name="ans" value="{!!old('ans')!!}" autofocus="" required="" style="height: 100px !important;"> </textarea>

		                        <label>Answer.

		                          <span class="red">*</span>
		                        </label>

		                      </div>

		                    </div>

		                  </div>

		                  <div class="save_next_btn text-center w-100">
                        <a  href="{{url('/course')}}"><button type="button" class="btn" style="background-color: #e7e7e7; color: black">Cancel</button></a>
		                    <button type="submit" class="btn">Save and next</button>
		                </div>

		                </div>

		              </div>

		            </div>

		        </form>

          	</div>          

        </div>

      </div>

    </div>

  </div>

</div>





  <div class="content_main">

    <div class="all_courses_main">

      

      <div class="course_table mt-0">

        <div class="course card-header card-header-warning card-header-icon">

          

          <h3>Question Answers</h3>

          @if(count($questions)>0)

            <div class="table_filters">

              <div class="table_search">

                <input type="text" name="search" id="search" value="" placeholder="Search...">

                <a href="#"> <i class="fa fa-search"></i> </a>

              </div>

              <div class="table_select">

                <select class="selectpicker">

                  <option>All Multiple choice questions</option>

                  <option>Today </option>

                  <option>Macro Economics I</option>

                  <option>Macro Economics II</option>

                </select>

              </div>

            </div>

            <table class="table table-hover" id="table-id">

              <thead>

                <tr>

                  <th scope="col">ID</th>

                  <th scope="col">Label</th>

                  <th scope="col">Answer</th>


                  <th scope="col">Action</th>

                </tr>

              </thead>

              <tbody id="mybody">

                @foreach($questions as $index =>$q)
                

                <tr>

                  <th scope="row">#{{$index+1}}</th>

                  <td class="first_row">

                    <div class="course_td">

                      <p>{{$q->label}}</p>

                    </div>

                  </td>

                  <td class="first_row">
                  	{{$q->options}}
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

                        <a class="dropdown-item" href="{{url('/q/edit/' . $q->id, $course->id)}}"><i class="fa fa-cogs"></i>Edit</a>

                        <a href="javascript:void(0);" data-id="<?php echo $q->id; ?>" class="dropdown-item delete"><i class="fa fa-trash"></i>Delete</a>

                      </div>

                    </li>

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

           @else

            <p>There is no Question yet created</p>

          @endif

        </div>

      </div>

    </div>

  </div>



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


<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>

  CKEDITOR.replace( 'txtEditor' );

</script>

   <script type="text/javascript">

      setTimeout(function() {

        $('#message').fadeOut('fast');

    }, 2000);

    </script> 

@endsection