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

                <li class = "active">Add New Greeting</li>

              </ol>

            </div>

            @foreach ($errors->all() as $error)

                    <div class="alert alert-danger">{{ $error }}</div>

                    @endforeach

            <div class="assignment">

              <div class="card-header main_ac">

                <h3>Add Greeting</h3>

                <div class="ac_add_form">

                {{-- @dd($greeting); --}}

                    

                    <form action="{{url('/greetings/edit', $greeting->id)}}" method="POST" enctype="multipart/form-data" class="w-100">
                     @csrf
                     
                     <div class="row">

                      

                     <div class="col-md-6 p_left">

                      <div class="custom_input_main">

                        <input type="text" class="form-control" value="{{ old('title', $greeting->title)}}" name="title" required="" minlength="3" maxlength ="50" autofocus="">

                        <label>Title <span class="red">*</span></label>

                      </div>

                          @error('title')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                    </div>

                    <div class="col-md-6 p_right">

                        <div class="file_spacing">

                            <input type="file" class="choose" name="image" accept="image/x-png,image/gif,image/jpeg" size="max:255">
                        </div>

                          {{-- @error('image')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror --}}

                    </div>

                    <div class="col-md-12">

                      <div class="custom_input_main">

                          <input name="description" cols="8" value="{!!old('description', $greeting->description)!!}" class="form-control" required="" minlength="3" maxlength ="255">
                      
                          <label>Description<span class="red">*</span></label>

                      </div>

                          @error('description')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                      </div>




                    <div class="col-md-12">

                      <div class="s_form_button text-center">

                        <a  href="{{url('/greetings/index')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                        <button type="submit" class="btn save_btn">Save<div class="ripple-container"></div></button>

                      </div>

                    </div>
                    </div>
                    
                    </form>

                  </div>

                </div>

              </div>

            </div>

          </div>


@endsection

