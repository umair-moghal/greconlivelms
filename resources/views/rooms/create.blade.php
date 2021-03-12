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

    <li class = "active">Add New Room</li>

  </ol>

</div>

<div class="content_main">
  <div class="profile_main">
    <div class="profile mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        <h3 class="main_title_ot">Add New Room</h3>
        <div class="tab-content">
          <form method="POST" action="{{url('/rooms/create')}}" enctype="multipart/form-data">

            @csrf

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" type="text" name="name" value="{{old('name')}}" required minlength="3" maxlength="255" autofocus="">

                      <label>Name<span class="red">*</span></label>

                    </div>

                    @error('name')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" type="text" name="room_no" value="{{old('room_no')}}" required minlength="1" maxlength="25" autofocus="">

                      <label>Room No<span class="red">*</span></label>

                    </div>

                    @error('room_no')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input class="form-control" name="floor_no" value="{{old('floor_no')}}" required minlength="1" maxlength="25" autofocus="">

                      <label>Floor No<span class="red">*</span></label>

                    </div>

                    @error('floor_no')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="s_form_button text-center">

                    <a  href="{{url('/rooms')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                    <button type="submit" class="btn save_btn">Add</button>

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
@endsection