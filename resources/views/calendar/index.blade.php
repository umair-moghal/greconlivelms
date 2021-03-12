@extends('layouts.app')
<link href="{{asset('/assets/css/calendar.css')}}" rel="stylesheet" />
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
                <li class = "active">School Calendar</li>
              </ol>
            </div>
            <div class="content_main">
              <div class="school_clndr_main">
                
                <div class="calender card-header card-header-warning card-header-icon">
                  
                    <h3>School Calendar</h3>
                  
                <div class="calender_main">

      <div class="calender card-header card-header-warning card-header-icon">

        <div class="card-icon">

          <h2>Calendar</h2>

        </div>

        <div class="calendar_main">

          <div class="row">

            <div class="col-md-3">

              <div class="clndr_event_list">

                @if(auth()->user()->role_id != 5)  
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#calendar_add_even">
                  @if(auth()->user()->role_id == 1)  
                    Add Us Holiday
                  @elseif(auth()->user()->role_id == 3)  
                    Add Event
                   @elseif(auth()->user()->role_id == 4)  
                    Add Live Schedule 
                   @endif 
                </button>
                @endif

                <div class="radio_event_list">

                  <label class="container_radio" onclick="window.location.href = '/calendar/School Calendar' ">School Calendar

                    <input type="radio"  checked  value="School Calendar" name="type" class="type">

                    <span class="checkmark"></span>

                  </label>

                    @if(auth()->user()->role_id == 4)  
                  <label class="container_radio" onclick="window.location.href = '/calendar/Live Instructor Schedule' ">Live Instructor Schedule

                    <input type="radio" @if(isset($type) && $type == 'Live Instructor Schedule') checked @endif name="type" value="Live Instructor Schedule" class="type">

                    <span class="checkmark"></span>

                  </label>
                  @endif

                 @if(auth()->user()->role_id == 1)  
                  <label class="container_radio" onclick="window.location.href = '/calendar/US Holidays' ">US Holidays

                    <input type="radio"  @if(isset($type) && $type == 'US Holidays') checked @endif  name="type" value="US Holidays" class="type">

                    <span class="checkmark"></span>

                  </label>
                  @endif

                  @if(auth()->user()->role_id == 3)  
                  <label class="container_radio" onclick="window.location.href = '/calendar/Events' ">Events

                    <input type="radio"  @if(isset($type) && $type == 'Events') checked @endif  name="type" value="Events" class="type">

                    <span class="checkmark"></span>

                  </label>
                  @endif


                </div>

              </div>

            </div>

            <div class="col-md-9">

              <div class="top_clndr">

                <div class="">

                  <div class="card-body p-0">

                    <div>
                      {!! $calendar->calendar() !!}
                      {!! $calendar->script() !!}
                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

          

        </div>

      </div>

                  </div>
                </div>
              </div>
            </div>

  <div id="modal-view-event" class="modal modal-top fade calendar-modal">

    <div class="modal-dialog modal-dialog-centered">

      <div class="modal-content">

        <div class="modal-body">

          <h4 class="modal-title"><span class="event-icon"></span><span class="event-title"></span></h4>

          <div class="event-body"></div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

        </div>

      </div>

    </div>

  </div>

  <div id="modal-view-event-add" class="modal modal-top fade calendar-modal">

    <div class="modal-dialog modal-dialog-centered" role="document">

  <div class="modal-content">

    <div class="cross_modal">

      <div class="modal_title">

        <h3>Add Event</h3>

      </div>

      <button type="button" class="close" data-dismiss="modal" aria-label="Close">

        <span aria-hidden="true" class="cross_btn">×</span>

      </button>

    </div>

    <div class="modal-body">

      <form method="POST" action="{{url('/addevent')}}">
        @csrf


        <div class="col-md-12 p_right">

            <div class="custom_input_main select_plugin mobile_field">

            <select class="selectpicker" required="" name="type">

              <option> Choose Event Type </option>

              <option value="School Calendar">School Calendar</option>

              <option value="Live Instructor Schedule">Live Instructor Schedule</option>
              @if(Auth::user()->role_id == '1')

                <option value="US Holidays">US Holidays</option>

              @endif

              <option value="Events">Events</option>

            </select>

            <label class="select_lable">Sessions</label>

          </div>

        </div>

        <div class="custom_input_main mobile_field">

          <input type="name" class="form-control" name="ename" value="{{old('ename')}}">

          <label>Event Name <span class="grey">*</span></label>

        </div>

        <div class="custom_input_main mobile_field">

          <input type="date" class="form-control" name="sdate" value="{{old('edate')}}">

          <label>Start Date <span class="red">*</span></label>

        </div>

        <div class="custom_input_main mobile_field">

          <input type="date" class="form-control" name="edate" value="{{old('edate')}}">

          <label>End Date <span class="r/ed">*</span></label>

        </div>

        <div class="custom_input_main mobile_field">

          <textarea class="form-control" name="edesc" value="{{old('edesc')}}"></textarea>



          <label>Event Description <span class="red">*</span></label>

        </div>

        <div class="s_form_button">

          <a href="/calendar"><button type="button" class="btn cncl_btn">Cancel</button></a>

          <button type="submit" class="btn save_btn">Save</button>

        </div>

      </form>

    </div>

  </div>

</div>

</div>



<div class="modal fade" id="calendar_add_even" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Calendar Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="/add_event_from_calendar">
          @csrf
           <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
           <input type="hidden" name="event_type" @if(isset($type)) value="{{$type}}" @else value="School Calendar" @endif id="form_type">

        <div class="custom_input_main mobile_field">

          <input type="text" class="form-control" name="event_name" required>



          <label>Event Name <span class="grey">*</span></label>

        </div>

        <div class="custom_input_main mobile_field">

          <input type="date" class="form-control" name="event_start" required>



          <label>Event Start Date <span class="red">*</span></label>

        </div>

        <div class="custom_input_main mobile_field">

          <input type="date" class="form-control" name="event_end" required>



          <label>Event End Date <span class="red">*</span></label>

        </div>

        <div class="custom_input_main mobile_field">

          <textarea class="form-control" name="event_description" required></textarea>



          <label>Event Description <span class="red">*</span></label>

        </div>

       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
       </form>
    </div>
  </div>
</div>





<script type="text/javascript">

  setTimeout(function() {

    $('#message').fadeOut('fast');

}, 2000);

$( ".fc-title" ).click(function() {
		alert("asdfasfaf");
	});
</script>
@endsection