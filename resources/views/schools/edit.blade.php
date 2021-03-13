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

    <li class = "active">Edit School</a></li>

  </ol>

</div>

<div class="content_main">

  <div class="profile_main">

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3 class="main_title_ot">Edit School</h3>

        <div class="tab-content">

            <form class="form-horizontal" method="POST" action="{{ url('/school/update/'. $school->id) }}" enctype="multipart/form-data">

                @csrf

                @foreach ($errors->all() as $error)

                          <div class="alert alert-danger">{{ $error }}</div>

                        @endforeach

              <div class="tab-pane active" id="tab_default_3">

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{old('sname',$school->school_name)}}"  name="sname" required="" minlength="3" maxlength ="50" autofocus="">

                      <label>School name<span class="red">*</span></label>

                      <img src="{{asset('/assets/img/upload/'.$school->school_image)}}" width ="100" >

                    </div>

                    @error('sname')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="file" name="simage" value="{{old('simage',$school->school_image)}}"  class="mb-4" accept="image/x-png,image/gif,image/jpeg" autofocus="">

                      <label>School Image<span class="red">*</span></label>

                    </div>

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{old('sadd',$school->school_address)}}"  name="sadd" class="mb-4" required="" minlength="3" maxlength ="200" autofocus="">

                      <label>School Address<span class="red">*</span></label>

                    </div>

                    @error('saddress')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message}}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{old('name',$school->name)}}"  name="name" required="" minlength="3" maxlength ="50" autofocus="">

                      <label>Superintendent<span class="red">*</span></label>

                    </div>

                    @error('name')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="email" class="form-control" name="email"value="{{old('email',$school->email)}}"  required maxlength="255"autofocus="" uniq>

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

                      <input type="file" name="image" value="{{old('image',$school->image)}}"  class="mb-4" accept="image/x-png,image/gif,image/jpeg" autofocus="">

                      <label>Owner Image<span class="red">*</span></label>

                    </div>

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <!-- <select required="required" class="form-control" name="role">

                          <option value="3">School</option>

                      </select> -->

                      <input type="text" class="form-control" value="School" name="role" class="mb-4" required="" autofocus="" readonly="readonly">
                      <label>Role<span class="red">*</span></label>

                    </div>

                  </div>

                <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{old('district',$school->district)}}" name="district" class="mb-4" required="" minlength="3" maxlength ="50" autofocus="">

                      <label>District<span class="red">*</span></label>

                    </div>

                    @error('district')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                </div>

                <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="tell" class="form-control" name="phno" value="{{old('phno',$school->phone)}}"  required=""  autofocus="">

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

                      <input type="text" class="form-control" value="{{old('s_id',$school->school_identification_number)}}" name="s_id" class="mb-4"  required="" autofocus="">

                      <label>School Identification Number<span class="red">*</span></label>

                    </div>

                    @error('s_id')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>



                  <div class="s_form_button text-center">

                      <a  href="{{url('/schools')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                      <button type="submit" class="btn save_btn">Update</button>

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

}, 30000);

</script> 

@endsection