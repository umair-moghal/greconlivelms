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
    <li class = "active">Add New Instructor</li>
  </ol>
</div>
<div class="content_main">
  <div class="profile_main">
    <div class="profile mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        
        <h3 class="main_title_ot">Add New Instructor</h3>
        <div class="tab-content">
          <form method="POST" action="{{ url('/instructors/create') }}" enctype="multipart/form-data">
                 @csrf
            @foreach ($errors->all() as $error)
              <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
            <div class="tab-pane active" id="tab_default_3">
              <div class="s_profile_fields">
                <div class="row">
                  <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                      <input type="text" class="form-control" value="{{ old('name')}}" name="name" required="" minlength="3" maxlength ="50" autofocus="">
                      <label>Instructor name<span class="red">*</span></label>
                    </div>
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-md-6 p_right">
                    <div class="custom_input_main mobile_field">
                      <input type="email" class="form-control" name="email" value="{{old('email')}}" required maxlength="255"autofocus="">
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
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus="">
                      <label>Password<span class="red">*</span></label>
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6 p_right">
                    <div class="custom_input_main mobile_field">
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" autofocus="">
                      <label>Confirm Password<span class="red">*</span></label>
                    </div>
                  </div>
                  <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                      <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg" required="" autofocus="">
                      <label>Image<span class="red">*</span></label>
                    </div>
                  </div>
                  <div class="col-md-12">
                      <div class="custom_input_main select_plugin mobile_field">
                        <!-- <select class="selectpicker" name="role">
                          <option value="4">Instructor</option>
                        </select> -->
                        <input type="text" class="form-control" value="Instructor" name="role" class="mb-4" required="" autofocus="" readonly="readonly">
                        <label class="select_lable">Role</label>
                      </div>
                  </div>
                <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                      <input type="hidden" class="form-control" value="empty" name="fname" class="mb-4"  minlength="3" maxlength ="50" autofocus="">
                     
                    </div>
                    @error('fname')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="col-md-12 p_right">
                    <div class="custom_input_main mobile_field">
                      <input type="tell" class="form-control" name="phno" value="{{ old('phno')}}"   required=""  autofocus="">
                      <label>Phone No<span class="red">*</span></label>
                    </div>
                    @error('phno')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                      <input type="hidden" class="form-control" value="232323" name="cnic"class="mb-4"    autofocus="">
                     
                    </div>
                    @error('cnic')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-md-6 p_right">
                    <div class="custom_input_main mobile_field">
                      <input type="hidden" class="form-control" value="232323" name="add" class="mb-4"  minlength="3" maxlength ="200" autofocus="">
                      
                    </div>
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="s_form_button text-center">
                      <a  href="{{url('/instructors')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>
                      <button type="submit" class="btn save_btn">Save</button>
                    </div>
                  </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <script>
        $(":input").inputmask();
    </script>
    <script type="text/javascript">
      setTimeout(function() {
        $('#message').fadeOut('fast');
    }, 2000);
    </script>   
@endsection
       