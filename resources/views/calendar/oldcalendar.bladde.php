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
                  
                  <div class="calendar_main">

                    <div class="row">

                      <div class="col-md-3">

                        <div class="clndr_event_list">

                          <button type="button" data-toggle="modal" data-target="#modal-view-event-add">Add Event</button>

                          <div class="radio_event_list">

                            <label class="container_radio">School Calendar

                              <input type="radio" checked="checked" name="radio">

                              <span class="checkmark"></span>

                            </label>

                            <label class="container_radio">Live Instructor Schedule

                              <input type="radio" name="radio">

                              <span class="checkmark"></span>

                            </label>

                            <label class="container_radio">US Holidays

                              <input type="radio" name="radio">

                              <span class="checkmark"></span>

                            </label>

                            <label class="container_radio">Events

                              <input type="radio" name="radio">

                              <span class="checkmark"></span>

                            </label>
<!-- 
                            <label class="container_radio">Populated

                              <input type="radio" name="radio">

                              <span class="checkmark"></span>

                            </label> -->

                          </div>

                        </div>

                      </div>


                      <div class="col-md-9">

                        <div class="top_clndr">

                          <div class="">

                            <div class="card-body p-0">

                              <div id="calendar"></div>

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

  <!-- <div id="modal-view-event-add" class="modal modal-top fade calendar-modal"> -->

    <div class="modal-dialog modal-dialog-centered" role="document">

  <!-- <div class="modal-content">

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

  </div> -->

</div>

</div>





<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/interaction/main.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/timegrid/main.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.js'></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      header: {
        center: 'addEventButton'
      },
      customButtons: {
        addEventButton: {
          text: 'add event...',
          click: function() {
            var dateStr = prompt('Enter a date in YYYY-MM-DD format');
            var date = new Date(dateStr + 'T00:00:00'); // will be in local time

            if (!isNaN(date.valueOf())) { // valid?
              calendar.addEvent({
                title: 'dynamic event',
                start: date,
                allDay: true
              });
              alert('Great. Now, update your database...');
            } else {
              alert('Invalid date.');
            }
          }
        }
      }
    });

    calendar.render();
  });
</script>









<script type="text/javascript">

  setTimeout(function() {

    $('#message').fadeOut('fast');

}, 2000);

</script>
@endsection