@extends('layouts.app')

@section('content')


<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li class = "active">Your Grades</li>

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
        <h3>Quiz View</h3>   
          
          <div class="result_main">
            <p>Obtained Marks: <span>{{$total_marks}}</span></p>
            <p>Total Percentage: <span>{{$percentage}} %</span></p>
            
            <p>Total Grade: <span>{{$grade->grade}}</span></p>
            <a href="{{url('/studentcourses')}}" class="btn btn-sm btn-warning">Back</a>
          </div>
         
      </div>

    </div>

  </div>

</div>


@endsection