@extends('layouts.app')

@section('content')


<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li>Terms/Sessions</li>

    <li class = "active">All Instructors</li>

  </ol>

</div>




  <div class="content_main">

    <div class="all_courses_main">

      

      <div class="course_table mt-0">

        <div class="course card-header card-header-warning card-header-icon">

          

          <h3>Instructors</h3>

          @if(count($instructors)>0)

            <div class="table_filters">

              <div class="table_search">

                <input type="text" name="search" id="search" value="" placeholder="Search...">

                <a href="#"> <i class="fa fa-search"></i> </a>

              </div>

              <div class="table_select">

                <select class="selectpicker">

                  <option>All instructors</option>

                  <option>Today </option>

                  <option>Macro Economics I</option>

                  <option>Macro Economics II</option>

                </select>

              </div>

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
                <?php $count = 1;  ?>
                @foreach($instructors as $ins)

                <?php
                  $instructor = DB::table('users')->where('id', $ins->i_u_id)->get()->first();
                ?>

                <tr>


                  <th scope="row">{{$count}}   </th>
                     <?php $count++; ?>

                  <td class="first_row">

                    <div class="course_td">

                      <p>{{$instructor->name}}</p>

                    </div>

                  </td>

                  <td class="first_row">
                    
                    <div class="course_td">

                      <img src="{{asset('assets/img/upload/'.$instructor->image)}}" width="50" alt="" class="img-fluid">

                    </div>
                  </td>

                  <td class="align_ellipse first_row">

                    <li class="nav-item dropdown">

                      <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <span class="material-icons">

                          more_horiz

                        </span>

                        <div class="ripple-container"></div>

                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                        <a class="dropdown-item" href="{{url('/classes')}}"><i class="fa fa-cogs"></i>Back</a>

                      </div>

                    </li>

                  </td>

                </tr>

                @endforeach

              </tbody>

            </table>   

           @else

            <p>There is no Instructor</p>

          @endif

        </div>

      </div>

    </div>

  </div>

@endsection

