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

    <li class = "active">Add New Student</li>

  </ol>

</div>
<div class="w-100">
   <?php    $error_mess = explode(';',session('question_import_error')); 
                 if(count($error_mess) >0) {
                  foreach($error_mess as $errmess){
                            if(strlen($errmess) < 3){
                                continue;
                            }
                            ?>   


                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  {!! $errmess !!}  
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                                  
                           <!--      <div class="alert alert-danger" style="width: 100%"> 
                                            {!! $errmess !!}  
                                        </div> -->

                             <?php
                  }
              }

         ?>
  </div>

<div class="content_main">

  <div class="profile_main">

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <div class="align_modal d-flex align-items-center justify-content-between">
          <h3 class="main_title_ot">Upload New Student</h3>




          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Import Excel File
          </button>
        </div>

       

        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: 600;">Import Students</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       {{--model body  --}}
           <div class="align_stu">
                    <form method="POST" class="w-100" action="/import_file_students" enctype="multipart/form-data">
                    @csrf
                      <div class="upload_stu">
                        <input type="file" name="select_file" accept=".xlsx" required="" style="padding: 10px 0;">
                        {{-- <input type="submit" name="upload" class="btn btn-primary" value="Upload"> --}}
                      </div>

                      <div class="row mt-5">
                        
                          <div class="col-md-6 ">

                    <div class="custom_input_main select_plugin mobile_field">

                    <select class="selectpicker" required="" name="grade_level">

                      <option value="1st Grade(Elementary)">1st Grade(Elementary)</option>

                      <option value="2nd Grade(Elementary)">2nd Grade(Elementary)</option>

                      <option value="3rd Grade(Elementary)">3rd Grade(Elementary)</option>

                      <option value="4th Grade(Elementary)">4th Grade(Elementary)</option>

                      <option value="5th Grade(Elementary)">5th Grade(Elementary)</option>

                      <option value="6th Grade(Elementary)">6th Grade(Elementary)</option>

                      <option value="7th Grade(Middle)">7th Grade(Middle)</option>

                      <option value="8th Grade(Middle)">8th Grade(Middle)</option>

                      <option value="9th Grade(Highschool)">9th Grade(Highschool)</option>

                      <option value="10th Grade(Highschool)">10th Grade(Highschool)</option>

                      <option value="11th Grade(Highschool)">11th Grade(Highschool)</option>

                      <option value="12th Grade(Highschool)">12th Grade(Highschool)</option>

                    </select>

                    <label class="select_lable">Grade Level</label>

                  </div>

                </div>
                 <div class="col-md-6 ">

                    <div class="custom_input_main select_plugin mobile_field">

                      

          

                  <select class="selectpicker"  name="iep">

                      <option value="" selected>Select Status</option>

                      <option value="IEP">IEP</option>

                      <option value="504">504</option>
            
                   </select>


                      <label>Special Education</label>

                    </div>

                   
                  </div>



                      </div>

                   

                    
                  </div>

      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary">Upload</button>
         </form>
        
        <div class="sample_stu">
                      <a href="{{asset('storage/'.$sample->file)}}"  class="btn btn-primary"download>Download sample</a>
                    </div>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- End of excel model --}}

                      <h3 class="main_title_ot">Add New Student</h3>

        <div class="tab-content">

           <form method="POST" action="/studentstore" enctype="multipart/form-data">

             @csrf

            @foreach ($errors->all() as $error)

              <div class="alert alert-danger">{{ $error }}</div>

            @endforeach

            <div class="tab-pane active" id="tab_default_3">

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('sname')}}" name="sname" required="" minlength="3" maxlength ="50" autofocus="">

                      <label>First name<span class="red">*</span></label>

                    </div>

                    @error('sname')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>


                  <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('lname')}}" name="lname" required="" minlength="3" maxlength ="50" autofocus="">

                      <label>Last name<span class="red">*</span></label>

                    </div>

                    @error('lname')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>


                  <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" name="record_no" value="{{old('record_no')}}" required maxlength="255" autofocus="">

                      <label>Record no.<span class="red">*</span></label>

                    </div>

                    @error('record_no')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="email" class="form-control" name="email" value="{{old('email')}}" required maxlength="255" autofocus="">

                      <label>Email<span class="red">*</span></label>

                    </div>

                    @error('email')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>


                  <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg" required="" autofocus="">

                      <label>Image<span class="red">*</span></label>

                    </div>

                  </div>

                  <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus="">

                      <label>Password<span class="red">*</span></label>

                      @error('password')

                      <span class="invalid-feedback" role="alert">

                          <strong>{{ $message }}</strong>

                      </span>

                      @enderror

                    </div>

                  </div>

                  <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" autofocus="">

                      <label>Confirm Password<span class="red">*</span></label>

                    </div>

                  </div>




                  <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('hadd')}}" name="hadd" required="" minlength="3" maxlength ="50" autofocus="">

                      <label>Home Address<span class="red">*</span></label>

                    </div>

                    @error('hadd')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>





                  <div class="col-md-12">

                      <div class="custom_input_main select_plugin mobile_field">

                        <select class="selectpicker" name="role">

                          <option value="5">Student</option>

                        </select>

                        <label class="select_lable">Role</label>

                      </div>

                  </div>

                  <!-- <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="date" class="form-control" name="adate" value="{{old('adate')}}" onchange="invoicedue(event);" class="mb-4" required="" autofocus="">

                      <label>Admission Date

                        <span class="red">*</span></label>

                      </div>

                    </div> -->

                    <div class="col-md-6"> 


                      <div class="gender_buttons">
                          <label>Gender
                          <span class="red">*</span></label>
                          <button type="button" class="btn gender_btn">Male <input checked type="radio"  name="gender" value="male"></button>
                          <button type="button" class="btn gender_btn">Female <input type="radio" name="gender" value="female"></button>
                        </div>


                          

                    </div>


                  <div class="col-md-6 ">

                    <div class="custom_input_main select_plugin mobile_field">

                      

					

                  <select class="selectpicker"  name="iep">

                      <option value="" selected>Select Status</option>

                      <option value="IEP">IEP</option>

                      <option value="504">504</option>
					  
					         </select>


                      <label>Special Education</label>

                    </div>

                    @error('iep')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

					
					
					
					<div class="col-md-12">

                      <div class="custom_input_main select_plugin alergy">

                      <input type="text" class="form-control" value="{{ old('alergy')}}" name="alergy" class="mb-4" minlength="1" maxlength ="255" autofocus="">

                        <label class="select_lable">Enter Allergies(If any )</label>

                      </div>

                  </div>
				  
				  
				  
					
					
					
     
                <div class="col-md-12 mb-3" >


                 
          
					
		  
		  <!--
		  @foreach($alergies  as $index => $alergy)
                  <div class="custom_checkbox">
                    <input type="checkbox" id="1" class="vh" value="{{$alergy->name}}" name="alergy[]">
                    <label for="1">{{$alergy->name}}</label>
                  </div>
				  @endforeach
				  
		  -->
		 
					   
				  
<!--
                  <div class="custom_checkbox">
                    <input type="checkbox" id="2" class="vh" value="Animal dander" name="alergy[]">
                    <label for="2">Animal dander</label>
                  </div>


                  <div class="custom_checkbox">
                    <input type="checkbox" id="3" class="vh" value="Food (shellfish, eggs and cows' milk)" name="alergy[]">
                    <label for="3">Food (shellfish, eggs and cows' milk)</label>
                  </div>

                  <div class="custom_checkbox">
                    <input type="checkbox" id="4" class="vh" value="Insect bites and stings" name="alergy[]">
                    <label for="4">Insect bites and stings</label>
                  </div>

                  <div class="custom_checkbox">
                    <input type="checkbox" id="5" class="vh" value="Medicines" name="alergy[]">
                    <label for="5">Medicines</label>
                  </div>
-->
<!--                   <input type="checkbox" value="Dust Mites" name="alergy[]" />
                  <label>Dust Mites</label>

                   <input type="checkbox" value="Animal dander" name="alergy[]" />
                  <label>Animal dander</label>

                 <input type="checkbox" value="Food (shellfish, eggs and cows' milk)" name="alergy[]" />
                  <label>Food (shellfish, eggs and cows' milk)</label>

                 <input type="checkbox" value="Insect bites and stings" name="alergy[]" />
                  <label>Insect bites and stings</label>

                 <input type="checkbox" value="Medicines" name="alergy[]" />
                <label>Medicines</label>

<label class="select_lable">Any Alergies?</label> -->




                    <!-- <select required="" name="alergy">

                      <option value="1">Dust Mites</option>

                      <option value="2">Animal dander</option>

                      <option value="3">Food (shellfish, eggs and cows' milk)</option>

                      <option value="4">Insect bites and stings</option>

                      <option value="5">Medicines</option>

                    </select>

                    <label >Known Allergies</label> -->


                </div>

                <div class="col-md-12 ">

                    <div class="custom_input_main select_plugin mobile_field">

                    <select class="selectpicker" required="" name="grade_level">

                      <option value="1st Grade(Elementary)">1st Grade(Elementary)</option>

                      <option value="2nd Grade(Elementary)">2nd Grade(Elementary)</option>

                      <option value="3rd Grade(Elementary)">3rd Grade(Elementary)</option>

                      <option value="4th Grade(Elementary)">4th Grade(Elementary)</option>

                      <option value="5th Grade(Elementary)">5th Grade(Elementary)</option>

                      <option value="6th Grade(Elementary)">6th Grade(Elementary)</option>

                      <option value="7th Grade(Middle)">7th Grade(Middle)</option>

                      <option value="8th Grade(Middle)">8th Grade(Middle)</option>

                      <option value="9th Grade(Highschool)">9th Grade(Highschool)</option>

                      <option value="10th Grade(Highschool)">10th Grade(Highschool)</option>

                      <option value="11th Grade(Highschool)">11th Grade(Highschool)</option>

                      <option value="12th Grade(Highschool)">12th Grade(Highschool)</option>

                    </select>

                    <label class="select_lable">Grade Level</label>

                  </div>

                </div>


                <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('pfname')}}" name="pfname" class="mb-4" required="" minlength="1" maxlength ="50" autofocus="">

                      <label>Parent First Name<span class="red">*</span></label>

                    </div>

                    @error('pfname')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                </div>

                <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('plname')}}" name="plname" class="mb-4" required="" minlength="1" maxlength ="50" autofocus="">

                      <label>Parent Last Name<span class="red">*</span></label>

                    </div>

                    @error('plname')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                </div>



                <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('reltion')}}" name="relation" class="mb-4" required="" minlength="1" maxlength ="50" autofocus="">

                      <label>Relation<span class="red">*</span></label>

                    </div>

                    @error('relation')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                </div>

                <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="tell" class="form-control" name="Phone" value="{{ old('Phone')}}" required="" autofocus="">

                      <label>Phone No<span class="red">*</span></label>

                    </div>

                    @error('Phone')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  
                <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="email" class="form-control" name="pemail" value="{{old('pemail')}}" required maxlength="255" autofocus="">

                      <label>Parent Email <span class ="red">*</span></label>

                    </div>

                    @error('pemail')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                  <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('add')}}" name="add" required="" minlength="3" maxlength ="200" autofocus="">

                      <label>Address<span class="red">*</span></label>

                    </div>

                    @error('add')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>

                 <!--  <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('class')}}" name="class" required="" minlength="3" maxlength ="200" autofocus="">

                      <label>Class<span class="red">*</span></label>

                    </div>

                    @error('class')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div> -->

                  <!-- <div class="col-md-6 ">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('rno')}}" name="rno" required="" minlength="1" maxlength ="200" autofocus="">

                      <label>Roll No<span class="red">*</span></label>

                    </div>

                    @error('rno')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div> -->

          <!-- <div class="row px-3"> 

            <label class="mb-1">

              <h6 class="mb-0 text-sm" style="color:black; margin-right: 10px">Diabetes</h6>

            </label> 

            <label class="mb-1">

                <h6 class="mb-0 text-sm" style="color:black; margin-right: 10px">Yes</h6>

            <input type="radio" value="yes" name="diabetes" class="mb-4" >

            </label> 

            <label class="mb-1">

                <h6 class="mb-0 text-sm" style="color:black; margin-right: 10px">No</h6>

            <input type="radio" value="no" name="diabetes" class="mb-4" checked="checked">

            </label> 

                

          </div> -->

          <br><br>

          <!-- <div class="row px-3"> 

            <label class="mb-1">

                <h6 class="mb-0 text-sm" style="color:black; margin-right: 10px">Alergy</h6>

            </label> 

            <label class="mb-1">

                <h6 class="mb-0 text-sm" style="color:black; margin-right: 10px">Yes</h6>

            <input type="radio" value="yes" name="alergy" class="mb-4" >

            </label> 

            <label class="mb-1">

                <h6 class="mb-0 text-sm" style="color:black; margin-right: 10px">No</h6>

            <input type="radio" value="no" name="alergy" class="mb-4" checked="checked">

            </label> 

          </div> -->

          <div class="s_form_button text-center w-100">

              <a  href="{{url('/students')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

              <button type="submit" class="btn save_btn">Save</button>

            </div>

          </div>

              </form>

            </div>

            

          </div>

        </div>

      </div>

    </div>


    <script>
      $('.gender_btn').click(function(event) {
        /* Act on the event */
        $('.gender_btn').removeClass('btn-primary');
        $(this).addClass('btn-primary');
      });
    </script>

    <script>

        $(":input").inputmask();

    </script>

  </div>

</div>

</div>

<script type="text/javascript">

  setTimeout(function() {

    $('#message').fadeOut('fast');

}, 2000);

</script> 

<script type="text/javascript">

  var password = document.getElementById("password");

  var confirm_password = document.getElementById("password_confirmation");



function validatePassword(){

  if(password.value != confirm_password.value) {

    confirm_password.setCustomValidity("Passwords Don't Match");

  } else {

    confirm_password.setCustomValidity('');

  }

}



password.onchange = validatePassword;

confirm_password.onkeyup = validatePassword;

</script>  

@endsection

       