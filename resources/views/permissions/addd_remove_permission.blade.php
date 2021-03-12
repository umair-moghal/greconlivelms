@extends('layouts.app')

@section('content')



<style>

.switch {

  position: relative;

  display: inline-block;

  width: 60px;

  height: 34px;

}



.switch input { 

  opacity: 0;

  width: 0;

  height: 0;

}



#size{

    margin-left: 58px;

    width: 168px;

    padding: 3px;

}



.slider {

  position: absolute;

  cursor: pointer;

  top: 0;

  left: 0;

  right: 0;

  bottom: 0;

  background-color: #222d32;

  -webkit-transition: .4s;

  transition: .4s;

}

input:checked + .slider {

    background-color: #3366cc !important;

}

.slider:before {

  position: absolute;

  content: "";

  height: 26px;

  width: 26px;

  left: 4px;

  bottom: 4px;

  background-color: white;

  -webkit-transition: .4s;

  transition: .4s;

}



input:checked + .slider {

  background-color: #2196F3;

}



input:focus + .slider {

  box-shadow: 0 0 1px #2196F3;

}



input:checked + .slider:before {

  -webkit-transform: translateX(26px);

  -ms-transform: translateX(26px);

  transform: translateX(26px);

}



/* Rounded sliders */

.slider.round {

  border-radius: 34px;

}



.slider.round:before {

  border-radius: 50%;

}

.max-spec {

    font-size:14px;

}

.card-body-form {

    width: 100%;

}

.form-group {

     display: block; 

     flex-direction: column; 

}

.form-btn a , .form-btn button {

  font-size: 18px;



}

.add_color {

      background: #3366cc;

    font-size: 19px;

    color: #fff !important;

}

</style>

<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li class = "active">All Schools</li>

  </ol>

</div>

<div id="message">

  @if (Session::has('message'))

    <div class="alert alert-info">

      {{ Session::get('message') }}

    </div>

  @endif

</div>

<div class="content_main">

  <div class="all_courses_main">

    

    <div class="course_table mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3>{{$title}}</h3>


@if ($errors->any())

    <div class="alert alert-danger">

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif





		<div class="row">

			<div class="col-lg-12">

				<div class="">

					<div class=" ">

						<!--<h3 class="h4">Add/Remove Permissions </h3>-->

					</div>

					<div class="" id="org-form">

						<div class="">

						    <?php   

						        if($page == 'school'){

						           $url = '/change/permission/school';    

						        }

						        elseif($page == 'instructor'){

						            $url = '/change/permission/instructor';

						        }

						       

						    ?>

						<form class="form-horizontal" method="POST"  action="{{ url($url) }}" enctype="multipart/form-data">

						{{ csrf_field() }}

              <table class="table">

              

              <tbody>

                <tr>

                  <th class="add_color">Modules</th>

                  <td class="add_color">Permission</td>

                @foreach($permissions as $total_permissions)

                    

                  <tr>

                 



                  <th>{{$total_permissions}}</th>

                  

                

                  <td>

                    <label class="switch">

                                <input name="permiss[]" value="{{$total_permissions}}"   @if(in_array($total_permissions, $granted_permissions) == true) checked="true" @endif type="checkbox">

                                <span class="slider round"></span>

                            </label>

                  </td>

                  

                </tr>

                 @endforeach

                </tr>

              </tbody>

            </table>


            <input id="file" type="hidden" class="form-control" name="id" value="{{$id}}">


								<div class="form-group row form-btn">


                  <div class="s_form_button text-center w-100">

                    <a href="{{ url()->previous() }}"><button type="button" class="btn cncl_btn">@lang('cancel')</button></a>

                    <button type="submit" class="btn save_btn">@lang('save')</button>

                  </div>

									</div>	

							</div>

							</form>

					</div>

				</div>

			</div>

		</div>


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