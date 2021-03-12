@extends('layouts.app')

<link href="{{url('/assets/css/calendar.css')}}" rel="stylesheet" />
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>





@section('content')

<style>
  .checkbox_btn {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
  }
  .search_btn_btn button {
    padding: 10px !important;
      border-radius: 50% !important;
  }
</style>



<div class="content_main">

    <div class="all_courses_main">

      

      <div class="course_table mt-0">

        <div class="course card-header card-header-warning card-header-icon">

          
          <div class="align_heading d-flex align-items-center justify-content-between">
            <h3>Student Assignments Statistics</h3>
            <button class="btn btn-primary">Export Excel</button>
          </div>
          

            <div class="table_filters">

              <div class="table_search w-100">

                <div class="row">
                  <div class="col-md-3">
            <div class="custom_input_main select_plugin mobile_field">

                        <select class="selectpicker" required="" name="sessions" id="slct">

                          <option> Select Course </option>

                          <option value="1">One session  ( 9 weeks ) </option>

                          <option value="2">Two sessions-One semester ( 18 weeks )  </option>

                          <option value="3">Three session  ( 27 weeks )</option>

                          <option value="4">Four sessions-Two semesters ( 36 weeks )</option>

                        </select>

                        <label class="select_lable">Course</label>

                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="custom_input_main mobile_field" style="margin-top: 6px;">

                      <input type="text" class="form-control" name="sdate">

                      <label>From Date

                        <span class="grey">*</span></label>

                      </div>
                  </div>
                  <div class="col-md-3">
                    <div class="custom_input_main mobile_field" style="margin-top: 6px;">

                      <input type="text" class="form-control" name="sdate">

                      <label>To Date

                        <span class="grey">*</span></label>

                      </div>
                  </div>
                  <div class="col-md-3 pl-lg-0">
                    <div class="checkbox_btn">
                      <div class="checkboxes_">
                        <div class="custom_checkbox">
                            <input type="checkbox" id="1" class="vh" value="Animal dander" name="alergy[]">
                            <label for="1">Highest</label>
                          </div>
                          <div class="custom_checkbox">
                            <input type="checkbox" id="2" class="vh" value="Animal dander" name="alergy[]">
                            <label for="2">Lowest</label>
                          </div>
                      </div>
                      <div class="search_btn_btn">
                        <button type="button" class="btn btn-primary rounded"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- <input type="text" name="search" id="search" value="" placeholder="Search...">

                <a href="#"> <i class="fa fa-search"></i> </a> -->

                

              </div>
              



            </div>

            <table class="table table-hover" id="table-id">

              <thead>

                <tr>

                  <th scope="col">ID</th>

                  <th scope="col">Student</th>

                  <th scope="col">Subject</th>

                  <th scope="col">Course</th>

                  <th scope="col">Assignment Title</th>

                  <th scope="col">Obtained Marks</th>

                  <th scope="col">Total Marks</th>

                  <th scope="col">Percentage</th>

                  <th scope="col">Marked At</th>

                </tr>

              </thead>

            

            </table>  

            
          

        </div>

      </div>

    </div>

  </div>

@endsection