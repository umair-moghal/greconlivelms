@extends('layouts.app')
@section('content')
  <div class="breadcrumb_main">
    <ol class="breadcrumb">
      <li><a href = "{{asset('/dashboard')}}">Home</a></li>
      <li class = "active">Add New Discussion</li>
    </ol>
  </div>
  <div class="assignment">
    <div class="card-header main_ac">
      <h3>Add New Discussion</h3>
      <div class="ac_add_form">
        @foreach ($errors->all() as $error)
          <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
        <form method="POST" action="/discussions/create" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="custom_input_main">
                <input type="text" class="form-control" name="title" value="{{old('title')}}" required minlength="3" maxlength="255">
                <label for="title">Title <span class="red">*</span></label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="file_spacing">
                <input type="file" class="choose" name="image" accept="image/x-png,image/gif,image/jpeg" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="custom_input_main">
                <textarea class="form-control" name="description" style="height: 100px !important;" required minlength="10">{{old('description')}}</textarea>
                <label>Description...</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="s_form_button text-center">
                <a href="{{url('/discussions')}}" class="btn cncl_btn">Cancel</a>
                <button type="submit" class="btn save_btn">Save<div class="ripple-container"></div></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection