@extends('layouts.app')
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
      <li class = "active">All Questions</li>
    </ol>
  </div>
  <div class="content_main">
    <div class="all_courses_main">
      <div class="course_table mt-0">
          <div class="course card-header card-header-warning card-header-icon">
            <h3>Add question to quiz</h3>

             @if(count($all_questions)>0)

            <div class="table_filters">

              <div class="table_search">

                <input type="text" name="search" id="search" value="" placeholder="Search by label">

                <a href="#"> <i class="fa fa-search"></i> </a>

              </div>

<!--               <div class="table_search">

                <input type="text" name="search" id="search_recent" value="" placeholder="Search recently added">

                <a href="#"> <i class="fa fa-search"></i> </a>

              </div>

              <div class="table_search">

                <input type="text" name="search" id="search_notused" value="" placeholder="Search not used yet">

                <a href="#"> <i class="fa fa-search"></i> </a>

              </div> -->
                <div class="dropdown table_select">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter Questions
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{url('/filterall/'.$course->id.'/'.$quiz_id)}}">All questions</a>
                    <a class="dropdown-item" href="{{url('/filterrecent/'.$course->id.'/'.$quiz_id)}}">Recently added</a>
                    <a class="dropdown-item" href="{{url('/filternotused/'.$course->id.'/'.$quiz_id)}}">Not used yet</a>
                  </div>
                </div>
                <!-- 
              <div class="table_select">

                <select class="selectpicker">
                  <a href="{{url('/filterall')}}">
                    <option>All questions</option>
                  </a>
                  <a href="{{url('/filterrecent')}}">
                    <option>Recently added </option>
                  </a>
                  <a href="{{url('/filternotused')}}">
                  <option>Not used yet</option>
                  </a>
                </select>
                -->
            </div>

         
          
          <!--<div class="table_filters">-->
             <table class="table table-hover" id="table-id">
                <thead>
                  <tr>
                    <th scope="col"> Sr. </th>
                    <th scope="col"> Question </th>
                    <th scope="col"> Type </th>
                    <th scope="col"> Action </th>
                  </tr>
                </thead>
               
               <tbody id="mybody">
                    <form method="POST" action="{{route('add.question.to.quiz')}}" enctype="multipart/form-data">
                     @csrf
                   @foreach($all_questions as $index =>$q)
                    <tr>
                      <td class="first_row">#{{$index+1}}</td>
                      <td class="first_row">{{$q->label}}</td>
                      <td class="first_row">{{$q->type}}</td>
                      <td class="first_row">  
                      <input type="checkbox" <?php if(in_array($q->id,$arr_questions)) { ?> checked <?php } ?> name="question_id[]" value="{{$q->id}}"> 
                      </td>
                    </tr>
                   @endforeach
               </tbody>
                   <input  type="hidden" value="{{$quiz_id}}" name="quiz_id" > 
             </table>  
               <button class="btn btn-success" type="submit"> Assign question </button>
             </form>
             <a href="{{url('/mcq/create/'. $insid .'/'. $course->id .'/'. $week .'/'. $quiz_id)}}"><button class="btn btn-primary" type="submit"> Create questions </button></a>
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

              <p>No Question Created Yet</p>
              
              <a class="btn btn-primary" href="{{url('/mcq/create/'. $insid .'/'. $course->id .'/'. $week .'/'. $quiz_id)}}"><i class="fa fa-plus"></i>Create Questions</a>

              <a  href="{{url('/course/show_week_details/'. $insid .'/'. $course->id .'/'. $week .'/'. $clasid)}}"><button type="button" class="btn cncl_btn">Back</button></a>

            @endif
               
          </div>
        </div>
      </div>
    </div>
  </div>

<script>

    $(document).ready(function(){

      $("#search_recent").on("keyup", function() {

        var value = $(this).val().toLowerCase();

        alert(value);

        $("#mybody tr").filter(function() {

          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)

        });

      });

    });

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
    title: "Do you want to delete this department?",
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
    url: '<?php echo url("/departments/delete"); ?>',
    data: form_data,
    success: function ( msg ) {
    swal( "@lang('Department Deleted')", '', 'success' )
    setTimeout( function () {
    location.reload();
    }, 1000 );
    }
    } );
    }
    } );
    } );
  </script>
  <script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
  <script>
    getPagination('#table-id');
	
    function getPagination(table) {
      var lastPage = 1;

      $('#maxRows')
        .on('change', function(evt) {
          //$('.paginationprev').html('');						// reset pagination

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
            //	numbers of pages
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
            // $(this).addClass('active');					// add active class to the clicked
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