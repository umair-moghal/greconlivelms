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

    <li class = "active">Edit Essay</li>

  </ol>

</div>

<div class="content_main">
  <div class="profile_main">
    <div class="profile mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        <h3 class="main_title_ot">Edit Essay</h3>
        <div class="tab-content">
          <form method="POST" action="{{url('/q/update/'.$q->id)}}" enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="course_id" value="{{$courseid}}">
                <div class="quiz_head">
	                <h5>Question</h5>
	                <div class="quiz_form">
	                  <div class="custom_input_main remove_ex_margin">
	                    <textarea class="form-control" name="label" value="{!!old('label', $q->label)!!}" autofocus="" style="height: 100px !important;"> 
	                    	{{$q->label}}
	                    </textarea>
	                    <label>Topic <span class="red">*</span></label>
	                  </div>
	                  @error('label')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror
	                </div>
                </div>
    		    <div class="col-md-12">

                  <div class="custom_input_main mobile_field">

                  	<textarea class="form-control" name="ans" value="{!! old('ans', $q->options) !!}" autofocus="" style="height: 100px !important;"> 
                  		{{$q->options}}
                  	</textarea>

                    <label>Answer.

                      <span class="red">*</span>
                    </label>

                  </div>
                  @error('ans')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

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

@endsection