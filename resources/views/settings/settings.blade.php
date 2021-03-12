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

    <li class = "active">Edit Settings</li>

  </ol>

</div>

<div class="content_main">
  <div class="profile_main">
    <div class="profile mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        <h3 class="main_title_ot">Edit Setting</h3>
        <div class="tab-content">
          <form action="{{url('update/')}}" method="POST" enctype="multipart/form-data">

            {{@csrf_field()}} 

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="url" class="form-control" name="fb" value="{{old('fb', $setting->facebook_url)}}" required minlength="3" maxlength="50" autofocus="">

                      <label>Facebook Link<span class="red">*</span></label>

                    </div>

                    @error('fb')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="url" class="form-control" name="twitter" value="{{old('twitter', $setting->twitter_url)}}" required minlength="3" maxlength="50" autofocus="">

                      <label>Twitter Link<span class="red">*</span></label>

                    </div>

                    @error('twitter')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="url" class="form-control" name="youtube" value="{{old('youtube', $setting->youtube_url)}}" required minlength="3" maxlength="50" autofocus="">

                      <label>Youtube Link<span class="red">*</span></label>

                    </div>

                    @error('youtube')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" type="email" name="contact" value="{{old('contact', $setting->contact_email)}}" required minlength="3" maxlength="50" autofocus="">

                      <label>Contact Email<span class="red">*</span></label>

                    </div>

                    @error('contact')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" type="email" name="Noti" value="{{old('Noti', $setting->notification_email)}}" required minlength="3" maxlength="50" autofocus="">

                      <label>Notification Email<span class="red">*</span></label>

                    </div>

                    @error('Noti')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="tel" class="form-control" name="phone" value="{{old('phone', $setting->phone_number)}}"  required=""  autofocus="">


                      <label>Phone No<span class="red">*</span></label>

                    </div>

                    @error('phno')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="s_form_button text-center w-100">

                    <a  href="{{url('setting')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

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


<script type="text/javascript">

  setTimeout(function() {

    $('#message').fadeOut('fast');

  }, 2000);

</script>



@endsection