@extends('layouts.app')

@section('content')

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

    

    <div class="course_table mt-0">

      <div class="course card-header card-header-warning card-header-icon" style="position: relative; z-index: 1";>
                <h3 class="text-center">Quiz View</h3>   
 

                <div class="row">
                  <div class="col-md-6">
                    <div class="total_time">
                      <p>Total Time : <span>60min</span></p>
                    </div>
                  </div>
                  <div class="col-md-6 text-right">
                    <div class="total_time">
                      <p>Grading Scale : <span>90%</span></p>
                    </div>
                  </div>
                  
                  <div class="col-md-6 ">
                    <div class="total_time" >
                      <p>Date : <span>today</span></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="total_time text-right">
                      <p>Total Marks : <span>60</span></p>
                    </div>
                  </div>
                  <div class="col-md-6 ">
                    <div class="total_time">

                      <p>Negative Marking : <span>Enable</span></p>
                    </div>
                  </div>
                </div>

        @foreach($questions as $q)
          <?php 
            $qstn = DB::table('questions')->where('id', $q->question_id)->get()->first();
            if($qstn->type == 'question/answer')
              {
                $opts = $qstn->options;
              }
            else
            {
              $opts = unserialize($qstn->options);
            }
          ?>
          <div>
            <div class="question_listing">
              <h4>{{$qstn->label}}</h4>
            </div>
            @if($qstn->type == 'mcq')
              <div>
                <div class="row">
                  <!-- <ul style="list-style-type: none;">
                    <li><label><input type="radio" name="" value=""><span>{{$opts['opt1']}}</span></label></li>
                    <li><label><input type="radio" name="" value=""><span>{{$opts['opt2']}}</span></label></li>
                    <li><label><input type="radio" name="" value=""><span>{{$opts['opt3']}}</span></label></li>
                    <li><label><input type="radio" name="" value=""><span>{{$opts['opt4']}}</span></label></li>
                  </ul> -->

                  <div class="col-md-3">
                    <button type="button" class="btn multi_select_btn"> {{$opts['opt1']}} 
                      <input type="radio" name="" value="">
                    </button>
                  </div>

                  <div class="col-md-3">
                    <button type="button" class="btn multi_select_btn"> {{$opts['opt2']}} 
                      <input type="radio" name="" value="">
                    </button>
                  </div>

                  <div class="col-md-3">
                    <button type="button" class="btn multi_select_btn"> {{$opts['opt3']}} 
                      <input type="radio" name="" value="">
                    </button>
                  </div>

                  <div class="col-md-3">
                    <button type="button" class="btn multi_select_btn"> {{$opts['opt4']}} 
                      <input type="radio" name="" value="">
                    </button>
                  </div>

                </div>
              </div>
            @elseif($qstn->type == 't/f')
              <div>
                <div class="row">
                  <div class="col-md-3">

                    <button type="button" class="btn t_f_btn"> 
                      {{$opts['true']}}
                      <input type="radio" value="true" name="correct" class="btn"/>
                    </button>

                 <!--    <label>{{$opts['true']}}</label>

                    <input type="radio" value="true" name="correct" class="btn"/> -->

                  </div>

                  <div class="col-md-3">
                    
                  
                    <button type="button" class="btn t_f_btn">
                         {{$opts['false']}}      
                         <input type="radio" value="false" name="correct" class="btn"/>

                    </button>

                    <!-- <label>{{$opts['false']}}</label>

                    <input type="radio" value="false" name="correct" class="btn"/> -->
                              
                              
                  </div>
                </div>
              </div>
              @elseif($qstn->type == 'question/answer')
              <div>
                <div class="row">
                  <div class="col-md-12">

                    <input type="text" value="" name=""  class="form-control" />
                              
                              
                  </div>
                </div>
              </div>
            @endif
          </div> 
         
        @endforeach
<!-- <img src="http://lms.greconlive.com/assets/img/latest/logo.png" alt="" class="paper_bg img-fluid"> -->
      </div>

    </div>

  </div>

</div>


<script>
  $('.t_f_btn').click(function(event) {
    /* Act on the event */
    $('.t_f_btn').removeClass('btn-primary');
    $(this).addClass('btn-primary');
  });
</script>

<script>
    $(".multi_select_btn").on("click", function(){
      $(this).addClass("btn-primary");
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