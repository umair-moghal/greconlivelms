@extends('layouts.app')

@section('content')

  <div id="message">

    @if (Session::has('message'))

      <div class="alert alert-info">

        {{ Session::get('message') }}

      </div>

    @endif

  </div>


          
  <div class="content_main content">
    
    <div class="container-fluid">
    
        <div class="all_courses_main">

    

    <div class="course_table mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3>Special Education Status Documents of Special Status Student <span style="color:green">{{$student->last_name}}({{$student->record_no}})</span></h3>



          <div class="table_filters">

            <div class="table_search">

              <input type="text" name="search" id="search" value="" placeholder="Search...">

              <a href="#"> <i class="fa fa-search"></i> </a>

            </div>

          </div>

          <table class="table table-hover" id="table-id">

            <thead>

              <tr>

                <th scope="col">ID</th>

                <th scope="col">Student ID</th>

                <th scope="col">File</th>

                <th scope="col">Notes</th>

                <th scope="col">Action</th>

              </tr>

            </thead>

            <tbody>

            {{-- @dd($special); --}}

              @foreach($special as $index =>$sp_edu)

              <tr>

                <th scope="row">#{{$index+1}}</th>

                <td class="first_row">{{$sp_edu->student_id}}</td>

                @if ($sp_edu->type=='pdf')

              <td class="first_row">

                <embed src="{{asset('assets/img/upload/'.$sp_edu->upload_file)}}" type="application/pdf" height="100" width="150"> 

                <p><a href={{route('/download', $sp_edu->id)}}>{{$sp_edu->upload_file}}</a></p>

               </td>

               @elseif ($sp_edu->type=='docx'|| $sp_edu->type=='odt' || $sp_edu->type=='xlsx' || $sp_edu->type=='pptx' || $sp_edu->type=='txt')

               <td class="first_row">

               <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{asset('assets/img/upload/'.$sp_edu->upload_file)}}" frameborder="0" height="100" width="150"></iframe>
               <p><a href={{route('/download', $sp_edu->id)}}>{{$sp_edu->upload_file}}</a></p>

               </td>

               @elseif ($sp_edu->type=='mp4'|| $sp_edu->type=='mov' || $sp_edu->type=='wmv' || $sp_edu->type=='flv' || $sp_edu->type=='avi' || $sp_edu->type=='avchd' || $sp_edu->type=='webM' || $sp_edu->type=='mkv')

               <td class="first_row">

               <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{asset('assets/img/upload/'.$sp_edu->upload_file)}}" frameborder="0" height="100" width="150"></iframe>
               <p><a href={{route('/download', $sp_edu->id)}}>{{$sp_edu->upload_file}}</a></p>

               </td>

               @endif






              <td class="first_row">{{$sp_edu->parent_comments}}</td>

             

                <td class="align_ellipse first_row">

                  {{-- <li class="nav-item dropdown">

                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                      <span class="material-icons">

                        more_horiz

                      </span>

                      <div class="ripple-container"></div>

                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                      <a class="dropdown-item" href="{{url('/special_education/edit/' . $sp_edu->id)}}"><i class="fa fa-cogs"></i>Edit</a>

                      <!--<a href="javascript:void(0);" data-id="" class="dropdown-item delete"><i class="fa fa-trash"></i>Decline</a>-->

                    </div>

                  </li> --}}
				  <!--
                 <a class="item  btn btn-primary" href="#">Approve</a>
                  <a href="javascript:void(0);" data-id="<?php echo $sp_edu->id; ?>" class="btn btn-danger  delete">Decline</a>
-->
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

</div>

<script>

  var uploadField = document.getElementById("file");

  uploadField.onchange = function() {

      if(this.files[0].size > 100 * 1024 * 1024){

        alert("File is too big!");

        this.value = "";

      };

  };



</script>







  



  <script src="{{url('backend/sweetalerts/sweetalert2.all.js')}}"></script>
  
  <script type="text/javascript">

    setTimeout(function() {

      $('#message').fadeOut('fast');

    }, 30000);

  </script>

  

<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

</script>

<script type="text/javascript">

  $( "body" ).on( "click", ".delete", function () {

    var task_id = $( this ).attr( "data-id" );

    var form_data = {

        id: task_id

    };

    swal({

        title: "Do you want to decline",

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

                url: '<?php echo url("/special_education/destroy"); ?>',

                data: form_data,

                success: function ( msg ) {

                    swal( "@lang('Special Education Declined Successfully')", '', 'success' )

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
getPagination('#table-id');

function getPagination(table) {
var lastPage = 1;

$('#maxRows')
.on('change', function(evt) {
//$('.paginationprev').html(''); // reset pagination

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
// each TR in table and not the header
trnum++; // Start Counter
if (trnum > maxRows) {
// if tr number gt maxRows

$(this).hide(); // fade it out
}
if (trnum <= maxRows) {
$(this).show();
} // else fade in Important in case if it ..
}); // was fade out to fade it in
if (totalRows > maxRows) {
// if tr total rows gt max rows option
var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
// numbers of pages
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
// $(this).addClass('active'); // add active class to the clicked
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
for( let i = ( parseInt($('.pagination li.active').attr('data-page')) -2 ) ; i <= ( parseInt($('.pagination li.active').attr('data-page')) + 2 ) ; i++ ){
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