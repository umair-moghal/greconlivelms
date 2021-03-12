@extends('layouts.app')

@section('content')



@if (Session::has('message'))

  <div class="alert alert-info">

    {{ Session::get('message') }}

  </div>

@endif 

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li class = "active">Add New School</li>

  </ol>

</div>

<div class="content_main">

  <div class="profile_main">

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3 class="main_title_ot">Add New School</h3>

        <div class="tab-content">

          <form method="POST" action="/schoolstore" enctype="multipart/form-data">

            @csrf

            @foreach ($errors->all() as $error)

              <div class="alert alert-danger">{{ $error }}</div>

            @endforeach

            <div class="tab-pane active" id="tab_default_3">

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('sname')}}" name="sname" required="" minlength="3" maxlength ="50" autofocus="">

                      <label>School name<span class="red">*</span></label>

                    </div>

                    @error('name')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">


                    <div class="inputfile-box">
                      <input type="file" name="simage" id="file" class="inputfile" onchange='uploadFile(this)' accept="image/x-png,image/gif,image/jpeg" required="" autofocus="">
                      <label for="file" class="lable_file">
                        <span id="file-name" class="file-box"></span>
                        <span class="file-button">
                          School image
                        </span>
                      </label>
                    </div>
                      <!-- <div class="custom_input_main mobile_field">

                      <input type="file" name="simage" accept="image/x-png,image/gif,image/jpeg" required="" autofocus="">

                      <label>School Image<span class="red">*</span></label>

                    </div>
 -->                   <!--  <div class="file_spacing">
                        <input  type="file" name="simage" accept="image/x-png,image/gif,image/jpeg" required="" autofocus="" class="choose">
                        
                      </div> -->

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('sadd')}}" name="sadd" class="mb-4" required="" minlength="3" maxlength ="200" autofocus="">

                      <label>School Address<span class="red">*</span></label>

                    </div>

                    @error('name')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('name')}}" name="name" required="" minlength="3" maxlength ="50" autofocus="">

                      <label>Superintendent<span class="red">*</span></label>

                    </div>

                    @error('oname')

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

                      <label>Owner Image<span class="red">*</span></label>

                    </div>

                  </div>

                  <div class="col-md-12">

                      <div class="custom_input_main select_plugin mobile_field">

                        <select class="selectpicker" name="role">

                          <option value="3">School</option>

                        </select>

                        <label class="select_lable">Role</label>

                      </div>

                  </div>

                <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('district')}}" name="district" class="mb-4" required="" minlength="3" maxlength ="50" autofocus="">

                      <label>District<span class="red">*</span></label>

                    </div>

                    @error('fname')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                </div>

                <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="tell" class="form-control" name="phno" value="{{ old('phno')}}"  autofocus="">

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

                      <input type="text" class="form-control" value="{{ old('s_id')}}" name="s_id"class="mb-4" required="" autofocus="">

                      <label>School Identification Number<span class="red">*</span></label>

                    </div>

                    @error('cnic')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

<!--                   <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('add')}}" name="add" class="mb-4" required="" minlength="3" maxlength ="200" autofocus="">

                      <label>Owner Address<span class="red">*</span></label>

                    </div>

                    @error('name')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div> -->



                  <div class="s_form_button text-center w-100">

                      <a  href="{{url('/schools')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

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
  function uploadFile(target) {
    document.getElementById("file-name").innerHTML = target.files[0].name;
}
</script>

<script type="text/javascript">

  var password = document.getElementById("password");

  var confirm_password = document.getElementById("password_confirmation");



function validatePassword(){

  if(password.value != confirm_password.value) {

    confirm_password.setCustomValidity("Passwords Don't Match");

  } else {

    confirm_password.setCustomValidity('');

  }

}



password.onchange = validatePassword;

confirm_password.onkeyup = validatePassword;

</script>  

<script type="text/javascript">

  setTimeout(function() {

    $('#message').fadeOut('fast');

}, 2000);

</script>   

@endsection