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

    <li class = "active">Edit Instructor</li>

  </ol>

</div>

<div class="content_main">

  <div class="profile_main">

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3 class="main_title_ot">Edit Instructor</h3>

        <div class="tab-content">

             <form class="form-horizontal" method="POST" action="{{ url('/instructors/edit/'. $instructor->id) }}" enctype="multipart/form-data">

                    @csrf

                @foreach ($errors->all() as $error)

                          <div class="alert alert-danger">{{ $error }}</div>

                        @endforeach

              <div class="tab-pane active" id="tab_default_3">

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{old('name',$instructor->name)}}"  name="name" required="" minlength="3" maxlength ="50" autofocus="">

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

                      <input type="email" class="form-control" name="email"value="{{old('email',$instructor->email)}}"  required maxlength="255" readonly autofocus="">

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

                      <input type="file" name="image" value="{{old('image',$instructor->image)}}"  class="mb-4" accept="image/x-png,image/gif,image/jpeg" autofocus="">

                      <label>Image<span class="red">*</span></label>

                      <img src="{{asset('/assets/img/upload/'.$instructor->image)}}" width="50" alt="" class="img-fluid">

                    </div>

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <select required="required" class="form-control" name="role">

                          <option value="4">Instructor</option>

                      </select>

                      <label>Role<span class="red">*</span></label>

                    </div>

                  </div>

                <div class="col-md-12 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="tell" class="form-control" name="phno" value="{{old('phno',$instructor->phone)}}" required="" autofocus="">

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

                      <input type="hidden" class="form-control" value="2323223" name="cnic"class="mb-4"   autofocus="">

                    </div>

                    @error('cnic')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 p_right">

                    <div class="custom_input_main mobile_field">

                      <input type="hidden" class="form-control" value="adddd"  name="add" class="mb-4"  minlength="3" maxlength ="200" autofocus="">

                      

                    </div>

                    @error('address')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message}}</strong>

                      </span>

                    @enderror

                  </div>



                  <div class="s_form_button text-center">

                      <a  href="{{url('/instructors')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

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