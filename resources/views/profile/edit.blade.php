@extends('layouts.app')

@section('content')

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "#">Home</a></li>

    <li class = "active">Profile</li>

  </ol>

</div>  

<div id="message">

  @if (Session::has('message'))

    <div class="alert alert-info">

      {{ Session::get('message') }}

    </div>

  @endif

</div>

<div class="content_main">

  <div class="profile_main">

     @foreach ($errors->all() as $error)

              <div class="alert alert-danger">{{ $error }}</div>

          @endforeach

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3 class="main_title_ot">Profile</h3>

        

        <div class="profile_tabs">

          <div class="row">

            <div class="col-md-12">

              <div class="tabbable-panel">

                <div class="tabbable-line">

                  <ul class="nav nav-tabs ">

                    <li class="profile_tabs_child">

                      <a href="{{url('/showprofile')}}" >

                      Profile </a>

                    </li>

                    <li class="profile_tabs_child">

                      <a href="{{url('/messages')}}">

                      Messages </a>

                    </li>

                    <li class="active profile_tabs_child">

                      <a href="{{url('/editprofile')}}">

                      Settings </a>

                    </li>

                  </ul>



                  <div class="tab-content">

                  <form method="POST" action="{{url('updateprofile',Auth::user()->id)}}" enctype="multipart/form-data">

                    @csrf

                    <div class="tab-pane active" id="tab_default_3">

                      <div class="s_profile">

                        <div class="s_profile_img text-center">

                          <div class="child_image">

                            <img src="{{asset('assets/img/upload/'.$user->image)}}" alt="" id="upfile1">

                            <div class="s_edit_pic">

                              <input type="file" id="imgupload" name="image" accept="image/x-png,image/gif,image/jpeg" capture style="display:none"/>

                              <a id="OpenImgUpload"> <i class="fa fa-pencil"></i> </a>

                            </div>

                          </div>

                        </div>

                      </div>

                      <div class="s_profile_fields">

                        <div class="row">

                          <div class="col-md-6">

                            <div class="custom_input_main mobile_field">

                              <input type="text" class="form-control" name="name" autofocus="" value="{{$user->name}}">

                              <label>Name <span class="red">*</span></label>

                            </div>

                          </div>

                          <div class="col-md-6">

                            <div class="custom_input_main mobile_field">

                              <input type="text" class="form-control" name="email" value="{{$user->email}}" placeholder="{{$user->email}}" readonly>

                              <label>Email <span class="grey"></span></label>


                            </div>

                          </div>

                          <div class="col-md-6">

                            <div class="custom_input_main mobile_field">

                              <input type="tel" class="form-control" name="contact" value="{{$user->contact}}" required="" minlength="12" maxlength = "12">

                              <label>Mobile <span class="grey">*</span></label>

                            </div>

                          </div>

                        </div>

                        <div class="row">

                          <div class="col-md-12">

                            <div class="custom_input_main">

                              <textarea class="form-control" name="bio" value="{{old('bio', $user->bio)}}" style="height: 115px !important;"> {{$user->bio}}</textarea>

                              <label>Bio <span class="grey"></span></label>

                            </div>

                          </div>

                        </div>

                        <div class="security_setting">

                          <h3>Security Settings</h3>

                          <div class="row">

                            <div class="col-md-12">

                              <div class="custom_input_main">

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="oldpassword"  autocomplete="new-password">

                                @error('oldpassword')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                                <label>Old Password</label>

                              </div>

                            </div>

                            <!-- <div class="col-md-6">

                              <div class="custom_input_main">

                                <input type="text" class="form-control" value="{{$user->password}}" placeholder="***************">

                                <label>Old Password<span class="grey">*</span></label>

                              </div>

                            </div> -->

                            <div class="col-md-6">

                              <div class="custom_input_main">

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                                @error('password')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                                <label>New Password</label>

                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="custom_input_main">

                                <input id="password-confirm" type="password" class="form-control"  name="password_confirmation" autocomplete="new-password">

                                <label>Confirm New Password</label>

                              </div>

                            </div>

                          </div>

                          <div class="s_form_button text-center">

                            <a href="/showprofile"><button type="button" class="btn cncl_btn">Cancel</button></a>

                            <button type="submit" class="btn save_btn">Save</button>

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

      </div>

    </div>

  </div>

</div>

</div>

</div>



        <!-- // Modal /// -->



<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

<div class="modal-dialog modal-dialog-centered" role="document">

  <div class="modal-content">

    <div class="cross_modal">

      <div class="modal_title">

        <h3>Edit Mobile No.</h3>

      </div>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">

        <span aria-hidden="true" class="cross_btn">&times;</span>

      </button>

    </div>

    <div class="modal-body">

     <div class="custom_input_main">

        <input type="text" class="form-control" placeholder="(132) 11425 4521">

        <label>Mobile <span class="grey">*</span></label>

      </div>

      <div class="s_form_button">

        <button type="button" class="btn cncl_btn">Cancel</button>

        <button type="button" class="btn save_btn">Save</button>

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

<script type="text/javascript">

  $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });

</script>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#upfile1').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgupload").change(function(){
        readURL(this);
    });
</script>



@endsection