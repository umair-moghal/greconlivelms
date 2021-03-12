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

                <li class = "active">Add Excel sheet sample</li>

              </ol>

            </div>

            <div class="assignment">

              <div class="card-header main_ac">

                <h3>Add excel sheet sample</h3>

                <div class="ac_add_form">

                      @foreach ($errors->all() as $error)

                        <div class="alert alert-danger">{{ $error }}</div>

                      @endforeach

                <form action="{{url('/add_student_sample')}}" method="POST" enctype="multipart/form-data" class="w-100">

                  <div class="row">

                   

                      {{@csrf_field()}}

                    



                      <div class="col-md-6 p_right">

                      <div class="file_spacing">

                        <input id="file" class="choose" type="file" name="file" autofocus="" size="max:10240" required="" accept=".xlsx">

                      </div>

                          @error('file')

                          <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                          </span>

                          @enderror

                    </div>


                      </div>

                    

                    <div class="col-md-12">

                      <div class="s_form_button text-center">

                        <a  href="{{url('/add_student_sample')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                        <button type="submit" class="btn save_btn">Save<div class="ripple-container"></div></button>

                      </div>

                    </div>

    </div>

                    </form>

                  

                </div>

              </div>

            </div>

          </div>
 
<script type="text/javascript">

  setTimeout(function() {

    $('#message').fadeOut('fast');

}, 2000);

</script> 
@endsection