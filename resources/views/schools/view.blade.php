@extends('layouts.app')

@section('content')


<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li><a href="{{url('/schools')}}"> All Schools </a> </li>

    <li class = "active">View School</li>

  </ol>

</div>


<div class="content_main">

  <div class="card-header course_view_main">

    <div class="cv_head">

      <div class="cv_title">

        <h3 class="mb-0">{{$schooldetail->school_name}}</h3>

        <p> <i class="fa fa-clock-o"></i> {{$schooldetail->school_address}} </p>
        
        
      </div>

      <div class="cv_cogs">

        <a href="{{url('school/edit/' . $schooldetail->sch_u_id)}}"> <i class="fa fa-cogs"></i> </a>

      </div>

    </div>
                

    <div class="cv_img_detail">

      <div class="cv_img">

        <img src="{{asset('/assets/img/upload/'.$schooldetail->school_image)}}" alt="" class="img-fluid main_image_cv">

        <div class="cv_detail">

          <div class="cv_box">

            <h4>Details</h4>

            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/pill1.png')}}" alt="" class="img-fluid">

                <h5>School ID</h5>

              </div>

              <div class="cv_box_rank">

                <p>{{$schooldetail->school_identification_number}}</p>

              </div>

            </div>


            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/pill1.png')}}" alt="" class="img-fluid">

                <h5>Superintendent</h5>

              </div>

              <div class="cv_box_rank">

                <p>{{$schooluser->name}}</p>

              </div>

            </div>

            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/pill1.png')}}" alt="" class="img-fluid">

                <h5>Email</h5>

              </div>

              <div class="cv_box_rank">

                <p>{{$schooluser->email}}</p>

              </div>

            </div>

            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/classroom1.png')}}" alt="" class="img-fluid">

                <h5>District</h5>



              </div>

              <div class="cv_box_rank">

                <p>{{$schooldetail->district}}</p>

              </div>

            </div>

            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/whiteboard1.png')}}" alt="" class="img-fluid">

                <h5>Phone No.</h5>

              </div>

              <div class="cv_box_rank">

                <p>{{$schooldetail->phone}}</p>

              </div>

            </div>

           
        </div>

      </div>

    </div>

      

    <div class="cv_tabs">

      <div id="exTab2">

        <div class="panel panel-default">

          <div class="panel-heading">

            <div class="panel-title">

              <ul class="nav nav-tabs">

                <li class="active">

                  <a href="#1" data-toggle="tab">Grades</a>

                </li>

                <li><a href="#2" data-toggle="tab" class="second_tab">Departments</a>

                </li>

                <!-- <li><a href="#3" data-toggle="tab" class="third_tab">Instructors</a> -->

                <!-- </li> -->

              </ul>

            </div>

          </div>

      

          <div class="panel-body">

            <div class="tab-content ">

              <div class="tab-pane active" id="1">
                  @if(count($grades) > 0)
                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>


                                <th scope="col">Range</th>

                                <th scope="col">Grade</th>

                                <!-- <th scope="col">Action</th> -->

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($grades as $index =>$g)
                              

                              <tr>


                                <td class="first_row">

                                  <div class="course_td">

                                    <p>{{$g->marks_from}} - {{$g->marks_to}}</p>

                                  </div>

                                </td>

                                <td class="first_row">
                                  {{$g->grade}}
                                </td>





                              </tr>

                              @endforeach

                            </tbody>

                          </table>   
                   @else

                  <p>This school has no grade scale yet.</p>
                  @endif
                        





              </div>

              <div class="tab-pane" id="2">

                @if(count($departments) > 0)
                  <table class="table table-hover" id="table-id">

                              <thead>

                                <tr>


                                  <th scope="col">Department Name</th>

                                  <!-- <th scope="col">Grade</th> -->

                                  <!-- <th scope="col">Action</th> -->

                                </tr>

                              </thead>

                              <tbody id="mybody">

                                @foreach($departments as $index =>$dpt)
                                

                                <tr>


                                  <td class="first_row">

                                    <div class="course_td">

                                      <p>{{$dpt->name}}</p>

                                    </div>

                                  </td>
                                  <td>
                                    <p>{{$dpt->created_at}}</p>
                                  </td>

                                  





                                </tr>

                                @endforeach

                              </tbody>
                  </table> 
                @else

                <p>This school has no department yet.</p>
                @endif

              </div>

              <div class="tab-pane" id="3">

                <p> <strong>Course Roster</strong> At vero eos et ac cusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atcorrupti quos dolores et 

                quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est 

                laborum et dolorum fuga. <br> <br>

                On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoraliz the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble thena bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. <br> <br>

                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 

                 </p>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>
</div>

@endsection