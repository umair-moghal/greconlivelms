@extends('layouts.app')

@section('content')

   <style>
   #lod{
   visibility:hidden;
   }
   </style>

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

    <li class = "active">Set Grades for your school</li>

  </ol>

</div>

<div class="content_main">
  <div class="profile_main">
    <div class="profile mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        <h3 class="main_title_ot">Set Grade</h3>
        <div class="tab-content">
          <form method="POST" action="{{url('/setgrades')}}" enctype="multipart/form-data">

            @csrf

              <input type="hidden" name="course_id" value="{{$id}}">
              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" type="number" min="0" step="0.01" name="from" value="{{old('from')}}" required autofocus="">

                      <label>Marks From<span class="red">*</span></label>

                    </div>

                    @error('from')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" type="number" min="0" step="0.01" name="to" value="{{old('to')}}" required autofocus="">

                      <label>Marks To<span class="red">*</span></label>

                    </div>

                    @error('from')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main select_plugin mobile_field">

                    <select class="selectpicker" name="grade">
                      

                        <option value="A+">A+</option>
                        <option value="A">A</option>
                        <option value="B+">B+</option>
                        <option value="B">B</option>
                        <option value="C+">C+</option>
                        <option value="C">C</option>
                        <option value="D+">D+</option>
                        <option value="D">D</option>
                        <option value="D">E+</option>
                        <option value="D">E</option>
                        <option value="F">F</option>
                        <option value="F">G</option>
                        <option value="F">H</option>
                        <option value="F">I</option>


                    </select>

                    <label class="select_lable">Grades</label>

                  </div>

                  </div>

                </div>
                    

                  </div>


                  <div class="s_form_button text-center">

                    <a  href="{{url('/course')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                    <button type="submit" class="btn save_btn">Set Grade</button>

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
   jQuery(document).ready(function() {
      $('.radio_btn').click(function() {
        /* Act on the event */
        $('.radio_btn').removeClass('active');
        $(this).addClass('active');
      }); 
      $('.week_btn').click(function(event) {
        /* Act on the event */
        $('.week_btn').removeClass('btn-primary');
        $(this).addClass('btn-primary');
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

    title: "Do you want to delete this grade?",

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

    url: '<?php echo url("/grade/delete"); ?>',

    data: form_data,

    success: function ( msg ) {

    swal( "@lang('Grade Deleted')", '', 'success' )

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