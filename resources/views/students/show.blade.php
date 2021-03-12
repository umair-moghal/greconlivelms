@extends('layouts.app')
@section('content')


<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li>Students</li>

    <li class = "active">Student Detail</li>

  </ol>

</div>


<div class="content_main">
  <div class="all_courses_main">
    
    <div class="course_table mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        
        <h3>Student Details</h3>
        <br>
        <br>
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Last name</th>
                <th scope="col">Parent First Name</th>
                <th scope="col">Parent Last Name</th>
                <th scope="col">Parent Email</th>
                <th scope="col">Phone</th>
                <!-- <th scope="col">Known Allergies</th> -->
                <th scope="col">Address</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody id="mybody">
               @foreach($studentsdetail as $st) 
              <tr>
                <td class="first_row">
                  <div class="course_td">
                    <p>{{$st->last_name}}</p>
                  </div>
                </td>
                <td class="first_row">{{$st->parent_first_name}}</td>
                <td class="first_row">{{$st->parent_last_name}}</td>
                <td class="first_row">{{$st->parent_email}}</td>
                <td class="first_row">{{$st->phone}}</td>
                <!-- <td class="first_row">{{$st->alergy}}</td> -->
                <td class="first_row">{{$st->address}}</td>
                
                <td class="align_ellipse first_row">


                   <a class="btn btn-info" href="{{url('/students')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>   
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
      $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        // alert(value);
        $("#mybody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
@endsection            
