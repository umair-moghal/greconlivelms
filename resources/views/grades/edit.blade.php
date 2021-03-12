@extends('layouts.app')
@section('content')   
  <div class="breadcrumb_main">
    <ol class="breadcrumb">
      <li><a href = "{{asset('/dashboard')}}">Home</a></li>
      <li class = "active">Edit Grade</li>
    </ol>
  </div>
  <div class="assignment">
    <div class="card-header main_ac">
    	 @if (Session::has('message'))

		    <div class="alert alert-info">

		      {{ Session::get('message') }}

		    </div>

		  @endif
      <h3>Edit Grade</h3>
      <div class="ac_add_form">
        @foreach ($errors->all() as $error)
          <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
        <form method="POST" action="{{url('/updategrades/'. $grade->id)}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="custom_input_main">
                <input class="form-control" type="number" min="0" step="1" name="from" value="{{old('from', $grade->marks_from)}}" required autofocus="">

                <label>Marks From<span class="red">*</span></label>
              </div>
            </div>

            <div class="col-md-12">
              <div class="custom_input_main">
                <input class="form-control" type="number" min="0" step="1" name="to" value="{{old('to', $grade->marks_to)}}" required autofocus="">

                <label>Marks To<span class="red">*</span></label>
              </div>
            </div>

            <div class="col-md-12">

              <div class="custom_input_main select_plugin mobile_field">

                <select class="selectpicker" name="grade">

                  <option   @if($grade->grade == 'A+') Selected @endif  value="A+">A+</option>
                  <option   @if($grade->grade == 'A') Selected @endif  value="A">A</option>
                  <option   @if($grade->grade == 'B+') Selected @endif  value="B+">B+</option>
                  <option   @if($grade->grade == 'B') Selected @endif  value="B">B</option>
                  <option   @if($grade->grade == 'C+') Selected @endif  value="C+">C+</option>
                  <option   @if($grade->grade == 'C') Selected @endif  value="C">C</option>
                  <option   @if($grade->grade == 'D+') Selected @endif  value="D+">D+</option>
                  <option   @if($grade->grade == 'D') Selected @endif  value="D">D</option>
                  <option   @if($grade->grade == 'F') Selected @endif  value="F">F</option>

                </select>

                <label class="select_lable">Grade</label>

              </div>

            </div>
            
            <div class="col-md-12">
              <div class="s_form_button text-center">
                <a href="/course" class="btn cncl_btn">Cancel</a>
                <button type="submit" class="btn save_btn">Update<div class="ripple-container"></div></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection