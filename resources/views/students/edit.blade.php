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
    <li class = "active">Edit Student</li>
  </ol>
</div>
<div class="content_main">
  <div class="profile_main">
    <div class="profile mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        
        <h3 class="main_title_ot">Edit Student</h3>
        <div class="tab-content">
            <form class="form-horizontal" method="POST" action="{{ url('/student/update/'. $student->id) }}" enctype="multipart/form-data">
              @csrf
                @foreach ($errors->all() as $error)
                  <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
              <div class="tab-pane active" id="tab_default_3">
              <div class="s_profile_fields">
                <div class="row">
                  <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                      <input type="text" class="form-control" value="{{old('sname',$student->name)}}"  name="sname" required="" minlength="3" maxlength ="50" autofocus="">
                      <label>Student First Name<span class="red">*</span></label>
                    </div>
                    @error('sname')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                      <input type="text" class="form-control" value="{{old('lname',$student->last_name)}}"  name="lname" required="" minlength="3" maxlength ="50" autofocus="">
                      <label>Student Last Name<span class="red">*</span></label>
                    </div>
                    @error('lname')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                      <input type="text" class="form-control" value="{{old('record_no',$student->record_no)}}"  name="record_no" required="" minlength="3" maxlength ="50" autofocus="">
                      <label>Record No.<span class="red">*</span></label>
                    </div>
                    @error('lname')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-md-6">
                    <div class="custom_input_main mobile_field">
                      <input type="email" class="form-control" name="email"value="{{old('email',$student->email)}}"  required maxlength="255" readonly autofocus="">
                      <label>Email<span class="red">*</span></label>
                    </div>
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                      <input type="file" name="image" value="{{asset('assets/img/upload/'.$student->image)}}" accept="image/x-png,image/gif,image/jpeg" autofocus="">
                      <label>Image<span class="red">*</span></label>
                    </div>
                  </div>
                   
                  <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                    <input type="text" class="form-control" value="{{old('hadd',$student->home_address)}}"  name="hadd" required="" minlength="3" maxlength ="50" autofocus="">
                      <label>Home Address<span class="red">*</span></label>
                    </div>
                    @error('hadd')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                    <div class="col-md-6">
                      <div class="custom_input_main mobile_field">

                        <div class="gender_buttons">
                          <label>Gender
                          <span class="red">*</span></label>
                          <button type="button" class="btn gender_btn" @if($student->gender == "male") style="background-color:#3399FE" @endif>Male <input type="radio"  name="gender" value="male" @if($student->gender == "male") btn-primary checked @endif></button>
                          <button type="button" class="btn gender_btn" @if($student->gender == "female") style="background-color:#3399FE" @endif>Female <input type="radio" name="gender" value="female" @if($student->gender == "female") btn-primary checked @endif></button>
                        </div>
                        
                      </div>
                    </div>









                    <div class="col-md-6 p_left">
                    <div class="custom_input_main select_plugin mobile_field">
					
                      
					  				

            <select class="selectpicker"  name="iep">

                    <option value="" >Select Status</option>

                      <option @if($student->iep == 'IEP') Selected @endif value="IEP">IEP</option>

                      <option @if($student->iep == '504') Selected @endif value="504">504</option>
					  
					  </select>
					  
					  <label class="select_lable">Special Education</label>
					  
                  </div>

          </div>
		  
		  
                                 <div class="col-md-12">

                      <div class="custom_input_main select_plugin alergy">

                      <input type="text" class="form-control" value="{{old('alergy',$student->alergy)}}" name="alergy" class="mb-4" minlength="1" maxlength ="255" autofocus="">

                        <label class="select_lable">Enter Allergies(If any )</label>

                      </div>

                  </div>
				  
				  
				  
				  
								 
                <?php
                  //dd($student);
                ?>

                <div class="col-md-12">

                    <div class="custom_input_main select_plugin mobile_field">

                    <select class="selectpicker" required="" name="gl">

                      <option @if($student->grade_level == '1st Grade(Elementary)') Selected @endif value="1">1st Grade(Elementary)</option>

                      <option @if($student->grade_level == '2nd Grade(Elementary)' ) Selected @endif value="2">2nd Grade(Elementary)</option>

                      <option @if($student->grade_level == '3th Grade(Elementary)' ) Selected @endif value="3">3rd Grade(Elementary)</option>

                      <option @if($student->grade_level == '4th Grade(Elementary)' ) Selected @endif value="4">4th Grade(Elementary)</option>

                      <option @if($student->grade_level == '5th Grade(Elementary)' ) Selected @endif value="5">5th Grade(Elementary)</option>

                      <option @if($student->grade_level == '6th Grade(Elementary)' ) Selected @endif value="6">6th Grade(Elementary)</option>

                      <option @if($student->grade_level == '7th Grade(Middle)' ) Selected @endif value="7">7th Grade(Middle)</option>

                      <option @if($student->grade_level == '8th Grade(Middle)' ) Selected @endif value="8">8th Grade(Middle)</option>

                      <option @if($student->grade_level == '9th Grade(Highschool)' ) Selected @endif value="9">9th Grade(Highschool)</option>

                      <option @if($student->grade_level == '10th Grade(Highschool)' ) Selected @endif value="10">10th Grade(Highschool)</option>

                      <option @if($student->grade_level == '11th Grade(Highschool)' ) Selected @endif value="11">11th Grade(Highschool)</option>

                      <option @if($student->grade_level == '12th Grade(Highschool)' ) Selected @endif value="12">12th Grade(Highschool)</option>

                    </select>

                    <label class="select_lable">Grade Level</label>

                  </div>

                </div>

                <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                    <input type="text" class="form-control" value="{{old('pfname',$student->parent_first_name)}}"  name="pfname" required="" minlength="3" maxlength ="50" autofocus="">
                      <label>Parent First Name<span class="red">*</span></label>
                    </div>
                    @error('pfname')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                    <input type="text" class="form-control" value="{{old('plname',$student->parent_last_name)}}"  name="plname" required="" minlength="3" maxlength ="50" autofocus="">
                      <label>Parent Last Name<span class="red">*</span></label>
                    </div>
                    @error('plname')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>

                <div class="col-md-6 p_left">
                    <div class="custom_input_main mobile_field">
                    <input type="text" class="form-control" value="{{old('relation',$student->relation)}}"  name="relation" required="" minlength="3" maxlength ="50" autofocus="">
                      <label>Relation<span class="red">*</span></label>
                    </div>
                    @error('relation')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                        
                  <div class="col-md-6">
                    <div class="custom_input_main mobile_field">
                      <!-- <select required="required" class="form-control" name="role">
                          <option value="5">Student</option>
                      </select> -->

                      <input type="text" class="form-control" value="Student" name="role" class="mb-4" required="" autofocus="" readonly="readonly">
                      <label>Role<span class="red">*</span></label>
                    </div>
                  </div>
                
                <div class="col-md-6">
                    <div class="custom_input_main mobile_field">
                      <input type="tell" class="form-control" name="phno" value="{{old('phno',$student->phone)}}"  required="" autofocus="">
                      <label>Phone No<span class="red">*</span></label>
                    </div>
                    @error('phno')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                
                  <div class="col-md-6">
                    <div class="custom_input_main mobile_field">
                      <input type="text" class="form-control" value="{{old('add',$student->address)}}"  name="add" class="mb-4" required="" minlength="3" maxlength ="200" autofocus="">
                      <label>Address<span class="red">*</span></label>
                    </div>
                    @error('address')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message}}</strong>
                      </span>
                    @enderror
                  </div>
                   <div class="col-md-6">
                    <div class="custom_input_main mobile_field">
                      <input type="email" class="form-control" name="pemail"value="{{old('pemail',$student->parent_email)}}"  required maxlength="255" readonly autofocus="">
                      <label>Parent Email<span class="red">*</span></label>
                    </div>
                    @error('pemail')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  
                  
                  </div>
                </div>
                  

                  <div class="s_form_button text-center">
                      <a  href="{{url('/students')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>
                      <button type="submit" class="btn save_btn">Update</button>
                  </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>
<script>
  $(":input").inputmask();
</script>
<script>
  $('.gender_btn').click(function(event) {
    /* Act on the event */
    $('.gender_btn').removeClass('btn-primary');
    $(this).addClass('btn-primary');
  });

  $('.diabities_btn').click(function(event) {
    /* Act on the event */
    $('.diabities_btn').removeClass('btn-primary');
    $(this).addClass('btn-primary');
  }); 

  $('.alergy_btn').click(function(event) {
    /* Act on the event */
    $('.alergy_btn').removeClass('btn-primary');
    $(this).addClass('btn-primary');
  });
</script>
<script type="text/javascript">
  setTimeout(function() {
    $('#message').fadeOut('fast');
  }, 30000);
</script>
@endsection	     