@extends('layouts.app')

@section('content')

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "/dashboard">Home</a></li>

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

    

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3 class="main_title_ot">Profile</h3>

        

        <div class="profile_tabs">

          <div class="row">

            <div class="col-md-12">

              <div class="tabbable-panel">

                <div class="tabbable-line">

                  <ul class="nav nav-tabs ">

                    <li class="active profile_tabs_child">

                      <a href="{{url('/showprofile')}}" >

                      Profile </a>

                    </li>

                    <li class="profile_tabs_child">

                      <a href="{{url('/messages')}}">

                      Messages </a>

                    </li>

                    <li class="profile_tabs_child">

                      <a href="{{url('/editprofile')}}">

                      Settings </a>

                    </li>

                  </ul>



                  <div class="tab-content">

                  

                    <div class="tab-pane active" id="tab_default_1">

                                  <div class="profile_row">

                                    <div class="row">

                                      <div class="col-md-3">

                                        <div class="p_img">

                                          <div class="p_img_edit">

                                            <img src="{{asset('assets/img/upload/'.$user->image)}}" alt="" class="img-fluid">

<!--                                             <div class="edit_pic">

                                              <form>

                                              <a> <i class="fa fa-pencil"></i> </a>

                                              </form>

                                            </div> -->

                                          </div>

                                          <h3>{{$user->name}}</h3>

                                          @php
                                             if (auth()->user()->role_id == 5) {
                                                $course_id = DB::table('course_students')->where('student_id',auth()->user()->id)->pluck('course_id')->first();

                                                $ins_id = DB::table('courses')->where('id',$course_id)->pluck('ins_id')->first();

                                                $school_id = DB::table('instructor_school')->where('i_u_id',$ins_id)->pluck('sch_u_id')->first();
                                               $school_name = DB::table('schools')->where('sch_u_id',$school_id)->pluck('school_name')->first();


                                            }
                                            elseif (auth()->user()->role_id == 4) {
                                               $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();
                                               $school_name = DB::table('schools')->where('sch_u_id',$school_id)->pluck('school_name')->first();
                                            }
                                          @endphp

                                          @if(isset($school_id))
                                            {{$school_name}}
                                          @endif

                                        </div>

                                      </div>

                                      <div class="col-md-3 d-flex align-items-center">

                                        <div class="p_mob">

                                          <div class="mobile_head">

                                            <h4>Mobile</h4>

                                            <p>{{$user->contact}}</p>

                                          </div>

                                          <div class="edit_mob">

                                            <a href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-pencil"></i></a>

                                          </div>

                                        </div>

                                      </div>

                                      <div class="col-md-3 d-flex align-items-center">

                                        <div class="p_email">

                                          <h4>Email</h4>

                                          <p>{{$user->email}}</p>

                                        </div>

                                      </div>

                                      <div class="col-md-3 d-flex align-items-center">

                                        <div class="p_id">

                                          <h4>ID</h4>

                                          <p>{{$user->unique_id}}</p>

                                        </div>

                                      </div>

                                    </div>

                                  </div>

                                  <div class="p_text">

                                   <p>{{$user->bio}}</p>

                                          

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

      <form method="POST" action="/updatecontact">

        @csrf

        <input type="hidden" name="id" value="{{$user->id}}">

        <div class="custom_input_main">

          <input type="tel" class="form-control" name="contact" value="{{$user->contact}}" placeholder="xxxx-xxxxxxx" pattern="03[0-9]{2}-(?!1234567)(?!1111111)(?!7654321)[0-9]{7}" required="" minlength="12" maxlength = "12">



          <label>Mobile <span class="grey">*</span></label>

        </div>

        <div class="s_form_button">

          <a href="/showprofile"><button type="button" class="btn cncl_btn">Cancel</button></a>

          <button type="submit" class="btn save_btn">Save</button>

        </div>

      </form>

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