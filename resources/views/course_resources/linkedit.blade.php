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

                <li class = "active">Edit Link</li>

              </ol>

            </div>

            <div class="assignment">

              <div class="card-header main_ac">

                <h3>Edit</h3>

                <div class="ac_add_form">

        <form action="{{url('/linkupdate')}}" method="post" enctype="multipart/form-data" class="w-100">

                  <div class="row">

                  

                      {{@csrf_field()}}

                      @foreach ($errors->all() as $error)

                      <div class="alert alert-danger">{{ $error }}</div>

                      @endforeach

                      <input type="hidden" name="id" value="{{$id}}">

                      <input type="hidden" name="course_id" value="{{$course_id}}"> 
                      <input type="hidden" name="instructor_id" value="{{$instructor_id}}"> 
                      <input type="hidden" name="week" value="{{$week}}"> 

                    <div class="col-md-6 p_left">

                      <div class="custom_input_main">

                        <input type="text" class="form-control" value="{{old('title', $courselinks->title)}}" name="title" required="" minlength="3" maxlength ="50" autofocus="" required="">

                        <label>Title <span class="red">*</span></label>

                      </div>

                          @error('title')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                      </div>
                      
                      <div class="col-md-6 p_right">

                      <div class="custom_input_main">

                        <input class="form-control" type="text" name="link" value={{old('link', $courselinks->link)}} minlength="1" maxlength ="100" required="">

                        <label>Link <span class="red">*</span></label>

                      </div>

                          @error('link')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                    </div>

                    <div class="col-md-12">

                      <div class="custom_input_main">

                        <textarea class="form-control" name="short_des" rows="4" cols="50" value="{!!old('short_des',$courselinks->short_description)!!}" minlength="10" maxlength ="1000" style="height: 100px !important;" required="">
                        
                        {{old('short_des',$courselinks->short_description)}}
                        
                        </textarea>

                        <label>Link description<span class="red">*</span></label>

                      </div>

                          @error('short_des')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                      </div>

                         <div class="form-check">
                              <input type="checkbox" name="send_notification"><label> Check to Send Notification for Resource Updates.</label>   
                            </div>
                    

                    <div class="col-md-12">

                      <div class="s_form_button text-center">

                        <a  href="{{url('/course/show_week_details/'. $instructor_id .'/'. $course_id .'/'. $week)}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                        <button type="submit" class="btn save_btn">Update<div class="ripple-container"></div></button>

                      </div>

                    </div>

                    

                  </div>
                  
                  </form>

                </div>

              </div>

            </div>

          </div>



 @endsection









