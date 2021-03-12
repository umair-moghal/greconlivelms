@extends('layouts.app')
@section('content')
<div class="breadcrumb_main">
  <ol class="breadcrumb">
    <li><a href = "{{url('/dashboard')}}">Home</a></li>
    <li><a href = "#">Quizzes/Tests</a></li>
    <li class = "active">Add Quizzes/Tests</li>
  </ol>
</div> 
<div class="content_main">
  <div class="card-header assesment_main">
    <h3>Add Quizzes/Tests</h3>
    <div class="main_quiz">
      <div class="quiz_tabs">
        <ul class="nav nav-tabs ">
          <li class="quiz_tab_link active">
            <a href="{{url('/mcq/create')}}">
            Multiple Choice </a>
          </li>
          <li class="quiz_tab_link second">
            <a href="{{url('/tf/create')}}">
            True/False </a>
          </li>
          
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_default_1">
            <div class="quiz_head">
              <h5>Question -1</h5>
              <div class="quiz_form">
                <div class="custom_input_main remove_ex_margin">
                  <textarea class="form-control" style="height: 100px !important;"> </textarea>
                  <label>Topic <span class="red">*</span></label>
                </div>
              </div>
              <div class="qa_quiz">
                <div class="row">
                  <div class="col-md-10 p_left">
                    <div class="quiz_op">
                      <h4>Options</h4>
                    </div>
                    <div class="col-md-12">
                      <div class="custom_input_main mobile_field">
                        <input type="text" class="form-control" name=""  required="" autofocus="">
                        <label>Option - 1.
                          <span class="red">*</span></label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="custom_input_main mobile_field">
                        <input type="text" class="form-control" name=""  required="" autofocus="">
                        <label>Option - 2.
                          <span class="red">*</span></label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="custom_input_main mobile_field">
                        <input type="text" class="form-control" name=""  required="" autofocus="">
                        <label>Option - 3.
                          <span class="red">*</span></label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="custom_input_main mobile_field">
                        <input type="text" class="form-control" name=""  required="" autofocus="">
                        <label>Option - 4.
                          <span class="red">*</span></label>
                      </div>
                    </div>
                    <!-- <div class="custom_input_main select_plugin">
                      <select class="selectpicker">
                        <option>Magic</option>
                        <option>Macro Economics II</option>
                        <option>Macro Economics I</option>
                        <option>Finance 101</option>
                      </select>
                      <label class="select_lable">Option - 1  <span class="grey">*</span></label>
                    </div>
                    <div class="custom_input_main select_plugin">
                      <select class="selectpicker">
                        <option>Water</option>
                        <option>Macro Economics II</option>
                        <option>Macro Economics I</option>
                        <option>Finance 101</option>
                      </select>
                      <label class="select_lable">Option - 2  <span class="grey">*</span></label>
                    </div>
                    <div class="custom_input_main select_plugin">
                      <select class="selectpicker">
                        <option>Fire</option>
                        <option>Macro Economics II</option>
                        <option>Macro Economics I</option>
                        <option>Finance 101</option>
                      </select>
                      <label class="select_lable">Option - 3  <span class="grey">*</span></label>
                    </div> -->
                  </div>
                  <div class="col-md-2 p_right">
                    <div class="quiz_ans">
                      <h4>Answer</h4>
                    </div>
                    <div class="cr_btn">
                      <button type="button" class="btn">Correct</button>
                    </div>
                    <div class="cr_btn active_cr_btn">
                      <button type="button" class="btn">Correct</button>
                    </div>
                    <div class="cr_btn">
                      <button type="button" class="btn">Correct</button>
                    </div>
                    <div class="cr_btn">
                      <button type="button" class="btn">Correct</button>
                    </div>
                  </div>
                  <div class="save_next_btn text-center w-100">
                  <button type="button" class="btn">Save and next</button>
                </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab_default_2">
            <div class="quiz_head">
              <h5>Question -1</h5>
              <div class="quiz_form">
                <div class="custom_input_main remove_ex_margin">
                  <textarea class="form-control" style="height: 100px !important;"> </textarea>
                  <label>Topic <span class="red">*</span></label>
                </div>
              </div>
              <div class="answers_tf">
                <h5>Answer</h5>
                <div class="true_false_btns">
                  <button type="button" class="btn true_btn active_tf_btn">True</button>
                  <button type="button" class="btn false_btn add_margin_to_f">False</button>
                </div>
              </div>
              <div class="save_next_btn text-center w-100">
                  <button type="button" class="btn">Save and next</button>
                </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
@endsection