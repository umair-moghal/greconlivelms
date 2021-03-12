@extends('layouts.app')

@section('content')   

  <div class="breadcrumb_main">

    <ol class="breadcrumb">

      <li><a href = "{{url('/dashboard')}}">Home</a></li>

      <li class = "active">Edit Department</li>

    </ol>

  </div>

  <div class="assignment">

    <div class="card-header main_ac">

      <h3>Edit Department</h3>

      <div class="ac_add_form">

        @foreach ($errors->all() as $error)

          <div class="alert alert-danger">{{ $error }}</div>

        @endforeach

        <form method="POST" action="{{url('/departments/edit/'.$department->id)}}" enctype="multipart/form-data">

          @csrf

          @method('PUT')

          <div class="row">

            <div class="col-md-6 p_left">

              <div class="custom_input_main">

                <input type="text" name="name" class="form-control" value="{{old('name', $department->name)}}" required minlength="1" maxlength="100">

                <label for="name">Name <span class="red">*</span></label>

              </div>

            </div>

            <div class="col-md-12">

              <div class="s_form_button text-center">

                <a href="{{url('/departments')}}" class="btn cncl_btn">Cancel</a>

                <button type="submit" class="btn save_btn">Save<div class="ripple-container"></div></button>

              </div>

            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

@endsection