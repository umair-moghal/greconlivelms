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

                <li class = "active">Course Syllabus</li>

              </ol>

            </div>

            <div class="assignment">

              <div class="card-header main_ac">

                <h3>Upload Syllabus</h3>

                <div class="ac_add_form">

                @foreach ($errors->all() as $error)

                  <div class="alert alert-danger">{{ $error }}</div>

                @endforeach

                  <form action="{{url('/upload_syllabus/update', $syllabus->id)}}" method="POST" enctype="multipart/form-data" class="w-100">

                    <div class="row">

                     

                        {{@csrf_field()}}

                      

                        <div class="col-md-6 p_right">

                          <div class="file_spacing">

                            <input id="file" class="choose" type="file" name="file" value="{{old('file', $syllabus->document)}}" accept=".doc,.docx,.pptx,.xlsx,.txt,application/pdf,application/vnd.ms-excel/application/vnd.ms-docx" autofocus="" size="max:10240" >
                            
<a  target="_blank" href="{{asset('/assets/img/documents/'.$syllabus->document)}}">View/Download</a>
                          </div>

                            @error('file')

                            <span class="invalid-feedback" role="alert">

                            <strong>{{ $message }}</strong>

                            </span>

                            @enderror

                      </div>

                      <div class="col-md-12">

                        <div class="custom_input_main">

                          <textarea name="desc" cols="8" id="txtEditor" value="{!! old('desc') !!}" style="height: 35px;width: 100%;" required="">
                              {!! old('desc', $syllabus->description) !!}
                          </textarea>

                          <label>Syllabus<span class="red">*</span></label>

                        </div>

                            @error('desc')

                            <span class="invalid-feedback" role="alert">

                            <strong>{{ $message }}</strong>

                            </span>

                            @enderror

                        </div>

                        </div>

                        <div class="form-check">
                              <input type="checkbox" name="send_notification"><label> Check to Send Notification for Resource Updates.</label>   
                            </div>
                      

                        <div class="col-md-12">

                          <div class="s_form_button text-center">

                            <a  href="{{url('/course')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                            <button type="submit" class="btn save_btn">Update<div class="ripple-container"></div></button>

                          </div>

                        </div>


                  </form>

                  

                </div>



              </div>

            </div>

          </div>


          
 

<script>

  var uploadField = document.getElementById("file");

  uploadField.onchange = function() {

      if(this.files[0].size > 100 * 1024 * 1024){

        alert("File is too big!");

        this.value = "";

      };

  };



</script>







  



  <script src="{{url('backend/sweetalerts/sweetalert2.all.js')}}"></script>
  
  <script type="text/javascript">

    setTimeout(function() {

      $('#message').fadeOut('fast');

    }, 30000);

  </script>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>

  CKEDITOR.replace( 'txtEditor' );

</script>
<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

</script>




@endsection