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

    <li class = "active">Add New Link</li>

  </ol>

</div>

            <div class="assignment">

              <div class="card-header main_ac">

                <h3>Add Link</h3>

                <div class="ac_add_form">

                      @foreach ($errors->all() as $error)

                        <div class="alert alert-danger">{{ $error }}</div>

                      @endforeach
                    <form action="{{url('/linkcreate')}}" method="POST" enctype="multipart/form-data" class="w-100">
                     <div class="row">

                   

                      {{@csrf_field()}}

                      

                      <input type="hidden" name="course_id" value="{{$course_id}}">  
                      <input type="hidden" name="instructor_id" value="{{$instructor_id}}">  
                      <input type="hidden" name="week" value="{{$week}}">  

                    <div class="col-md-6 p_left">

                      <div class="custom_input_main">

                        <input type="text" class="form-control" value="{{ old('title')}}" name="title" required="" minlength="3" maxlength ="50" autofocus="">

                        <label>Title <span class="red">*</span></label>

                      </div>

                          @error('title')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                    </div>

                    <div class="col-md-6 p_right">

                      <div class="custom_input_main">

                        <input type="text" name="link" value="{{old('link')}}" class="form-control" size="max:10240" required="" minlength="1" maxlength ="255">

                        <label>Link <span class="red">*</span></label>

                      </div>

                          @error('link')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                    </div>

                    <div class="col-md-12">

                      <div class="custom_input_main">

                          <textarea name="short_des" cols="8" id="txtEditor" value="{!!old('short_des')!!}" class="form-control" style="height: 100px !important;width: 100%;" required="" minlength="3" maxlength ="255">
                          
                          </textarea>

                          <label>Link description<span class="red">*</span></label>

                      </div>

                          @error('short_des')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                      </div>

                       <div class="form-check">
                              <input type="checkbox" name="send_notification"><label> Check to Send Notification for Resource Updates.</label>   
                            </div>


                    <div class="col-md-12">

                      <div class="s_form_button text-center">

                        <a  href="{{url('/course/show_week_details/'. $instructor_id .'/'. $course_id .'/'. $week)}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                        <button type="submit" class="btn save_btn">Save<div class="ripple-container"></div></button>

                      </div>

                    </div>
                    </div>
                    
                    </form>

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

  $("body").on( "click", ".delete", function () {

  var task_id = $( this ).attr( "data-id" );

  console.log(task_id);

  var form_data = {

  id: task_id

  };

  swal({

  title: "Do you want to delete this link",



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



  url: '<?php echo url("/linkdelete/{id}"); ?>',

  data: form_data,

  success: function ( msg ) {

  swal( "@lang('Link Deleted')", '', 'success' )

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

