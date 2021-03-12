
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

    <li class = "active">Edit Sub Admin</li>

  </ol>

</div>

<div class="content_main">

  <div class="profile_main">

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3 class="main_title_ot">Edit Sub Admin</h3>

        <div class="tab-content">
        @foreach ($errors->all() as $error)

              <div class="alert alert-danger">{{ $error }}</div>

            @endforeach
 
            

            

            <div class="tab-pane active" id="tab_default_3">

              <div class="s_profile_fields">

              <form action="{{url('/subadmin/edit', $sbadmn->id)}}" method="POST" enctype="multipart/form-data" class="w-100">

              @csrf

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{old('sa_name', $sbadmn->name)}}" name="sa_name" required="" minlength="3" maxlength ="50" autofocus="">

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

                      <input type="email" class="form-control" name="email" value="{{old('email', $sbadmn->email)}}" required maxlength="255"autofocus="">

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

                        <input type="tell" class="form-control" name="contact" value="{{ old('contact', $sbadmn->contact)}}" placeholder="xxxx-xxxxxxx" pattern="03[0-9]{2}-(?!1234567)(?!1111111)(?!7654321)[0-9]{7}" required="" minlength="12" maxlength = "12" autofocus="">

                        <label>Contact<span class="red">*</span></label>

                    </div>

                        @error('contact')

                        <span class="invalid-feedback" role="alert">

                        <strong>{{ $message }}</strong>

                        </span>

                        @enderror

                </div>                  

                  {{-- <div class="col-md-6 p_left">

                      <div class="file_spacing">

                        <input id="file" class="choose" type="file" name="image" accept="image/*" required="" autofocus="" size="max:1024" required=""> 

                      </div>

                          @error('image')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                    </div> --}}

                  <div class="col-md-6 p_right">

                  <div class="file_spacing">

                      <input type="file" name="image" class="choose" value="{{old('image',$sbadmn->image)}}" accept="image/*" autofocus="">

                      <label>Image<span class="red">*</span></label>

                      <img src="{{asset('/assets/img/upload/'.$sbadmn->image)}}" width="50" alt="" class="img-fluid">

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

                      <input type="text" class="form-control" value="{{ old('details', $sbadmn->bio)}}" name="details" required="" minlength="3" maxlength ="255" autofocus="">

                      <label>Details<span class="red">*</span></label>

                    </div>

                    <!-- @error('Details')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror -->

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

  setTimeout(function() {

    $('#message').fadeOut('fast');

}, 2000);

</script>   

@endsection