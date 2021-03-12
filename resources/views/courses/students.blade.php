@extends('layouts.app')

@section('content')


<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li><a href = "{{ url()->previous() }}">Courses</a></li>

    <li class = "active">All Students</li>

  </ol>

</div>




  <div class="content_main">

    <div class="all_courses_main">

      

      <div class="course_table mt-0">

        <div class="course card-header card-header-warning card-header-icon">

          

          <h3>All Students</h3>

          @if(count($students)>0)

            <div class="table_filters">

              <!-- <div class="table_search">

                <input type="text" name="search" id="search" value="" placeholder="Search...">

                <a href="#"> <i class="fa fa-search"></i> </a>

              </div> -->

              <!-- <div class="table_select">

                <select class="selectpicker">

                  <option>All Students</option>

                  <option>Today </option>

                  <option>Macro Economics I</option>

                  <option>Macro Economics II</option>

                </select>

              </div> -->

            </div>

            <table class="table table-hover">

              <thead>

                <tr>

                  <th scope="col">ID</th>

                  <th scope="col">Name</th>

                  <th scope="col">Image</th>

                  <th scope="col">Action</th>

                </tr>

              </thead>

              <tbody id="mybody">

                @foreach($students as $index =>$std)

                <?php
                  $stdd = DB::table('students')->where('s_u_id', $std->student_id)->get()->first();
                  $student = DB::table('users')->where('id', $std->student_id)->get()->first();
                ?>

                <tr>


                  <th scope="row">#{{$index+1}}</th>

                  <td class="first_row">

                    <div class="course_td">

                      <p>{{$student->name}}</p>

                    </div>

                  </td>

                  <td class="first_row">
                    
                    <div class="course_td">

                      <img src="{{asset('assets/img/upload/'.$student->image)}}" width="50" alt="" class="img-fluid">

                    </div>
                  </td>

                  <td class="align_ellipse first_row">
                        <a class="btn btn-sm btn-primary" href="{{ url()->previous() }}">Back</a>
                  </td>

                </tr>

                @endforeach

              </tbody>

            </table>   

           @else

            <p>There is no Student</p>

          @endif

        </div>

      </div>

    </div>

  </div>


@endsection

