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

                <li class = "active">Edit File</li>

              </ol>

            </div>

            <div class="assignment">

              <div class="card-header main_ac">

                <h3>Add file</h3>

                <div class="ac_add_form">

                <form action="{{ url('/special_education/edit/'. $special_education->id) }}" method="POST" enctype="multipart/form-data" class="w-100">

                  <div class="row">

                   

                      {{@csrf_field()}}

                      @foreach ($errors->all() as $error)

                      <div class="alert alert-danger">{{ $error }}</div>

                      @endforeach

                      <div class="col-md-12">

                      <div class="file_spacing">

                        <input id="file" class="choose" type="file" name="file" value="{{old('file',$special_education->upload_file)}}" accept=".doc,.docx,.pptx,.xlsx,.txt,application/pdf,application/vnd.ms-excel/application/vnd.ms-docx/*" autofocus="" size="max:10240" required="">

                      </div>

                          {{-- @error('file')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror --}}

                      </div>

                    <div class="col-md-12">

                      <div class="custom_input_main">

                        <textarea class="form-control" name="comments" rows="4" cols="50" value="{{old('comments',$special_education->parent_comments)}}" minlength="10" maxlength ="255" style="height: 100px !important;" required="">{{$special_education->parent_comments}}</textarea>

                        <label>Notes<span class="red">*</span></label>

                      </div>
<!-- 
                          @error('Text')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror -->

                      </div>


                    

                   

                    <div class="col-md-12">

                      <div class="s_form_button text-center">

                      

                        <button type="submit" class="btn save_btn">Save<div class="ripple-container"></div></button>

                      </div>

                    </div>

                </div>

                    </form>

                  

                </div>

              </div>

            </div>

          </div>

          @endsection