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

<style type="text/css">
  .hidden {
  display: none;
}
</style>

<div class="content_main">

  <div class="card-header assesment_main">

    <h3>Add Quizzes/Tests</h3>

    <div class="main_quiz">

      <div class="quiz_tabs">

        <ul class="nav nav-tabs ">

          <li class="quiz_tab_link">

            <a href="{{url('/mcq/create')}}">

            Multiple Choice </a>

          </li>

          <li class="quiz_tab_link">

            <a href="{{url('/q/create')}}">

            Questions</a>

          </li>

          <li class="quiz_tab_link second active">

            <a href="{{url('/fib/create')}}">

            Fill in the blanks </a>

          </li>

          <li class="quiz_tab_link second">

            <a href="{{url('/tf/create')}}">

            True/False </a>

          </li>

        </ul>

        <div class="tab-content">

          	<div class="tab-pane active" id="tab_default_1">

          		<form method="POST" action="{{url('/fib/store')}}">

          			@csrf

		            <div class="quiz_head">

		              <h5>Fill in the blanks</h5>

		              <div class="quiz_form">

		                <div class="custom_input_main remove_ex_margin">

		                  <input type="text" class="form-control" name="label" value="{!!old('label')!!}" autofocus="" required="">

		                  <label>Fill in the blank <span class="red">*</span></label>

		                </div>

                    <div class="save_next_btn text-center w-100">

                      <button type="button" id="add">Add Blank</button>
                      <div id="dynamic_field"></div>
                      <button type="button" class="btn_remove hidden">Remove last blank</button>

                      <button type="submit" class="btn btn-sm btn-success">Save and next</button>

                  
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




<script type="text/javascript">
  
  $(document).ready(function() {
  var i = 1;
  $('#add').click(function() {
    if (i <= 7) {
      $('#dynamic_field').append('<div id="row' + i + '"><label" for="member_' + i + '">Member ' + i + '</label><input type="text" name="member_' + i + '" value=""></div>')
      i++;
      $('.btn_remove').removeClass('hidden');
    }
  });
  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    i--;
    $('#row' + $('#dynamic_field div').length).remove();
    if (i<=1) {
      $('.btn_remove').addClass('hidden');
    }
  });
});
</script>
  


   <script type="text/javascript">

      setTimeout(function() {

        $('#message').fadeOut('fast');

    }, 2000);

    </script> 

@endsection