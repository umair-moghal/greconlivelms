@extends('layouts.app')
@section('content')

<?php  



  ?>

<div class="content">
          <div class="container-fluid">
           
            <div class="breadcrumb_main">
              <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Messages</li>
              </ol>
            </div>
            <div class="content_main">
              <div class="profile_main">
                
                <div class="profile mt-0">
                  <div class="course card-header card-header-warning card-header-icon">
                    
                    <h3 class="main_title_ot">Messages</h3>
                    
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
                                <li class="active profile_tabs_child">
                                  <a href="{{url('/messages')}}">
                                    Messages 
                                  </a>
                                </li>
                                <li class="profile_tabs_child">
                                  <a href="{{url('/editprofile')}}">
                                    Settings 
                                  </a>
                                </li>
                              </ul>
                              <div class="tab-content">
                            
                                <div class="tab-pane active" id="tab_default_2">
                                  <div class="row">
                                    <div class="col-md-7 chat-area">
                                      <div class="chatbox-holder">
                                        <div class="chatbox">
                                          <p>Welcome to messages area. Click to any person to start chat :-)</p>

                                        </div>
                                      </div>
                                    </div>
                                  
                                      @if(Auth::user()->role_id == '4')
                                      {{-- schools --}}
                                        @foreach($school_instructors as $ins_std)
                                            <div class="msg_listing" id="{{$ins_std->id}}">
                                              <div class="msg_styling" onclick="window.location.href = '#msg_bottom';" style="cursor: pointer;">
                                                <div class="msg_img">
                                                  <div class="msg_list_img">
                                                    <img src="{{'/assets/img/upload/'.$ins_std->image}}" alt="">
                                                  </div>
                                                  <div class="msg_name">
                                                    <h5>{{$ins_std->name}}  (School)</h5>
                                                    <p>{{$ins_std->email}}</p>
                                                  </div>
                                                </div>
                                                <div class="msg_time">
                                                  {{-- <p>2:12 PM</p> --}}
                                                </div>
                                              </div>
                                              <p class="s_msg">{{$ins_std->bio}}</p>
                                            </div>
                                        @endforeach


                                      {{-- Students --}}
                                        @foreach($instructor_students as $ins_std)
                                            <div class="msg_listing" id="{{$ins_std->id}}">
                                              <div class="msg_styling" onclick="window.location.href = '#msg_bottom';" style="cursor: pointer;">
                                                <div class="msg_img">
                                                  <div class="msg_list_img">
                                                    <img src="{{'/assets/img/upload/'.$ins_std->image}}" alt="">
                                                  </div>
                                                  <div class="msg_name">
                                                    <h5>{{$ins_std->name}}  (student)</h5>
                                                    <p>{{$ins_std->email}}</p>
                                                  </div>
                                                </div>
                                                <div class="msg_time">
                                                  {{-- <p>2:12 PM</p> --}}
                                                </div>
                                              </div>
                                              <p class="s_msg">{{$ins_std->bio}}</p>
                                            </div>
                                        @endforeach

                                      @elseif(Auth::user()->role_id == '5')
                                        @foreach($instructors as $ins)
                                            <div class="msg_listing" id="{{$ins->id}}">
                                              <div class="msg_styling" onclick="window.location.href = '#msg_bottom';" style="cursor: pointer;">
                                                <div class="msg_img">
                                                  <div class="msg_list_img">
                                                    <img src="{{'/assets/img/upload/'.$ins->image}}" alt="">
                                                  </div>
                                                  <div class="msg_name">
                                                    <h5>{{$ins->name}} (Instructor)</h5>
                                                    <p>{{$ins->email}}</p>
                                                  </div>
                                                </div>
                                                <div class="msg_time">
                                                  {{-- <p>2:12 PM</p> --}}
                                                </div>
                                              </div>
                                              <p class="s_msg">{{$ins->bio}}</p>
                                            </div>
                                        @endforeach
                                        @elseif(Auth::user()->role_id == '3')
                                        
                                         @foreach($school_instructors as $ins)
                                            <div class="msg_listing" id="{{$ins->id}}">
                                              <div class="msg_styling" onclick="window.location.href = '#msg_bottom';" style="cursor: pointer;">
                                                <div class="msg_img">
                                                  <div class="msg_list_img">
                                                    <img src="{{'/assets/img/upload/'.$ins->image}}" alt="">
                                                  </div>
                                                  <div class="msg_name">
                                                    <h5>{{$ins->name}} (Instructor)</h5>
                                                    <p>{{$ins->email}}</p>
                                                  </div>
                                                </div>
                                                <div class="msg_time">
                                                  {{-- <p>2:12 PM</p> --}}
                                                </div>
                                              </div>
                                              <p class="s_msg">{{$ins->bio}}</p>
                                            </div>
                                        @endforeach
                                      @endif
                                      

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
                <span aria-hidden="true" class="cross_btn">×</span>
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

      
    </div>
@endsection