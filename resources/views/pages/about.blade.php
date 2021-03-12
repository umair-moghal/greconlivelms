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

    <li class = "active">Edit About Page</li>

  </ol>

</div>

<div class="content_main">

  <div class="profile_main">

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        <h3 class="main_title_ot">Edit About Page Info</h3>

        <div class="tab-content">

          <form class="form-horizontal" method="POST" action="{{ url('/updateabout/'. $about->id) }}" enctype="multipart/form-data">

            @csrf

            <div class="tab-pane active" id="tab_default_3">

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control"  name="title" value="{{old('title', $about->title)}}" required minlength="3" maxlength="50" autofocus="">

                      <label>Title<span class="red">*</span></label>

                    </div>

                    @error('title')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg" autofocus="">

                      <label>Image<span class="red">*</span></label>
                      <img class="img-fluid" src="{{asset('assets/img/upload/'.$about->image)}}" width ="50" height="50">


                    </div>

                  </div>

                  <div class="col-md-12">

                    <div class="custom_input_main mobile_field">

                      <textarea name="content" cols="16" id="txtEditor" value="{!!old('content')!!}" style="height: 35px;width: 100%;" required="">
                        {!! $about->content !!}
                      </textarea>

                      <label>Content <span class="red">*</span></label>

                    </div>

                  </div>


                  <div class="s_form_button text-center">

                    <a  href="{{url('/aboutpage')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                    <button type="submit" class="btn save_btn">Update</button>

                  </div>

                </div>

              </div>
            </div>

          </form>

        </div>
      </div>

    </div>

  </div>

</div>

  <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

  <script>

    CKEDITOR.replace( 'txtEditor' );

  </script>

  <script>

    $(":input").inputmask();

  </script>

  <script type="text/javascript">

    setTimeout(function() {

      $('#message').fadeOut('fast');

    }, 2000);

  </script>
@endsection