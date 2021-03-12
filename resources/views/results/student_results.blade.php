@extends('layouts.app')

@section('content')



<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li class = "active">Overall Results</li>

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

        

        <h3>My Results</h3> 
       

        @if(count($quizzes)>0)

          <div class="table_filters">

            <div class="table_search">

              <input type="text" name="search" id="search" value="" placeholder="Search...">

              <a href="#"> <i class="fa fa-search"></i> </a>
              
            </div>

            <div class="table_select">

              <select class="selectpicker">

                <option>My quizzes</option>

                <option>Today </option>

                <option>Macro Economics I</option>

                <option>Macro Economics II</option>

              </select>

            </div>

          </div>

          <table class="table table-hover" id="table-id">

            <thead>

              <tr>

                <th scope="col">Sr.</th>

                <!-- <th scope="col">Name</th> -->

                <th scope="col">Course</th>

                <th scope="col">Quiz</th>

                <th scope="col">MCQ</th>

                <th scope="col">T/F</th>

                <th scope="col">Essays</th>

                <th scope="col">Total Marks</th>

                <th scope="col">Total Grade</th>


              </tr>

            </thead>

            <tbody id="mybody">
              <?php 
                $count = 1;  
                $OverAll_marks = 0;
              ?>
              @foreach($quizzes as $index =>$quiz)

              <?php
                $qz = DB::table('quizzes')->where('id', $quiz->quiz_id)->get()->first();




                $quiz_questions = DB::table('solved_quizzes')->where('solved_quizzes.quiz_id', $quiz->quiz_id)->where('student_id', Auth::user()->id)->join('questions', 'questions.id', 'solved_quizzes.question_id')->get()->unique();
                

                $no_of_qa = 0;
                $no_of_mcq = 0;
                $no_of_tf = 0;
                foreach ($quiz_questions as $q) 
                {

                    if($q->type == 'question/answer')
                    {
                        $no_of_qa = $no_of_qa + 1;
                    }

                    elseif($q->type == 'mcq')
                    {
                        $no_of_mcq = $no_of_mcq + 1;
                    }

                    else
                    {
                        $no_of_tf = $no_of_tf + 1;
                    }
                }

                $original_mcq_marks = $qz->mr_per_mcq; 
                $original_tf_marks = $qz->mr_per_tf; 
                $original_qa_marks = $qz->mr_per_qa; 

                $original_qa_marks = $no_of_qa * $original_qa_marks;
                $original_mcq_marks = $no_of_mcq * $original_mcq_marks;
                $original_tf_marks = $no_of_tf * $original_tf_marks;

                $original_marks = $original_qa_marks + $original_mcq_marks + $original_tf_marks;



                $course = DB::table('courses')->where('id', $id)->get()->first();
                $OverAll_marks = $OverAll_marks + $quiz->total_marks;


                $AA = DB::table('grades')->where('grade', 'A+')->first(); 
                $A = DB::table('grades')->where('grade', 'A')->first(); 
                $BB = DB::table('grades')->where('grade', 'B+')->first(); 
                $B = DB::table('grades')->where('grade', 'B')->first(); 
                $CC = DB::table('grades')->where('grade', 'C+')->first(); 
                $C = DB::table('grades')->where('grade', 'C')->first(); 
                $DD = DB::table('grades')->where('grade', 'D+')->first(); 
                $D = DB::table('grades')->where('grade', 'D')->first(); 
                $F = DB::table('grades')->where('grade', 'F')->first();

                if($quiz->percentage >= $AA->marks_from && $quiz->percentage <= $AA->marks_to)
                {
                  $grade = $AA->grade;
                }
                elseif($quiz->percentage >= $A->marks_from && $quiz->percentage <= $A->marks_to)
                {
                  $grade = $A->grade;
                }
                elseif($quiz->percentage >= $BB->marks_from && $quiz->percentage <= $BB->marks_to)
                {
                  $grade = $BB->grade;
                }
                elseif($quiz->percentage >= $B->marks_from && $quiz->percentage <= $B->marks_to)
                {
                  $grade = $B->grade;
                }
                elseif($quiz->percentage >= $CC->marks_from && $quiz->percentage <= $CC->marks_to)
                {
                  $grade = $CC->grade;
                }
                elseif($quiz->percentage >= $C->marks_from && $quiz->percentage <= $C->marks_to)
                {
                  $grade = $C->grade;
                }
                elseif($quiz->percentage >= $DD->marks_from && $quiz->percentage <= $DD->marks_to)
                {
                  $grade = $DD->grade;
                }
                elseif($quiz->percentage >= $D->marks_from && $quiz->percentage <= $D->marks_to)
                {
                  $grade = $D->grade;
                }
                elseif($quiz->percentage >= $F->marks_from && $quiz->percentage <= $F->marks_to)
                {
                  $grade = $F->grade;
                }
                       
              ?>

              <tr>

                <th scope="row">#{{$count}}   </th>
                     <?php $count++; ?>


                <td class="first_row">

                  <div class="course_td">

                    <p>{{$course->course_name}}</p>

                  </div>

                </td>

                <td class="first_row">

                  <div class="course_td">

                    <p>{{$qz->name}}</p>

                  </div>

                </td>

                <td class="first_row">

                  <div class="course_td">

                    <p>{{$quiz->mcq_marks}}/{{$original_mcq_marks}}</p>

                  </div>

                </td> 

                <td class="first_row">

                  <div class="course_td">

                    <p>{{$quiz->tf_marks}}/{{$original_tf_marks}}</p>

                  </div>

                </td> 

                <td class="first_row">

                  <div class="course_td">

                    <p>{{$quiz->questions_marks}}/{{$original_qa_marks}}</p>

                  </div>

                </td> 

                <td class="first_row">

                  <div class="course_td">

                    <p>{{$quiz->total_marks}}/{{$original_marks}}</p>

                  </div>

                </td>

                <td class="first_row">

                  <div class="course_td">

                    <p>{{$grade}}</p>

                  </div>

                </td>
              


              </tr>

              @endforeach

            </tbody>

          </table>  

          <p>OverAll Marks: {{$OverAll_marks}}</p>

          <p>OverAll Grade: something</p>

          <a  href="{{url('/studentcourses/'.$clsid)}}"><button type="button" class="btn" style="background-color: #e7e7e7; color: black">Back</button></a>
          @if(count($quizzes)>5)
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

          <p>oops! You have not submit any quiz yet.</p>

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

  <script type="text/javascript">

    setTimeout(function() {

      $('#message').fadeOut('fast');

  }, 2000);

  </script>



@endsection