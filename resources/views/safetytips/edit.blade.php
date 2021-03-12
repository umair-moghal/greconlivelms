@extends('layouts.app')
@section('content')
  <div class="breadcrumb_main">
    <ol class="breadcrumb">
      <li><a href = "{{url('/dashboard')}}">Home</a></li>
      <li class = "active">Edit Safety Tip</li>
    </ol>
  </div>  
  <div class="content_main">
    <div class="profile_main">
      <div class="profile mt-0">
        <div class="course card-header card-header-warning card-header-icon">
          <h3 class="main_title_ot">Edit Safety Tip</h3>
          <div class="tab-content">
            @foreach ($errors->all() as $error)
              <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
            <form method="POST" action="{{url('/safetytips/edit/'.$safetytip->id)}}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="tab-pane active" id="tab_default_3">
                <div class="s_profile_fields">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="custom_input_main mobile_field">
                        <input type="text" class="form-control" name="title" value="{{old('title', $safetytip->title)}}" autofocus="" required minlength="3" maxlength="50">
                        <label for="title">Enter title<span class="red">*</span></label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="custom_input_main mobile_field">
                        <textarea class="form-control" name="description" style="height: 115px !important;" required minlength="10">{{old('description', $safetytip->description)}}</textarea>
                        <label for="description">Enter Description <span class="red">*</span></label>
                      </div>
                    </div>
                  </div>
                  <div class="s_form_button text-center">
                    <a href="{{url('/safetytips')}}" class="btn cncl_btn">Cancel</a>
                    <button type="submit" class="btn save_btn">Save</button>
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