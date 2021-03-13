<?php
  $user_role = DB::table('role')->where('id', Auth::user()->role_id)->get()->first();
  $user = Auth::user();
?>

<?php

$special= DB::table('special_educations')->get();
$greeting = DB::table('greetings')->get()->first();

?>

<style>
  .custom_checkbox label:before {
    margin-left: 0 !important
  }
  .emails_textarea , .listing_checkboxes_course , .listing_instruc_course {
    margin-top: 1rem;
    display: none;
    margin-left: 20px;
    margin-bottom: 1rem;
  }
  #live_popup .modal-title {
    font-size: 22px;
    font-weight: 500;
  }
/*  .new_noti {
    top: -108px !important;
    left: 74px !important;
  }*/
/*  .new_noti:after {
    content: " ";
    position: absolute;
    left: -15px;
    top: 103px;
    border-top: 15px solid transparent;
    border-right: 15px solid #ffffff;
    border-left: none;
    border-bottom: 15px solid transparent;
    filter: drop-shadow(-1px 1px 1px #00000042);
  } */
/*  .new_noti.open>.dropdown-menu, .dropdown-menu.show {
    min-height: 125px !important;
    max-height: 125px !important;
    overflow-y: scroll !important; 
  }*/
   
</style>

<div class="header_2">
  

 <div class="top_menu_bar">

    <div class="row">

      <div class="col-md-2">

        <div class="top_menu_link  @if(Request::segment(1) == 'dashboard')  active_link arrow_box @endif ">

          <a href="{{url('/dashboard')}}">Dashboard</a>

        </div>

      </div>

      <div class="col-md-2">

        <div class="top_menu_link @if(Request::segment(1) == 'course')  active_link arrow_box @endif ">

          @if(auth()->user()->role_id == 5)
            <a href="{{url('/studentcourses')}}">Courses</a>
          @else
            <a href="{{url('/course')}}">Courses</a>
          @endif

        </div>

      </div>

      
      <div class="col-md-2">

        <div class="top_menu_link @if(Request::segment(1) == '#')  active_link arrow_box @endif">

          <a href="#">Schedule</a>

        </div>

      </div>

      <div class="col-md-3">

        <div class="top_menu_notification">

          <ul class="navbar-nav">

            <li class="nav-item">

              <a class="nav-link" href="javascript:;">

                <i class="fa fa-question-circle"></i>

                <p class="d-lg-none d-md-block">

                  Stats

                </p>

                <div class="ripple-container"></div>

              </a>

            </li>

            <li class="nav-item">

              <a class="nav-link" href="{{url('/messages')}}">

                <i class="fa fa-envelope"></i>

                <p class="d-lg-none d-md-block">

                  Stats

                </p>

                <div class="ripple-container"></div>

              </a>

            </li>

            <li class="nav-item dropdown position_arrow">

              <a class="nav-link noti_checker " href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fa fa-bell"></i>

                <span class="notification">
                @if(auth()->user()->role_id == '3')
                <?php

                $special = DB::table('special_educations')->where('is_seen', 0)->get()->count();
                ?>
                @elseif(auth()->user()->role_id == '5')
                 <?php

                $special = DB::table('special_educations')->where('is_rejected', 1)->where('student_id', auth()->user()->id)->get()->count();
                ?>

              <!-- {{$special}} -->

                @endif

                
                <span class="noti_count">0</span> 
                
                
                </span>

                <p class="d-lg-none d-md-block">

                  Some Actions

                </p>

                <div class="ripple-container"></div>

              </a>

              <div class="dropdown-menu dropdown-menu-right new_noti" aria-labelledby="navbarDropdownMenuLink" style="z-index:999">
              

              <a href="#" class="text-center m-2">view all</a>

              </div>

            </li>

            {{-- <li class="nav-item dropdown">

              <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <i class="fa fa-user"></i>

                <p class="d-lg-none d-md-block">

                  Account

                </p>

                <div class="ripple-container"></div>

              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                <a class="dropdown-item" href="{{url('/showprofile')}}">Profile</a>

                <a class="dropdown-item" href="#">Settings</a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{url('/logout')}}">Log out</a>

              </div>

            </li> --}}

          </ul>

        </div>

      </div>

    </div>

  </div>




  <div class="main_heding">

    <div class="hed_img">

      <img src="{{asset('/assets/img/upload/'.$user->image)}}" alt="" class="img-fluid" width="50" height="50">

      <h3>{{$user_role->name}} Dashboard</h3>

    </div>
    @if(auth()->user()->role_id == 4)
    <div class="live_button">

      <button type="button" data-toggle="modal" id="send-email" data-target="#live_popup"><img src="{{asset('/assets/img/latest/man-talking.png')}}" alt="" class="img-fluid">Live</button>





    </div>
    @endif

  </div>

    <div style=" margin-top: 20px;">
      <div class="alert alert-success" style="z-index: -1;">
        <p>{{$greeting->description}} {{$user->name}}.</p>
      </div>
  </div>




  <!-- Modal -->
<div class="modal fade" id="live_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Go Live</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

    <form action="/go_live" method="post">
      @csrf
      <div class="modal-body">
        <div class="modal_data">
          <div class="emails_checkbox">
            <div class="custom_checkbox">
              <input type="checkbox" id="-1" class="vh email_checkbox">
              <label for="-1">Emails (Enter comma separated emails)</label>
            </div>
            <div class="emails_textarea">
              <div class="custom_input_main">
                  <textarea class="form-control" name="emails" id="email-list" style="height: 115px !important;"></textarea>
                  <label>Emails <span class="grey"></span></label>
                </div>
            </div>
          </div>

          @php
              $courses = DB::table('courses')->where('ins_id',auth()->user()->id)->get();
            @endphp
             @if(isset($courses))
          <div class="main_checkbox_course">
            <div class="custom_checkbox">
              <input type="checkbox" id="0" class="vh course_checkbox">
              <label for="0">Courses ans Students</label>
            </div>
            
            <div class="listing_checkboxes_course">
             
              @foreach($courses as $course)
                <div class="custom_checkbox">
                  <input type="checkbox" id="{{$course->id}}" value="{{$course->id}}" name="courses[]" class="vh">
                  <label for="{{$course->id}}">{{$course->course_name}}</label>
                </div>
              @endforeach
              
            </div>
          </div>
          @endif

           @php
               $school_id = DB::table('instructor_school')->where('i_u_id',auth()->user()->id)->pluck('sch_u_id')->first();
               $instructor_ids = DB::table('instructor_school')->where('sch_u_id',$school_id)->get()->pluck('i_u_id');
               $instructors = DB::table('users')->whereIn('id',$instructor_ids)->get();

            @endphp
             @if(isset($instrutors))
                <div class="main_instruc_checkbox">
                  <div class="custom_checkbox">
                    <input type="checkbox" id="5" class="vh instruc_checkbox">
                    <label for="5">Instructors</label>
                  </div>
                 
                  <div class="listing_instruc_course">
                   
                      @foreach($instructors as $instructor)
                        <div class="custom_checkbox">
                          <input type="checkbox" id="{{$instructor->id.'in'}}" value="{{$instructor->id}}" name="instructors[]" class="vh">
                          <label for="{{$instructor->id.'in'}}">{{$instructor->name}}</label>
                        </div>
                      @endforeach
                  
                  </div>
                </div>
            @endif
        </div>
      </div>

       <div class="form-check m-3">
                              <input type="checkbox" name="send_notification"><label> Check to Send Notification for Live Lecture.</label>   
       </div>
       <script type="text/javascript">
        $(document).ready(function() {
          // $('#sub_button').prop('disabled','true');  
        });
       </script>


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a class="btn btn-primary" id="sub_button_visible">Send Link </a>
        <button type="submit" class="d-none" id="sub_button" class="btn btn-primary">Send Link</button>
      </div>
    </form>

    </div>
  </div>
</div>


<input type="hidden" name="user" value="{{$user->id}}" id="helpercall">


</div>



<script >
  // $('.noti_checker').click(function(event) {
    /* Act on the event */
    $(document).ready(function() {
    //   if($('.new_noti').is(':visible')){
    //   alert('popop');
    // }  
    
    // if ($(".new_noti").hasClass("show")) {
    //     alert('popo');
    //   }
    });
    
  // });
</script>


<script>
  $(document).ready(function() {
      $(".email_checkbox").click(function() {
    if($(this).is(":checked")) {
        $(".emails_textarea").slideDown();
    }
    else {
        $(".emails_textarea").slideUp();
    }
    }); 

    $(".course_checkbox").click(function() {
      if($(this).is(":checked")) {
          $(".listing_checkboxes_course").slideDown();
      }
      else {
          $(".listing_checkboxes_course").slideUp();
      }
    });

    $(".instruc_checkbox").click(function() {
      if($(this).is(":checked")) {
          $(".listing_instruc_course").slideDown();
      }
      else {
          $(".listing_instruc_course").slideUp();
      }
    });


  });

  
  
</script>

      <script type="text/javascript">
 
    $('#sub_button_visible').click(function(){
    var emails = null; 
    // alert('abc');
    emails = $('#email-list').val();
  
        var new_line_match = /\r|\n/.exec(emails);
        if (new_line_match) {
            console.log('new line pattern');
        emails = emails.split('\n');
        for (i = 0; i < emails.length; i++) {
            var comma_emails = emails[i].split(',');
            if (comma_emails.length > 1) {
                for (j = 0; j < comma_emails.length; j++) {
                    if (j) {
                        emails.splice(i,0,comma_emails[j]);
                    }
                    else {
                        emails.splice(i,1,comma_emails[j]);
                    }
                }
            }
        }
     }
        else {

        emails = emails.split(',');
        }
        
        var emails = emails.filter(function(el) { return el; });
        var flag_check = true;
        //console.log(emails);

    for (i = 0; i < emails.length; i++) {
      //console.log(emails[i]);
      
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if (re.test(String(emails[i].trim()).toLowerCase())) {
          $('#sub_button').prop('disabled',false);  
          // $("#sub_button").trigger("click");  
        
      }
      else {  
       	  
          swal("Invalid Email", emails[i]+" is not valid email. Please enter email in correct format", "error");
          $('#sub_button').prop('disabled',true);  
           flag_check = false;	 
       
      }
      
    }

    if(flag_check == true){	
    	 document.getElementById("sub_button").click();
    }
    
    
    
    
    
    
  }); 
</script>


<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

</script>


<script>

  setInterval(function(){ 

      var data = $(".noti_count").text();

      var url = '/noti_number/'+data;
   
      $.ajax({
                    /* the route pointing to the post function */
                    url: url,
                    type: 'GET',
                    /* send the csrf-token and the input to the controller */
                    data: { count:$(".noti_count").text()},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                      $(".noti_count").text(data);

                    }

      }); 


  }, 3000);


  $( ".noti_checker" ).click(function() {


     var url = '/noti_checker';

    //alert(data);
      $.ajax({
                    /* the route pointing to the post function */
                    url: url,
                    type: 'GET',
                    /* send the csrf-token and the input to the controller */
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {    
                      $(".new_noti").html("");
                      //alert(data.length);
                      // var data = JSON.parse(data);
                      $(".new_noti").html(data);

                    }

                }); 

      

    var data = $(".noti_count").text();

    var url = '/noti_checker/'+data;
   
      $.ajax({
                    /* the route pointing to the post function */
                    url: url,
                    type: 'GET',
                    /* send the csrf-token and the input to the controller */
                    data: { count:$(".noti_count").text()},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                      //alert(data);

                    }

                }); 
      $(".noti_count").text(0);


     
});
</script>



<script type="text/javascript">

  $(document).ready(function(){

  var user_id = $('#helpercall').val();
  var url = '/user_session/'+user_id;


    setInterval(function()
    { 

    $.ajax({
        url: url,
        type: 'POST',
        data: {},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'JSON',
        success: function (data) { 

        }

        }); 


    }, 10000);

  });


</script>

{{--

<script>

  $( ".noti_checker" ).click(function() {
  alert( "Handler for .click() called." );
});

$(document).ready(function(){

// updating the view with notifications using ajax

function load_unseen_notification(view = '')

{

 $.ajax({

  url:"/special_education/notification",
  method:"get",
  data:{view:view},
  dataType:"json",
  success:function(data)

  {

   $('.dropdown-menu').html(data.notification);

   if(data.unseen_notification > 0)
   {
    $('.count').html(data.unseen_notification);
   }

  }

 });

}

load_unseen_notification();

// submit form and get new records

$('#comment_form').on('submit', function(event){
 event.preventDefault();

 if($('#subject').val() != '' && $('#comment').val() != '')

 {

  var form_data = $(this).serialize();

  $.ajax({

   url:"/special_education/notification",
   method:"get",
   data:form_data,
   success:function(data)

   {

    $('#comment_form')[0].reset();
    load_unseen_notification();

   }

  });

 }

 else

 {
  alert("Both Fields are Required");
 }

});

// load new notifications

$(document).on('click', '.dropdown-toggle', function(){

 $('.count').html('');

 load_unseen_notification('yes');

});

setInterval(function(){

 load_unseen_notification();;

}, 5000);

});

</script> --}}