@extends('layouts.app')
@section('content')
  <div class="breadcrumb_main">
    <ol class="breadcrumb">
      <li><a href = "{{asset('/dashboard')}}">Home</a></li>
      <li class = "active">Add New Icon</li>
    </ol>
  </div>
  <div class="assignment">
    <div class="card-header main_ac">
      <h3>Add New Icon</h3>
      <div class="ac_add_form">
        @foreach ($errors->all() as $error)
          <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
        <form action="{{url('/createicon')}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 p_left">
                      <div class="custom_input_main">
                        <input type="text" class="form-control" value="{{ old('title')}}" name="title" required="" minlength="3" maxlength ="50" autofocus="">
                        <label>Title <span class="red">*</span></label>
                      </div>
                          @error('title')
                          <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                      </div><br>
            <div class="col-md-6 p_left">
              <div class="file_spacing">
                <input type="file" class="choose" name="image" accept="image/x-png,image/gif,image/jpeg" size="max:255"required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="s_form_button text-center">
                <a href="{{url('/viewicon')}}" class="btn cncl_btn">Cancel</a>
                <button type="submit" class="btn save_btn">Save<div class="ripple-container"></div></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
 @endsection