
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

    <li class = "active">Add New Sub Admin</li>

  </ol>

</div>

<div class="content_main">

  <div class="profile_main">

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3 class="main_title_ot">Add New Sub Admin</h3>

        <div class="tab-content">

        @foreach ($errors->all() as $error)

              <div class="alert alert-danger">{{ $error }}</div>

            @endforeach

          <form method="POST" action="/sub_admin/store" enctype="multipart/form-data">

            @csrf

            

            <div class="tab-pane active" id="tab_default_3">

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('sa_name')}}" name="sa_name" required="" minlength="3" maxlength ="50" autofocus="">

                      <label>Sub Admin name<span class="red">*</span></label>

                    </div>

                    @error('sa_name')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="email" class="form-control" name="email" value="{{old('email')}}" required maxlength="255"autofocus="" unique>

                      <label>Sub Admin Email<span class="red">*</span></label>

                    </div>

                     @error('email')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                   <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input id="password" type="password" data-minlength="8" id="inputPassword" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus="">

                      <label for="inputPassword" class="control-label">Password<span class="red">*</span></label>

                      @error('password')

                      <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                      </span>

                      @enderror 

                    </div>

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input id="inputPasswordConfirm" type="password" class="form-control" name="password_confirmation" data-match="#inputPassword" data-match-error="Whoops, these don't match" required autocomplete="new-password" autofocus="">

                      <div class="help-block with-errors"></div>

                      <label>Confirm Password<span class="red">*</span></label>

                    </div>

                  </div>

                <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                        <input type="tell" class="form-control" name="contact" value="{{ old('contact')}}" required="" autofocus="">

                        <label>Contact<span class="red">*</span></label>

                    </div>

                         @error('contact')

                        <span class="invalid-feedback" role="alert">

                        <strong>{{ $message }}</strong>

                        </span>

                        @enderror

                </div>                  

                  {{-- <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="file" name="image" accept="image/*" required="" autofocus="">

                      <label>Sub Admin Image<span class="red">*</span></label>

                    </div>

                  </div> --}}

                  <div class="col-md-6 p_right">

                      <div class="file_spacing">

                        <input id="file" class="choose" type="file" name="image" accept="image/*" required="" autofocus="" size="max:1024" required=""> 

                      </div>

                          @error('image')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                    </div>

                  <div class="col-md-6 p_left">

                      <div class="custom_input_main select_plugin mobile_field">

                        <select class="selectpicker" name="role">

                          <option value="2">Sub Admin</option>

                        </select>

                        <label class="select_lable">Role</label>

                      </div>

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('details')}}" name="details" required="" minlength="3" maxlength ="255" autofocus="">

                      <label>Details<span class="red">*</span></label>

                    </div>

                    @error('Details')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

               </div>

                  <div class="s_form_button text-center">

                      <a  href="{{url('/subadmin/show')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                      <button type="submit" class="btn save_btn">Save</button>

                    </div>

                  </div>

              </form>

            </div>

            

          </div>

        </div>

      </div>

    </div>




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

<script>
			jQuery(document).ready(function($) {
					$('#myForm').validator();
			});
		</script>

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
    
    <!-- End bootstrap 3 validation  Cdn-->
    <!-- bootstrap 4 Validation CDN-->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <!-- bootstrap 4 Validation CDN-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js" integrity="sha512-dTu0vJs5ndrd3kPwnYixvOCsvef5SGYW/zSSK4bcjRBcZHzqThq7pt7PmCv55yb8iBvni0TSeIDV8RYKjZL36A==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js" integrity="sha512-Mf4TMPxK1TE3jNpbt6cFIM9Rz+Ezs+mvG6SvEKq2ZYEAix8QNtbseSccunI4efVNtvfzrRmd8vVwRRBgYMtfnA==" crossorigin="anonymous"></script>


@endsection