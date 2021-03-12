@extends('layouts.app')

@section('content')

<!-- <script type="text/javascript">
  
  function timeout()
  {
    var hours =  Math.floor(timeLeft/3600);
    var minute = Math.floor((timeLeft-(hours*60*60)-30)/60);
    var second = timeLeft%60;
    var hrs = checktime(hours);
    var mint = checktime(minute);
    var sec = checktime(second);
    if(timeLeft<=0)
    {
      clearTimeout(tm);
      document.getElementById("form1").submit();
    }
    else
    {
      
      document.getElementById("time").innerHTML=hrs+":"+mint+":"+sec;
    }
    timeLeft--;
    var tm = setTimeout(function(){timeout()}, 1000);
  }
  function checktime(msg)
  {
    if(msg<10)
    {
      msg = "0"+msg;
    }
    return msg;
  }
</script> -->


<style>
  #firstdiv h4 {
    margin-bottom: 0;
    font-weight: 400;
  }
  .paper_bg  {
    position: absolute;
    top: 34%;
    width: 100%;
    bottom: 0;
    right: 0;
    display: flex;
    left: 0;
    z-index: -1;
    transform: rotate(
    -45deg
    );
    align-items: center;
    justify-content: center;
    opacity: .2;
    /*z-index: 9;*/
  }
  .total_time p {
    font-weight: 400;
    margin-bottom: 10px;
  }
  #firstdiv p {
    font-weight: 700;
  }
  .total_time p span , .total_time p span input {
    font-weight: 700;
    /*width: 18%;*/
    border: none;
  }
</style>

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li class = "active">Quiz View</li>

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

    <?php
      $quiz = DB::table('quizzes')->where('id', $id)->get()->first();
      if($quiz->negative_marking == 0)
              {
                $nm = 'Disabled';
              }
      else
      {
        $nm = 'Enabled';
      }

      $original_qa_marks = $quiz->mr_per_qa; 
      $original_mcq_marks = $quiz->mr_per_mcq; 
      $original_tf_marks = $quiz->mr_per_tf; 

      
      $no_of_qa = 0;
      $no_of_mcq = 0;
      $no_of_tf = 0;
      foreach ($questions as $qz) 
      {
          $q = DB::table('questions')->where('id', $qz->question_id)->get()->first();


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


      $original_qa_marks = $no_of_qa * $original_qa_marks;
      $original_mcq_marks = $no_of_mcq * $original_mcq_marks;
      $original_tf_marks = $no_of_tf * $original_tf_marks;

      $original_marks = $original_qa_marks + $original_mcq_marks + $original_tf_marks;

      
    ?>

    <div class="course_table mt-0">

      <div class="course card-header card-header-warning card-header-icon" style="position: relative; z-index: 1;">
        <h3 class="text-center">Challenge({{$quiz->name}}) 
        </h3>

        <div class="row">
          <div class="col-md-6">
            <div class="total_time">
              <p>Total Time : <span>{{$quiz->duration}}min</span></p>
            </div>
          </div>

          <div class="col-md-6 text-right">
            <div class="total_time">
              <p>Grading Scale : <span>{{$quiz->wait}}%</span></p>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="total_time" >
              <p style="margin-right: 54px;">Date : <span>{{$quiz->quiz_date}}</span></p>
            </div>
          </div>
          <div class="col-md-6 text-right">
            <div class="total_time">
              <p>Total Marks : <span>{{$original_marks}}</span></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="total_time">

              <p>Negative Marking : <span>{{$nm}}</span></p>
            </div>
          </div>
        </div>
          <!-- <script type="text/javascript">
              
              var timeLeft = 2*60*60;

          </script>

          <div id="time" style="float: right;">TimeOut</div> </h3> 
 -->



        @if(count($questions)>0) 
         
            <form method="POST" action="{{url('/quiz/solved_quiz_by_student')}}" enctype="multipart/form-data" id="form1">
              @csrf
              <input type="hidden" name="quiz_id" value="{{$id}}">
              <input type="hidden" name="course_id" value="{{$cid}}">

              @foreach($questions as $index => $q)

                <?php 
                  $qstn = DB::table('questions')->where('id', $q->question_id)->get()->first();
                  if($qstn->type == "question/answer")
                    {
                      $opts = $qstn->options;
                    }
                  else
                    {
                      $opts = unserialize($qstn->options);
                    }
                ?>

                <div id="firstdiv">
                  <div class="mt-4">
                    <p>Q# : {{$index+1}}</p>
                    
                    <h4>{{$qstn->label}}</h4>
                  </div>
                  @if($qstn->type == 'mcq')
                  <input type="hidden" name="mcqlabel" value="{{$qstn->label}}">
                  <input type="hidden" name="question_id[]" value="{{$qstn->id}}">
                    <div class="row">
                      <div class="col-md-3">

                        <button type="button" class="btn unique_btn">{{$opts['opt1']}}  <input type="checkbox" value="{{$opts['opt1']}}" name="correct{{$qstn->id}}[]" class="btn"/> </button>

                        <!-- <label>{{$opts['opt1']}}</label>
                        <input type="checkbox" value="{{$opts['opt1']}}" name="correct{{$qstn->id}}[]" class="btn"/> -->
                      </div>
                      <div class="col-md-3">

                        <button type="button" class="btn unique_btn">{{$opts['opt2']}}  <input type="checkbox" value="{{$opts['opt2']}}" name="correct{{$qstn->id}}[]" class="btn"/> </button>

                        <!-- <label>{{$opts['opt2']}}</label>
                        <input type="checkbox" value="{{$opts['opt2']}}" name="correct{{$qstn->id}}[]" class="btn"/> -->
                      </div>
                      <div class="col-md-3">

                        <button type="button" class="btn unique_btn">{{$opts['opt3']}} <input type="checkbox" value="{{$opts['opt3']}}" name="correct{{$qstn->id}}[]" class="btn"/> </button>

                        <!-- <label>{{$opts['opt3']}}</label>
                        <input type="checkbox" value="{{$opts['opt3']}}" name="correct{{$qstn->id}}[]" class="btn"/> -->
                      </div>
                      <div class="col-md-3">

                        <button type="button" class="btn unique_btn">{{$opts['opt4']}}<input type="checkbox" value="{{$opts['opt4']}}" name="correct{{$qstn->id}}[]" class="btn"/> </button>

                       <!--  <label>{{$opts['opt4']}}</label>
                        <input type="checkbox" value="{{$opts['opt4']}}" name="correct{{$qstn->id}}[]" class="btn"/> -->
                      </div>
                    </div>
                  @elseif($qstn->type == 't/f')
                  <input type="hidden" name="tfabel" value="{{$qstn->label}}">
                  <input type="hidden" name="question_id[]" value="{{$qstn->id}}">
                    <div>
                      <div class="row">
                        <div class="col-md-3">
                          <!-- <label></label> -->

                        <button type="button" class="btn t_f_btn" id="correcttf{{$qstn->id}}">{{$opts['true']}} <input type="radio" value="true" name="correcttf{{$qstn->id}}"  class="btn" required="required" /></button>  
                      </div>
                      <div class="col-md-3">
                        
                      
                          <!-- <label>{{$opts['false']}}</label> -->

                        <button type="button" class="btn t_f_btn" id="correcttf{{$qstn->id}}">{{$opts['false']}} <input type="radio" value="false" name="correcttf{{$qstn->id}}"  class="btn" required="required" /></button>  
                                             
                        </div>
                      </div>
                    </div>
                    @elseif($qstn->type == 'question/answer')
                    <input type="hidden" name="qalabel" value="{{$qstn->label}}">
                    <input type="hidden" name="question_id[]" value="{{$qstn->id}}">
                    <div>
                      <div class="row">
                        <div class="col-md-8">

                          <textarea class="form-control" name="ans{{$qstn->id}}" value="{!!old('ans')!!}" autofocus="" required="" style="height: 100px !important;    padding: 6px;
                               border-radius: 4px;"> </textarea>       
                        </div>

                         <div class="col-md-4 d-flex align-items-center">

                      <div class="file_spacing">

                        <input id="file" class="choose" type="file" name="file{{$qstn->id}}" accept=".doc,.docx,.pptx,.txt,application/pdf,application/vnd.ms-excel/application/vnd.ms-docx,image/*" autofocus="" size="max:10240">

                      </div>

                          @error('file')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                    </div>
                      </div>
                    </div>
                  @endif
                  
                </div> 
              @endforeach
                  <div class="main_aper_btns text-center mt-4">
 
                    <a href="{{ url()->previous() }}" class="btn btn-success">Back</a>
 
                    <button type="submit" class="btn btn-primary">Submit Quiz</button>
                  </div>

            </form>



        @else

          <p>Wait for quiz.</p>
          <br>
          <a  href="{{url('/dashboard')}}"><button type="button" class="btn btn-info">Go Back</button></a>

        @endif


       <!--  <img src="http://lms.greconlive.com/assets/img/latest/logo.png" alt="" class="paper_bg img-fluid">
 -->
      </div>

    </div>

  </div>

</div>





<script>
  $(".unique_btn").on("click", function(){
    $(this).toggleClass("btn-primary");
  });
</script>

<script type="text/javascript">

  $(function() 
  {
    setTimeout(function() {
     $("#questions").fadeOut(1500); 
    }, 5000)
  });
  
</script>

<script type="text/javascript">
  $(document).ready(function(){
    timeout();
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

  <script type="text/javascript">

    $("body").on( "click", ".delete", function () {

    var task_id = $( this ).attr( "data-id" );

    console.log(task_id);

    var form_data = {

    id: task_id

    };

    swal({

    title: "Do you want to delete this Quiz?",

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

    url: '<?php echo url("/quiz/delete"); ?>',

    data: form_data,

    success: function ( msg ) {

    swal( "@lang('Quiz Deleted')", '', 'success' )

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