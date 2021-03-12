@extends('layouts.app')

@section('content')


<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li>Instructors</li>

    <li class = "active">Instructor Detail</li>

  </ol>

</div>

<div class="content_main">

  <div class="all_courses_main">

    

    <div class="course_table mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3>Instructor Details</h3>
        <br>
        <br>

          <table class="table table-hover">

            <thead>

              <tr>

                <th scope="col">Phone</th>

                <th scope="col">CNIC</th>

                <th scope="col">Address</th>

                <th scope="col">Actions</th>

              </tr>

            </thead>

            <tbody id="mybody">

              <tr>

                <td class="first_row">{{$instructordetail->phone}}</td>

                <td class="first_row">{{$instructordetail->cnic}}</td>

                <td class="first_row">{{$instructordetail->address}}</td>

                

                <td class="align_ellipse first_row">

                  <a class="btn btn-success" href="{{url('/instructors')}}">Back</a>

                </td>

              </tr>

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