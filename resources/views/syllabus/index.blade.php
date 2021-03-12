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

                <li>Terms/Sessions</li>

                <li>Courses</li>

                <li class="active">Upload Syllabus</li>

              </ol>

            </div>

            <div class="assignment">

              <div class="card-header main_ac">

                <h3>Add Syllabus</h3>

                <div class="ac_add_form">

                @foreach ($errors->all() as $error)

                  <div class="alert alert-danger">{{ $error }}</div>

                @endforeach

                  <form action="{{url('/upload_syllabus')}}" method="POST" enctype="multipart/form-data" class="w-100">

                    <div class="row">

                     

                        {{@csrf_field()}}

                        

                      <input type="hidden" name="course_id" value="{{$id}}">

                        <div class="col-md-6 p_right">

                          <div class="file_spacing">

                            <input id="file" class="choose" type="file" name="file" value="{{old('file')}}" accept=".doc,.docx,.pptx,.xlsx,.txt,application/pdf,application/vnd.ms-excel/application/vnd.ms-docx" autofocus="" size="max:10240" required>

                          </div>

                            @error('file')

                            <span class="invalid-feedback" role="alert">

                            <strong>{{ $message }}</strong>

                            </span>

                            @enderror

                      </div>

                      <div class="col-md-12">

                        <div class="custom_input_main">

                          <textarea name="desc" cols="8" id="txtEditor" value="{!!old('desc')!!}" style="height: 35px;width: 100%;" required=""></textarea>

                          <label>Syllabus<span class="red">*</span></label>

                        </div>

                            @error('desc')

                            <span class="invalid-feedback" role="alert">

                            <strong>{{ $message }}</strong>

                            </span>

                            @enderror

                        </div>

                        </div>

                        <div class="form-check">
                              <input type="checkbox" name="send_notification"><label> Check to Send Notification for Resource Updates.</label>   
                            </div>
                      

                        <div class="col-md-12">

                          <div class="s_form_button text-center">

                            <a  href="{{url('/course')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                            <button type="submit" class="btn save_btn">Upload<div class="ripple-container"></div></button>

                          </div>

                        </div>


                  </form>

                  

                </div>

                  <div class="content_main">
      <div class="all_courses_main">
        
        <div class="course_table mt-0">
          <div class="course card-header card-header-warning card-header-icon">
            
            <h3>All Syllabus</h3>
            @if(count($syllabus)>0)
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
                  <th scope="col">Document</th>
                  <th scope="col">Description</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody id="mybody">
                @foreach($syllabus as $index =>$sylbus)
                
                <tr>
                  <th scope="row">#{{$index+1}}</th>
                  <td class="first_row">
                    <div class="course_td">
                      <a  target="_blank" href="{{asset('/assets/img/documents/'.$sylbus->document)}}">View/Download</a>
                    </div>
                  </td>
                  
                  <td class="first_row">
                    {!! substr($sylbus->description, 0, 50) !!}
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
                        <a class="dropdown-item" href="{{url('/upload_syllabus/edit/' . $sylbus->id)}}"><i class="fa fa-cogs"></i>Edit</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-eye"></i>view</a>
                        <a href="javascript:void(0);" data-id="<?php echo $sylbus->id; ?>" class="dropdown-item delete"><i class="fa fa-trash"></i>Delete</a>
                        
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
                <p>No Syllabus uploaded yet</p>
                @endif
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
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>

  CKEDITOR.replace( 'txtEditor' );

</script>
<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

</script>

  <script type="text/javascript">

  $("body").on( "click", ".delete", function () {

  var task_id = $( this ).attr( "data-id" );

  console.log(task_id);

  var form_data = {

  id: task_id

  };

  swal({

  title: "Do you want to delete this syllabus",



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



  url: '<?php echo url("/deletesyllabus"); ?>',

  data: form_data,

  success: function ( msg ) {

  swal( "@lang('File Deleted')", '', 'success' )

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