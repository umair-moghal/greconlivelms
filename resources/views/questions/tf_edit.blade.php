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

    <li class = "active">Edit True False</li>

  </ol>

</div>

<div class="content_main">
  <div class="profile_main">
    <div class="profile mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        <h3 class="main_title_ot">Edit True False</h3>
        <div class="tab-content">
          <?php
            $opts = unserialize($tf->options);
            // dd($opts['correct']);
          ?>
          <form method="POST" action="{{url('/tf/update/'.$tf->id)}}" enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="course_id" value="{{$courseid}}">
                <div class="quiz_head">
                <h5>Question</h5>
                <div class="quiz_form">
                  <div class="custom_input_main remove_ex_margin">
                    <textarea class="form-control" name="label" value="{!!old('label')!!}" autofocus="" required="" style="height: 100px !important;"> 
                      {{$tf->label}}
                    </textarea>
                    <label>Topic <span class="red">*</span></label>
                  </div>
                </div>
                <div class="answers_tf">

                <h5>Answer</h5>

                <div class="true_false_btns">
                  <button type="button" class="btn true_btn @if($opts['correct'] == 'true') false_btn add_margin_to_f active_tf_btn @endif">True 
                  <input type="radio" name="correct" class="btn" value="true" {{ $opts['correct'] == 'true' ? 'checked' : ' ' }} >
                </button>

                  <button type="button" class="btn true_btn  @if($opts['correct'] == 'false') false_btn add_margin_to_f active_tf_btn @endif">False 
                    <input type="radio" value="false"  name="correct" class="btn" {{$opts['correct'] == 'false' ? 'checked' : ' ' }}>
                  </button>

     

                  


                  </button>


              </div>

                    <div class="s_form_button text-center">

                      <a  href="{{url('/mcq/create/'.$courseid)}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                      <button type="submit" class="btn save_btn">Update</button>

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
  $('.true_btn').click(function(event) {
    /* Act on the event */
    $('.true_btn').removeClass('active_tf_btn');
    $(this).addClass('active_tf_btn');
  });
</script>

@endsection