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

        

        <h3>Special Education Notification</h3>



          <div class="table_filters">

            <div class="table_search">

              <input type="text" name="search" id="search" value="" placeholder="Search...">

              <a href="#"> <i class="fa fa-search"></i> </a>

            </div>

          </div>

          {{-- @dd($special_education); --}}

          <table class="table table-hover table-responsive" id="table-id">

            <thead>

              <tr>

                <th scope="col">ID</th>

                <th scope="col">Student ID</th>

                <th scope="col">File</th>

                <th scope="col">Notes</th>

                <th scope="col">Signature</th>

                <th scope="col">Text Information</th>

                <th scope="col">Action</th>

              </tr>

            </thead>

            <tbody>

              <tr>

                {{-- <th scope="row">#{{$index+1}}</th> --}}

                <td class="first_row">{{$special_education->student_id}}</td>

                @if ($special_education->type=='pdf')

              <td class="first_row">

                <embed src="{{asset('assets/img/upload/'.$special_education->upload_file)}}" type="application/pdf" height="100" width="150"> 

                <p><a href={{route('/download', $special_education->id)}}>{{$special_education->upload_file}}</a></p>

               </td>

               @elseif ($special_education->type=='docx'|| $sp_especial_educationdu->type=='odt' || $special_education->type=='xlsx' || $special_education->type=='pptx' || $special_education->type=='txt')

               <td class="first_row">

               <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{asset('assets/img/upload/'.$special_education->upload_file)}}" frameborder="0" height="100" width="150"></iframe>
               <p><a href={{route('/download', $sp_special_educationedu->id)}}>{{$special_education->upload_file}}</a></p>

               </td>

               @elseif ($special_education->type=='mp4'|| $special_education->type=='mov' || $special_education->type=='wmv' || $special_education->type=='flv' || $special_education->type=='avi' || $special_education->type=='avchd' || $sp_edu->type=='webM' || $sp_edu->type=='mkv')

               <td class="first_row">

               <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{asset('assets/img/upload/'.$special_education->upload_file)}}" frameborder="0" height="100" width="150"></iframe>
               <p><a href={{route('/download', $special_education->id)}}>{{$special_education->upload_file}}</a></p>

               </td>

               @endif






              <td class="first_row">{{$special_education->parent_comments}}</td>

              <td class="first_row">

                <img src="{{asset('assets/img/upload/'.$special_education->signature)}}" height="100" width="150">
                
                <p>{{$special_education->signature}}</p>

              </td>

                <td class="first_row">{{$special_education->text_information}}</td>

                <td class="align_ellipse first_row">

                
                 <a class="item  btn btn-primary" href="#">Approve</a>
                  <a href="javascript:void(0);" data-id="<?php echo $special_education->id; ?>" class="btn btn-danger  delete">Decline</a>

                </td>

              </tr>

             

            </tbody>

          </table> 

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

@endsection