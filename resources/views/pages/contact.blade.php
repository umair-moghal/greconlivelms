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

    <li class = "active">Edit Contact  Page</li>

  </ol>

</div>


<div class="content_main">

  <div class="profile_main">

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        <h3 class="main_title_ot">Edit Contact Page Info</h3>

        <div class="tab-content">
          <form class="form-horizontal" method="POST" action="{{ url('/updatecontact/'. $contact->id) }}" enctype="multipart/form-data">

            @csrf

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" name="title" value="{{old('title', $contact->title)}}" class="mb-4" required minlength="3" maxlength="50" autofocus="">

                      <label>Title<span class="red">*</span></label>

                    </div>

                    @error('title')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="email" class="form-control" name="email"value="{{old('email',$contact->email)}}"  required maxlength="255" autofocus="">

                      <label>Email<span class="red">*</span></label>

                    </div>

                    @error('email')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="file" name="image" value="{{old('image',$contact->image)}}"  class="mb-4" accept="image/x-png,image/gif,image/jpeg" autofocus="">

                      <label>Image<span class="red">*</span></label>
                       <img class="img-fluid" src="{{asset('assets/img/upload/'.$contact->image)}}" width ="100">

                    </div>

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="tel" class="form-control" name="phno" value="{{old('phno',$contact->phone)}}" required="" autofocus="">


                      <label>Phone No<span class="red">*</span></label>

                    </div>

                    @error('phno')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>


                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{old('add',$contact->address)}}"  name="add" class="mb-4" required="" minlength="3" maxlength ="200" autofocus="">

                      <label>Address<span class="red">*</span></label>

                    </div>

                    @error('address')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message}}</strong>

                      </span>

                    @enderror

                  </div>


                  <div class="s_form_button text-center">

                      <a  href="{{url('/contactpage')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

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

<script type="text/javascript">

  setTimeout(function() {

    $('#message').fadeOut('fast');

  }, 2000);

</script>

@endsection