@extends('layouts.app')
@section('content')
  <div class="breadcrumb_main">
    <ol class="breadcrumb">
      <li><a href = "{{asset('/dashboard')}}">Home</a></li>
      <li class = "active">Edit Icon</li>
    </ol>
  </div>
  <div class="assignment">
    <div class="card-header main_ac">
      <h3>Edit Icon</h3>
      <div class="ac_add_form">
        @foreach ($errors->all() as $error)
          <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
        <form action="{{route('updateicon',[$data->id])}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 p_left">
              <div class="custom_input_main">
                <input type="text" class="form-control" name="title" value="{{old('title', $data->title)}}" required>
                <label>Title <span class="red">*</span></label>
              </div>
              <div class="file_spacing">
                <input type="file" class="choose" name="image" accept="image/x-png,image/gif,image/jpeg">
              </div>
            </div>
            {{-- <div class="col-md-6 text-center">
              <img src="{{asset('assets/img/icons/'.$data->image)}}" height="125" width="125">
            </div> --}}
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