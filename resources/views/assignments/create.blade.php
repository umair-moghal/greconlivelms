@extends('layouts.app')

@section('content')

<div class="breadcrumb_main">

              <ol class="breadcrumb">

                <li><a href = "{{url('/dashboard')}}">Home</a></li>

                <li><a href = "#">Assignments</a></li>

                <li class = "active">Add Assignment</li>

              </ol>

            </div>

            <div class="content_main">

              <div class="card-header assesment_main">

                <h3>Add Assignment</h3>

                <div class="add_asses">

                  <h5>Assignment</h5>

                  <div class="ass_assess_from">

                    <div class="custom_input_main">

                      <textarea class="form-control" style="height: 100px !important;"> </textarea>

                      <label>Topic <span class="red">*</span></label>

                    </div>

<!--                     <div class="custom_input_main select_plugin">

                      <select class="selectpicker">

                        <option>Statistics</option>

                        <option>Macro Economics II</option>

                        <option>Macro Economics I</option>

                        <option>Finance 101</option>

                      </select>

                      <label class="select_lable">Course <span class="red">*</span></label>

                    </div> -->

                    <div class="s_form_button text-center">

                        <button type="button" class="btn cncl_btn">Cancel</button>

                        <button type="button" class="btn save_btn">Save<div class="ripple-container"></div></button>

                      </div>

                  </div>

                </div>

              </div>

            </div>

@endsection