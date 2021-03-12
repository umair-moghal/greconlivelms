@extends('layouts.app')

@section('content')


<div class="breadcrumb_main">

  <ol class="breadcrumb">

    <li><a href = "{{url('/dashboard')}}">Home</a></li>

    <li><a href="{{ url()->previous() }}"> All Courses </a> </li>

    <li class = "active">View</li>

  </ol>

</div>


<div class="content_main">

  <div class="card-header course_view_main">

    <div class="cv_head">

      <div class="cv_title">

        <h3 class="mb-0">{{$cat->course_name}}</h3>

        <p> <i class="fa fa-clock-o"></i> {{date('d-m-Y', strtotime($cat->start_date))}} - {{date('d-m-Y', strtotime($cat->end_date))}} </p>
        

      </div>

      <div class="cv_cogs">

        <a href="#"> <i class="fa fa-cogs"></i> </a>

      </div>

    </div>
                

    <div class="cv_img_detail">

      <div class="cv_img">

        <img src="{{asset('assets/img/upload/'.$cat->image)}}" alt="" class="img-fluid main_image_cv">

        <div class="cv_detail">

          <div class="cv_box">

            <h4>Details</h4>

            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/pill1.png')}}" alt="" class="img-fluid">

                <h5>Unique Identifier</h5>

              </div>

              <div class="cv_box_rank">

                <p>{{$cat->unique_identifier}}</p>

              </div>

            </div>


                @php
                  $ins_name = DB::table('users')->where('id',$cat->ins_id)->pluck('name')->first();
                @endphp
            @if(isset($ins_name))    
            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/pill1.png')}}" alt="" class="img-fluid">

                <h5>Instructor Name</h5>

              </div>

              <div class="cv_box_rank">

                <p>{{$ins_name}}</p>

              </div>

            </div>
            @endif


            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/classroom1.png')}}" alt="" class="img-fluid">

                <h5>Course Color</h5>



              </div>

              <div class="cv_box_rank">

                <p><div style="background-color:  {{$cat->course_color}}; padding: 10px; border: 1px solid green;">  
                </div></p>

              </div>

            </div>

            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/whiteboard1.png')}}" alt="" class="img-fluid">

                <h5>Room No.</h5>

              </div>

              <div class="cv_box_rank">

                <p>{{$cat->room_number}}</p>

              </div>

            </div>

            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/calendar1.png')}}" alt="" class="img-fluid">

                <h5>Start Date </h5>

              </div>

              <div class="cv_box_rank">

                <p>{{date('d-m-Y', strtotime($cat->start_date))}}</p>

              </div>

            </div>

            <div class="cv_box_detail">

              <div class="cv_box_img">

                <img src="{{asset('assets/img/latest/calendar1.png')}}" alt="" class="img-fluid">

                <h5>End Date</h5>

              </div>

              <div class="cv_box_rank">

                <p>{{date('d-m-Y', strtotime($cat->end_date))}}</p>

              </div>

            </div>

          </div>
        </div>

      </div>

    </div>

      

    <div class="cv_tabs" style="margin-top: 70px !important">

      <div id="exTab2">

        <div class="panel panel-default">

          <div class="panel-heading">

            <div class="panel-title">

              <ul class="nav nav-tabs">

                <li class="active">

                  <a href="#1" data-toggle="tab" class="third_tab active" >Description</a>

                </li>

                <li>

                  <a href="#3" data-toggle="tab" class="third_tab">Course Weekly Resources</a>

                </li>

                @if(auth()->user()->role_id != 5)
                <li><a href="#2" data-toggle="tab" class="third_tab">Students Enrolled</a>

                </li>
                @endif

                 <li><a href="#6" data-toggle="tab" class="third_tab">Grading Criteria</a>

                </li>

               <!--  <li><a href="#4" data-toggle="tab" class="third_tab">Results</a>

                </li> -->

                <li><a href="#5" data-toggle="tab" class="third_tab">Attendance</a>

                </li>

               

              </ul>

            </div>

          </div>

      

          <div class="panel-body">

            <div class="tab-content ">

              <div class="tab-pane active" id="1">

                 {!! $cat->course_description !!}

              </div>

              <div class="tab-pane" id="3">

  
  @for($i = 1; $i < 19; $i++)

                 <div class="content_main">

    <div class="card-header sftp_main">

      <div class="align_dftp">


        


      </div>



        <?php

          $week = $i;
          $cid = $cat->id;
          $insid = $cat->ins_id;
          $clasid = $cat->clas_id;

           $mquizzes = DB::table('quizzes')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'monday'],
        ])->orderBy('id', 'desc')->get()->all();
        $tuesquizzes = DB::table('quizzes')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'tuesday'],
        ])->orderBy('id', 'desc')->get()->all();
        $wedquizzes = DB::table('quizzes')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'wednesday'],
        ])->orderBy('id', 'desc')->get()->all();
        $tquizzes = DB::table('quizzes')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'thursday'],
        ])->orderBy('id', 'desc')->get()->all();
        $fquizzes = DB::table('quizzes')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "friday"],
        ])->orderBy('id', 'desc')->get()->all();


        $mlinks = DB::table('courselink')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'monday'],
        ])->orderBy('id', 'desc')->get()->all();
        $tueslinks = DB::table('courselink')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'tuesday'],
        ])->orderBy('id', 'desc')->get()->all();
        $wedlinks = DB::table('courselink')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'wednesday'],
        ])->orderBy('id', 'desc')->get()->all();
        $tlinks = DB::table('courselink')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'thursday'],
        ])->orderBy('id', 'desc')->get()->all();
        $flinks = DB::table('courselink')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'friday'],
        ])->orderBy('id', 'desc')->get()->all();




        $mlectures = DB::table('lectures')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'monday'],
        ])->orderBy('id', 'desc')->get()->all();
         $tueslectures = DB::table('lectures')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'tuesday'],
        ])->orderBy('id', 'desc')->get()->all();
          $wedlectures = DB::table('lectures')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'wednesday'],
        ])->orderBy('id', 'desc')->get()->all();
           $thlectures = DB::table('lectures')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'thursday'],
        ])->orderBy('id', 'desc')->get()->all();
            $flectures = DB::table('lectures')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', 'friday'],
        ])->orderBy('id', 'desc')->get()->all();





        $mvideoos = DB::table('resources')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "monday"],
        ])->orderBy('id', 'desc')->get()->all();
        $tuesvideoos = DB::table('resources')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "tuesday"],
        ])->orderBy('id', 'desc')->get()->all();
        $wedvideoos = DB::table('resources')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "wednesday"],
        ])->orderBy('id', 'desc')->get()->all();
        $tvideoos = DB::table('resources')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "thursday"],
        ])->orderBy('id', 'desc')->get()->all();
        $fvideoos = DB::table('resources')->where([
            ['instructor_id', '=', $insid],
            ['course_id', '=', $cid],
            ['week', '=', $week],
            ['day', '=', "friday"],
        ])->orderBy('id', 'desc')->get()->all();

        $course = DB::table('courses')->where('id',$cid)->first();
        

          $mondayquiz =    count($mquizzes);
          $tuesdayquiz =    count($tuesquizzes);
          $wednesdayquiz =    count($wedquizzes);
          $thursdayquiz =    count($tquizzes);
          $fridayquiz =    count($fquizzes);

          $mondaylec =  count($mlectures);
          $tuesdaylec =  count($tueslectures);
          $wednesdaylec =  count($wedlectures);
          $thursdaylec =  count($thlectures);
          $fridaylec =  count($flectures);

          $mondaylink = count($mlinks);
          $tuesdaylink = count($tueslinks);
          $wednesdaylink = count($wedlinks);
          $thursdaylink = count($tlinks);
          $fridaylink = count($flinks);

          $mondayvid =  count($mvideoos);
          $tuesdayvid =  count($tuesvideoos);
          $wednesdayvid =  count($wedvideoos);
          $thursdayvid =  count($tvideoos);
          $fridayvid =  count($fvideoos);


            $mondayvideos = [];
            $tuesdayvideos = [];
            $wednesdayvideos = [];
            $thursdayvideos = [];
            $fridayvideos = [];

            $mondaydownloadables= [];
            $tuesdaydownloadables= [];
            $wednesdaydownloadables= [];
            $thursdaydownloadables= [];
            $fridaydownloadables= [];

            foreach($mvideoos as $mvidd)
            {
              if($mvidd->type == 'mp4')
              {
                  $mondayvideos[] = $mvidd;
              }
              elseif($mvidd->type == 'pdf' || $mvidd->type == 'xls'  || $mvidd->type == 'xlsx'|| $mvidd->type == 'doc' || $mvidd->type == 'docx' || $mvidd->type == 'rtf' || $mvidd->type == 'txt')
              {
                $mondaydownloadables[] = $mvidd;
              }

            }


            foreach($tuesvideoos as $tuesvidd)
            {
              if($tuesvidd->type == 'mp4')
              {
                  $tuesdayvideos[] = $tuesvidd;
              }
              elseif($tuesvidd->type == 'pdf' || $tuesvidd->type == 'xls'  || $tuesvidd->type == 'xlsx'|| $tuesvidd->type == 'doc' || $tuesvidd->type == 'docx' || $tuesvidd->type == 'rtf' || $tuesvidd->type == 'txt')
              {
                $tuesdaydownloadables[] = $tuesvidd;
              }

            }

            foreach($wedvideoos as $wedvidd)
            {
              if($wedvidd->type == 'mp4')
              {
                  $wednesdayvideos[] = $wedvidd;
              }
              elseif($wedvidd->type == 'pdf' || $wedvidd->type == 'xls'  || $wedvidd->type == 'xlsx'|| $wedvidd->type == 'doc' || $wedvidd->type == 'docx' || $wedvidd->type == 'rtf' || $wedvidd->type == 'txt')
              {
                $wednesdaydownloadables[] = $vidd;
              }

            }

            foreach($tvideoos as $tvidd)
            {
              if($tvidd->type == 'mp4')
              {
                  $thursdayvideos[] = $tvidd;
              }
              elseif($tvidd->type == 'pdf' || $tvidd->type == 'xls'  || $tvidd->type == 'xlsx'|| $tvidd->type == 'doc' || $tvidd->type == 'docx' || $tvidd->type == 'rtf' || $tvidd->type == 'txt')
              {
                $thursdaydownloadables[] = $vidd;
              }

            }

            foreach($fvideoos as $fvidd)
            {
              if($fvidd->type == 'mp4')
              {
                  $fridayvideos[] = $fvidd;
              }
              elseif($fvidd->type == 'pdf' || $fvidd->type == 'xls'  || $fvidd->type == 'xlsx'|| $fvidd->type == 'doc' || $fvidd->type == 'docx' || $fvidd->type == 'rtf' || $fvidd->type == 'txt')
              {
                $fridaydownloadables[] = $fvidd;
              }

            }

          $mdown = count($mondaydownloadables);
          $tuesdown = count($tuesdaydownloadables);
          $weddown = count($wednesdaydownloadables);
          $tdown = count($thursdaydownloadables);
          $fdown = count($fridaydownloadables);


          $mcountVid = count($mondayvideos);
          $tuescountVid = count($tuesdayvideos);
          $wedcountVid = count($wednesdayvideos);
          $tcountVid = count($thursdayvideos);
          $fcountVid = count($fridayvideos);
      
        ?>
        <h3>Week {{$i}}</h3>

          <div class="panel-group" id="accordion">
        <!-- Monday -->

        <div class="panel panel-default" data-toggle="collapse" data-target="{{'#monday'.$i}}">

          <div class="panel-heading">

            <h4 class="panel-title">

            <a data-toggle="collapse" class=" stmp_accordion">Monday  Quizzes:{{$mondayquiz}}   Lectures:{{$mondaylec}}  Links:{{$mondaylink}}  Videos:{{$mondayvid}}</a>

            </h4>

          </div>

        </div>


          <div id="{{'monday'.$i}}"  class="collapse parent_collapse">

              <div class="panel-body">

                 
                 <!-- start videos tab -->


                <div class="panel panel-default" data-toggle="collapse" data-target="#mvideostable">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$mcountVid}} Videos</a>

                    </h4>

                  </div>

                </div>

                  <div id="mvideostable" class="collapse">

                      <div class="panel-body">



                        <div class="table_filters">

                          @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/courseresoursevideo/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add New Video</a>
                          </div>
                          @endif

                        </div>
                        @if($mcountVid > 0)

                        <div class="table_filters">

                        </div>

                        <table class="table table-hover" id="table-id">

                          <thead>

                            <tr>

                              <th scope="col">ID</th>

                              <th scope="col">Title</th>

                              <th scope="col">Video Description</th>

                              <th scope="col">Resource</th>                
                              
                              <th scope="col">Action</th>

                            </tr>

                          </thead>

                          <tbody id="mybody">

                            @foreach($mondayvideos as $index =>$cr)

                            <tr>

                        <th scope="row">#{{$index+1}}</th>

                        <td class="first_row">

                          <div class="course_td">

                            

                            <p>{{$cr->title}}</p>

                          </div>

                        </td>

                        <td class="first_row"><div class="limit_description">{{$cr->short_description}}</div></td>

                        @if($cr->type =='mp4')

                          <td class="first_row viddeo_row">
                              <!--<iframe src="{{asset('storage/'.$cr->file)}}" height="60" width="85">{{($cr->file)}}</iframe><br>-->
                          
                                                      <video controls>
                                          
                                          <source src="{{asset('storage/'.$cr->file)}}">
                                          Your browser does not support HTML5 Video.
                                        </video> <br>
                          <a class ="btn btn-primary"  href="{{asset('storage/'.$cr->file)}}" download >Download</a>

                          </td>
                        @else
                          <td class="first_row">
                              <a href="{{$cr->link}}">{{$cr->link}}</a>
                              </td>

                        @endif

                        <td class="align_ellipse first_row">

                          <li class="nav-item dropdown">

                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                              <span class="material-icons">

                                more_horiz

                              </span>

                              <div class="ripple-container"></div>

                            </a>

                             @if(auth()->user()->role_id != '5')
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                              <a class="dropdown-item" href="{{url('/resource/editvid/' . $cr->id.'/'. $cid .'/'. $clasid)}}"><i class="fa fa-cogs"></i>Edit</a>

                              <a href="javascript:void(0);" data-id="<?php echo $cr->id; ?>" class="dropdown-item deletevideo"><i class="fa fa-trash"></i>Delete</a>

                            </div>
                            @endif

                          </li>

                        </td>

                      </tr>

                            @endforeach

                          </tbody>

                        </table>  

                       @else

                        <p>There is no Video</p>

                      @endif

                      </div>

                  </div>

       

                <!-- end videos tab -->




                <!-- start links tab -->



                <div class="panel panel-default" data-toggle="collapse" data-target="#mlinkstable">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$mondaylink}} Links</a>

                    </h4>

                  </div>

            </div>


                  <div id="mlinkstable" class="collapse">

                      <div class="panel-body">



                        <div class="table_filters">
                        @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/courselink/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Link</a>
                          </div>
                          @endif

                        </div>
                        
                        @if(count($mlinks)>0)

                          <div class="table_filters">

                           <!--  <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div> -->
                            
                            <!-- <a href="{{url('/courselink/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Link</a> -->

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Title</th>

                                <th scope="col">Link Description</th>

                                <th scope="col">Links</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($mlinks as $index =>$cl)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">

                                    <p>{{$cl->title}}</p>

                                  </div>

                                </td>

                                <td class="first_row"><div class="limit_description">{{$cl->short_description}}</div></td>

                                <td class="first_row"><a href="{{$cl->link}}">{{$cl->link}}</a></td>

                                <td class="align_ellipse first_row">

                                  <li class="nav-item dropdown">

                                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                      <span class="material-icons">

                                        more_horiz

                                      </span>

                                      <div class="ripple-container"></div>

                                    </a>
                                     @if(auth()->user()->role_id != '5')
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                      <a class="dropdown-item" href="{{url('/linkedit/' . $cl->id.'/'.$cid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                      <a href="javascript:void(0);" data-id="<?php echo $cl->id; ?>" class="dropdown-item deletelink"><i class="fa fa-trash"></i>Delete</a>

                                    </div>
                                    @endif

                                  </li>

                                </td>

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                       @else

                        <p>There is no Link</p>

                      @endif

                      </div>

                  </div>

       

                     <!-- end links tabs -->


                     <!-- start lectures tab -->

                     
                  <div class="panel panel-default" data-toggle="collapse" data-target="#mtablelecture">

                    <div class="panel-heading">

                      <h4 class="panel-title">

                      <a data-toggle="collapse" class=" stmp_accordion">{{$mondaylec}} Live Lessons</a>

                      </h4>

                    </div>

                  </div>

                  <div id="mtablelecture" class="collapse">

                      <div class="panel-body">

                         

                        <div class="table_filters">
                           @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                          </div>
                          @endif

                        </div>

                        @if(count($mlectures) > 0)

                          <div class="table_filters">

                            <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div>

                         
                             

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Topic</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($mlectures as $index =>$lec)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">


                                    <p>{{$lec->topic}}</p>

                                  </div>

                                </td>

                                <td class="align_ellipse first_row">
                                      <a href="{{url('/instructor/launchmeeting/' . $lec->id .'/'. $cid)}}">
                                        <button class="btn btn-sm btn-info">
                                          <i class="fa fa-rocket" aria-hidden="true"></i>Join Lecture    
                                        </button>
                                      </a>
                                   @if(auth()->user()->role_id != '5')
                                      <a href="{{url('/instructor/edit_lecture/' .$lec->id)}}">
                                        <button class="btn btn-sm btn-success">
                                          <i class="fa fa-cogs" aria-hidden="true"></i>Edit    
                                        </button>
                                      </a>
                                      <a href="javascript:void(0);" data-id="<?php echo $lec->id; ?>" class=" deletelec">
                                        <button class="btn btn-sm btn-danger">
                                          <i class="fa fa-trash" aria-hidden="true"></i>Delete    
                                        </button>
                                      </a>
                                      @endif
                                </td>

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                        @else

                          <p>There is no Lecture</p>

                        @endif

                      </div>

                  </div>

                  <!-- end lectures tab -->


                  <!-- start quizzes tab -->

                <div class="panel panel-default" data-toggle="collapse" data-target="#tablemonday">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$mondayquiz}}  Quizzes</a>

                    </h4>

                  </div>

                </div>


                  <div id="tablemonday" class="collapse">

                      <div class="panel-body">


                        
                        <div class="table_filters">
                        @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/quiz/create/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add Quiz</a>
                          </div>
                          @endif

                        </div>
                        @if(count($mquizzes) > 0)

                          <div class="table_filters">

                            <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div>

                        

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Name</th>
                                @if(auth()->user()->role_id != '5')
                                  <th scope="col">Questions</th>

                                <th scope="col">Total Students</th>

                                <th scope="col">Attempted by</th>
                                @endif

                                <th scope="col">Quiz</th>
                                @if(auth()->user()->role_id != '5')

                                <th scope="col">Action</th>
                                @endif

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($mquizzes as $index =>$quiz)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">

                                    <p>{{$quiz->name}}</p>

                                  </div>

                                </td>

                                @if(auth()->user()->role_id != '5')
                                  <td class="first_row">
                                    <?php
                                      $check_quiz = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->get()->first();
                                    ?>
                                    @if($check_quiz != null)
                                        <button type="button" class="btn btn-success" disabled>Add questions</button>
                                      @else
                                        <a href="{{url('/quiz/addquestion/toquiz/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id .'/'. $clasid)}}" class="btn btn-success" > Add questions</a>
                                    @endif
                                  </td>

                                  <?php
                                    $totalStudents = DB::table('class_course_students')->where('course_id', $cid)->where('class_id', $clasid)->pluck('std_id')->toArray();
                                    $ts = count($totalStudents);

                                    $attemptesBy = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->pluck('student_id')->unique();
                                    $atmpted = count($attemptesBy);

                                  ?>
                                  <td class="first_row">
                                      {{$ts}}
                                  </td>

                                  <td class="first_row">
                                    {{$atmpted}}

                                    @if($atmpted > 0)
                                      <a class="btn btn-sm btn-warning" href="{{url('/quiz/attempted_by/'. $quiz->id .'/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}"><i class="fa fa-eye"></i></a>
                                    @endif
                                  </td>
                                @endif
                                @if(auth()->user()->role_id != '5')

                                <td class="first_row">
                                  <a href="{{url('/quiz/showquiz/'.$quiz->id)}}" class="btn btn-success">Show</a>
                                </td>
                                @else
                                <td class="first_row">
                                  <a href="{{url('/quiz/solve_quiz_student/'.$quiz->id .'/'. $cid)}}" class="btn btn-success">Show</a>
                                </td>
                                @endif
                                @if(auth()->user()->role_id != '5')


                                  <td class="align_ellipse first_row">

                                    <li class="nav-item dropdown">

                                      <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <span class="material-icons">

                                          more_horiz

                                        </span>

                                        <div class="ripple-container"></div>

                                      </a>

                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                        <a class="dropdown-item" href="{{url('/quiz/edit/quiz_questions/'.$quiz->id)}}"><i class="fa fa-cogs"></i>Edit Quiz Questions</a>

                                        <a class="dropdown-item" href="{{url('/mcq/create/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id)}}"><i class="fa fa-plus"></i>Create Questions</a>

                                        <a class="dropdown-item" href="{{url('/upload_quiz_questions/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id)}}"><i class="fa fa-plus"></i>Upload Questions (.xlsx)</a>

                                        <a class="dropdown-item" href="{{url('/quiz/edit/'.$quiz->id .'/'. $clasid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                        <a href="javascript:void(0);" data-id="<?php echo $quiz->id; ?>" class="dropdown-item deletequiz"><i class="fa fa-trash"></i>Delete</a>

                                      </div>

                                    </li>

                                  </td>
                                @endif

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                       @else

                        <p>There is no Quiz</p>

                      @endif

                      </div>

                  </div>

                

               



                

                <!-- end discussions tab -->



                  <!-- start downloads tabs -->


                  <div class="panel panel-default" data-toggle="collapse" data-target="#mdownloadablestable">

                    <div class="panel-heading">

                      <h4 class="panel-title">

                      <a data-toggle="collapse" class=" stmp_accordion">{{$mdown}} Downloadables</a>

                      </h4>

                    </div>

                  </div>

                    <div id="mdownloadablestable" class="collapse">

                        <div class="panel-body">



                          <div class="table_filters">

                             @if(auth()->user()->role_id != '5')
                            <div>
                              <a href="{{url('/courseresourse/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add New Downloadable</a>
                            </div>
                            @endif

                          </div>

                          @if($mdown>0)

                            <div class="table_filters">

                              <!-- <div class="table_search">

                                <input type="text" name="search" id="search" value="" placeholder="Search...">

                                <a href="#"> <i class="fa fa-search"></i> </a>
                                
                              </div> -->
                              
                            </div>

                            <table class="table table-hover" id="table-id">

                              <thead>

                                <tr>

                                  <th scope="col">ID</th>

                                  <th scope="col">Title</th>

                                  <th scope="col">File Description</th>

                                  <th scope="col">File</th>

                                  <th scope="col">Downloadable</th>

                                  <th scope="col">Action</th>

                                </tr>

                              </thead>

                              <tbody id="mybody">

                                @foreach($mondaydownloadables as $index =>$cr)

                                  @if ($cr->type=='pdf' || $cr->type=='docx' || $cr->type=='odt' || $cr->type=='xlsx' || $cr->type=='pptx' || $cr->type=='txt' || $cr->type=='jpg' || $cr->type=='jpeg' || $cr->type=='png' || $cr->type=='gif')

                                  <tr>

                                    <th scope="row">#{{$index+1}}</th>

                                    <td class="first_row">

                                      <div class="course_td">

                                        <p>{{$cr->title}}</p>

                                      </div>

                                    </td>

                                    <td class="first_row">{{$cr->short_description}}</td>

                                        @if ($cr->type=='pdf')

                                          <td class="first_row">
                                            <embed src="{{asset('storage/'.$cr->file)}}" type="application/pdf" height="50" width="50">
                                          </td>

                                        @elseif ($cr->type=='docx'|| $cr->type=='odt' || $cr->type=='xlsx' || $cr->type=='pptx' || $cr->type=='txt')                        
                                          <td>
                                          
                                                  <!-- 
                                          <iframe src="http://tonylea.com" width="100" height="100"></iframe>
                                                -->

                                          <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{asset('storage/'.$cr->file)}}" width='100px' height='100px'></iframe>


                                          </td>

                                        @elseif ($cr->type=='png'|| $cr->type=='jpeg' || $cr->type=='jpg' || $cr->type=='gif' )

                                          <td class="first_row">

                                            <img src="{{asset('storage/'.$cr->file)}}" height="50" width="50">

                                          </td>

                                         @endif
                                     @if(auth()->user()->role_id != '5')
                                    <td class="first_row"><a href="{{asset('storage/'.$cr->file)}}"  class="btn btn-primary"download>Download</a></td>
                                    @endif
                                    <td class="align_ellipse first_row">

                                      <li class="nav-item dropdown">

                                        <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                          <span class="material-icons">

                                            more_horiz

                                          </span>

                                          <div class="ripple-container"></div>

                                        </a>
                                         @if(auth()->user()->role_id != '5')
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                          <a class="dropdown-item" href="{{url('/resource/edit/' . $cr->id.'/'.$cid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                          <a href="javascript:void(0);" data-id="<?php echo $cr->id; ?>" class="dropdown-item deletedown"><i class="fa fa-trash"></i>Delete</a>

                                        </div>
                                        @endif

                                      </li>

                                    </td>

                                  </tr>

                                  @endif

                                @endforeach

                              </tbody>

                            </table>  

                         @else

                          <p>There is no Downloadable data</p>

                        @endif

                        </div>

                    </div>

                  </div>


                  <!-- end downloads tab -->


              </div>

          

          <!-- Monday end -->





        <!-- Tuesday -->

        <div class="panel panel-default" data-toggle="collapse" data-target="{{'#tuesday'.$i}}">

          <div class="panel-heading">

            <h4 class="panel-title">

            <a data-toggle="collapse" class=" stmp_accordion">Tuesday Quizzes:{{$tuesdayquiz}}   Lectures:{{$tuesdaylec}}  Links:{{$tuesdaylink}}  Videos:{{$tuesdayvid}}</a>

            </h4>

          </div>

        </div>


          <div id="{{'tuesday'.$i}}" class="collapse parent_collapse">

              <div class="panel-body">

                 
                 <!-- start videos tab -->


                <div class="panel panel-default" data-toggle="collapse" data-target="#tuesvideostable">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$tuescountVid}} Videos</a>

                    </h4>

                  </div>

                </div>

                  <div id="tuesvideostable" class="collapse">

                      <div class="panel-body">



                        <div class="table_filters">

                           @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/courseresoursevideo/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add New Video</a>
                          </div>
                          @endif

                        </div>
                        @if($tuescountVid > 0)

                        <div class="table_filters">

                          <!-- <div class="table_search">

                            <input type="text" name="search" id="search" value="" placeholder="Search...">

                            <a href="#"> <i class="fa fa-search"></i> </a>
                            
                          </div> -->
                          <!-- <a href="{{url('/courseresoursevideo/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Video</a> -->
                        </div>

                        <table class="table table-hover" id="table-id">

                          <thead>

                            <tr>

                              <th scope="col">ID</th>

                              <th scope="col">Title</th>

                              <th scope="col">Video Description</th>

                              <th scope="col">Resource</th>                
                              
                              <th scope="col">Action</th>

                            </tr>

                          </thead>

                          <tbody id="mybody">

                            @foreach($tuesdayvideos as $index =>$cr)

                            <tr>

                        <th scope="row">#{{$index+1}}</th>

                        <td class="first_row">

                          <div class="course_td">

                            

                            <p>{{$cr->title}}</p>

                          </div>

                        </td>

                        <td class="first_row"><div class="limit_description">{{$cr->short_description}}</div></td>

                        @if($cr->type =='mp4')

                          <td class="first_row viddeo_row">
                              <!--<iframe src="{{asset('storage/'.$cr->file)}}" height="60" width="85">{{($cr->file)}}</iframe><br>-->
                          
                                                      <video controls>
                                          
                                          <source src="{{asset('storage/'.$cr->file)}}">
                                          Your browser does not support HTML5 Video.
                                        </video> <br>

                          <a class ="btn btn-primary"  href="{{asset('storage/'.$cr->file)}}" download >Download</a>

                          </td>
                        @else
                          <td class="first_row">
                              <a href="{{$cr->link}}">{{$cr->link}}</a>
                              </td>

                        @endif

                        <td class="align_ellipse first_row">

                          <li class="nav-item dropdown">

                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                              <span class="material-icons">

                                more_horiz

                              </span>

                              <div class="ripple-container"></div>

                            </a>
                             @if(auth()->user()->role_id != '5')
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                              <a class="dropdown-item" href="{{url('/resource/editvid/' . $cr->id.'/'. $cid .'/'. $clasid)}}"><i class="fa fa-cogs"></i>Edit</a>

                              <a href="javascript:void(0);" data-id="<?php echo $cr->id; ?>" class="dropdown-item deletevideo"><i class="fa fa-trash"></i>Delete</a>

                            </div>
                            @endif

                          </li>

                        </td>

                      </tr>

                            @endforeach

                          </tbody>

                        </table>  

                       @else

                        <p>There is no Video</p>

                      @endif

                      </div>

                  </div>

       

                <!-- end videos tab -->




                <!-- start links tab -->



                <div class="panel panel-default" data-toggle="collapse" data-target="#tueslinkstable">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$tuesdaylink}} Links</a>

                    </h4>

                  </div>

            </div>


                  <div id="tueslinkstable" class="collapse">

                      <div class="panel-body">



                        <div class="table_filters">
                           @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/courselink/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Link</a>
                          </div>
                          @endif

                        </div>
                        
                        @if(count($tueslinks)>0)

                          <div class="table_filters">

                           <!--  <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div> -->
                            
                            <!-- <a href="{{url('/courselink/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Link</a> -->

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Title</th>

                                <th scope="col">Link Description</th>

                                <th scope="col">Links</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($tueslinks as $index =>$cl)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">

                                    <p>{{$cl->title}}</p>

                                  </div>

                                </td>

                                <td class="first_row"><div class="limit_description">{{$cl->short_description}}</div></td>

                                <td class="first_row"><a href="{{$cl->link}}">{{$cl->link}}</a></td>

                                <td class="align_ellipse first_row">

                                  <li class="nav-item dropdown">

                                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                      <span class="material-icons">

                                        more_horiz

                                      </span>

                                      <div class="ripple-container"></div>

                                    </a>
                                   @if(auth()->user()->role_id != '5')
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                      <a class="dropdown-item" href="{{url('/linkedit/' . $cl->id.'/'.$cid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                      <a href="javascript:void(0);" data-id="<?php echo $cl->id; ?>" class="dropdown-item deletelink"><i class="fa fa-trash"></i>Delete</a>

                                    </div>
                                    @endif

                                  </li>

                                </td>

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                       @else

                        <p>There is no Link</p>

                      @endif

                      </div>

                  </div>

       

                     <!-- end links tabs -->


                     <!-- start lectures tab -->


                  <div class="panel panel-default" data-toggle="collapse" data-target="#tuestablelecture">

                    <div class="panel-heading">

                      <h4 class="panel-title">

                      <a data-toggle="collapse" class=" stmp_accordion">{{$tuesdaylec}} Live Lessons</a>

                      </h4>

                    </div>

                  </div>

                  <div id="tuestablelecture" class="collapse">

                      <div class="panel-body">

                         

                        <div class="table_filters">
                           @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                          </div>
                          @endif

                        </div>

                        @if(count($tueslectures) > 0)

                          <div class="table_filters">

                            <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div>

                          <!--   <div>
                              <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                            </div> -->
                             @if(auth()->user()->role_id != '5')
                            <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                            @endif

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Topic</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($tueslectures as $index =>$lec)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">


                                    <p>{{$lec->topic}}</p>

                                  </div>

                                </td>
                                <td class="align_ellipse first_row">
                                      <a href="{{url('/instructor/launchmeeting/' . $lec->id .'/'. $cid)}}">
                                        <button class="btn btn-sm btn-info">
                                          <i class="fa fa-rocket" aria-hidden="true"></i>Join Lecture    
                                        </button>
                                      </a>
                                 @if(auth()->user()->role_id != '5')
                                      <a href="{{url('/instructor/edit_lecture/' .$lec->id)}}">
                                        <button class="btn btn-sm btn-success">
                                          <i class="fa fa-cogs" aria-hidden="true"></i>Edit    
                                        </button>
                                      </a>
                                      <a href="javascript:void(0);" data-id="<?php echo $lec->id; ?>" class=" deletelec">
                                        <button class="btn btn-sm btn-danger">
                                          <i class="fa fa-trash" aria-hidden="true"></i>Delete    
                                        </button>
                                      </a>
                                </td>
                                @endif

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                        @else

                          <p>There is no Lecture</p>

                        @endif

                      </div>

                  </div>

                  <!-- end lectures tab -->


                  <!-- start quizzes tab -->

                <div class="panel panel-default" data-toggle="collapse" data-target="#tabletuesday">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$tuesdayquiz}}  Quizzes</a>

                    </h4>

                  </div>

                </div>


                  <div id="tabletuesday" class="collapse">

                      <div class="panel-body">


                        
                        <div class="table_filters">
                           @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/quiz/create/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add Quiz</a>
                          </div>
                          @endif

                        </div>
                        @if(count($tuesquizzes) > 0)

                          <div class="table_filters">

                            <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div>

                        <!-- <a href="{{url('/quiz/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add Quiz</a> -->

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Name</th>

                                <th scope="col">Questions</th>

                                <th scope="col">Total Students</th>

                                <th scope="col">Attempted by</th>

                                <th scope="col">Quiz</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($tuesquizzes as $index =>$quiz)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">

                                    <p>{{$quiz->name}}</p>

                                  </div>

                                </td>

                                <td class="first_row">
                                  <?php
                                    $check_quiz = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->get()->first();
                                  ?>
                                  @if($check_quiz != null)
                                 @if(auth()->user()->role_id != '5')
                                  <button type="button" class="btn btn-success" disabled>Add questions</button>
                                  @else
                                    <a href="{{url('/quiz/addquestion/toquiz/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id .'/'. $clasid)}}" class="btn btn-success" > Add questions</a>
                                  @endif
                                  @endif
                                </td>

                                <?php
                                  $totalStudents = DB::table('class_course_students')->where('course_id', $cid)->where('class_id', $clasid)->pluck('std_id')->toArray();
                                  $ts = count($totalStudents);

                                  $attemptesBy = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->pluck('student_id')->unique();
                                  $atmpted = count($attemptesBy);

                                ?>
                                <td class="first_row">
                                    {{$ts}}
                                </td>

                                <td class="first_row">
                                  {{$atmpted}}

                                  @if($atmpted > 0)
                                    <a class="btn btn-sm btn-warning" href="{{url('/quiz/attempted_by/'. $quiz->id .'/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}"><i class="fa fa-eye"></i></a>
                                  @endif
                                </td>

                                <td class="first_row">
                                  <a href="{{url('/quiz/showquiz/'.$quiz->id)}}" class="btn btn-success">Show</a>
                                </td>

                                <td class="align_ellipse first_row">

                                  <li class="nav-item dropdown">

                                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                      <span class="material-icons">

                                        more_horiz

                                      </span>

                                      <div class="ripple-container"></div>

                                    </a>
                                    @if(auth()->user()->role_id != '5')
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                      <a class="dropdown-item" href="{{url('/quiz/edit/quiz_questions/'.$quiz->id)}}"><i class="fa fa-cogs"></i>Edit Quiz Questions</a>

                                      <a class="dropdown-item" href="{{url('/mcq/create/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id)}}"><i class="fa fa-plus"></i>Create Questions</a>

                                      <a class="dropdown-item" href="{{url('/upload_quiz_questions/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id)}}"><i class="fa fa-plus"></i>Upload Questions (.xlsx)</a>

                                      <a class="dropdown-item" href="{{url('/quiz/edit/'.$quiz->id .'/'. $clasid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                      <a href="javascript:void(0);" data-id="<?php echo $quiz->id; ?>" class="dropdown-item deletequiz"><i class="fa fa-trash"></i>Delete</a>

                                    </div>
                                    @endif

                                  </li>

                                </td>

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                       @else

                        <p>There is no Quiz</p>

                      @endif

                      </div>

                  </div>

                

                <!-- end quizzes tab -->

                <!-- start discussions tab -->



                  <div id="tuestablediscussions" class="collapse">

                      <div class="panel-body">


                        
                        <div class="table_filters">

                        </div>

                        <p>There is no Discussion yet.</p>

                      </div>

                  </div>

                

                <!-- end discussions tab -->



          <!-- start downloads tabs -->


          <div class="panel panel-default" data-toggle="collapse" data-target="#tuesdownloadablestable">

            <div class="panel-heading">

              <h4 class="panel-title">

              <a data-toggle="collapse" class=" stmp_accordion">{{$tuesdown}} Downloadables</a>

              </h4>

            </div>

          </div>

          <div id="tuesdownloadablestable" class="collapse">

              <div class="panel-body">



                <div class="table_filters">

                  @if(auth()->user()->role_id != '5')
                  <div>
                    <a href="{{url('/courseresourse/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add New Downloadable</a>
                  </div>
                  @endif

                </div>

                @if($tuesdown>0)

                  <div class="table_filters">

                    <!-- <div class="table_search">

                      <input type="text" name="search" id="search" value="" placeholder="Search...">

                      <a href="#"> <i class="fa fa-search"></i> </a>
                      
                    </div> -->
                    
                  </div>

                  <table class="table table-hover" id="table-id">

                    <thead>

                      <tr>

                        <th scope="col">ID</th>

                        <th scope="col">Title</th>

                        <th scope="col">File Description</th>

                        <th scope="col">File</th>

                        <th scope="col">Downloadable</th>

                        <th scope="col">Action</th>

                      </tr>

                    </thead>

                    <tbody id="mybody">

                      @foreach($tuesdaydownloadables as $index =>$cr)

                        @if ($cr->type=='pdf' || $cr->type=='docx' || $cr->type=='odt' || $cr->type=='xlsx' || $cr->type=='pptx' || $cr->type=='txt' || $cr->type=='jpg' || $cr->type=='jpeg' || $cr->type=='png' || $cr->type=='gif')

                        <tr>

                          <th scope="row">#{{$index+1}}</th>

                          <td class="first_row">

                            <div class="course_td">

                              <p>{{$cr->title}}</p>

                            </div>

                          </td>

                          <td class="first_row">{{$cr->short_description}}</td>

                              @if ($cr->type=='pdf')

                                <td class="first_row">
                                  <embed src="{{asset('storage/'.$cr->file)}}" type="application/pdf" height="50" width="50">
                                </td>

                              @elseif ($cr->type=='docx'|| $cr->type=='odt' || $cr->type=='xlsx' || $cr->type=='pptx' || $cr->type=='txt')                        
                                <td>
                                
                                        <!-- 
                                <iframe src="http://tonylea.com" width="100" height="100"></iframe>
                                      -->

                                <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{asset('storage/'.$cr->file)}}" width='100px' height='100px'></iframe>


                                </td>

                              @elseif ($cr->type=='png'|| $cr->type=='jpeg' || $cr->type=='jpg' || $cr->type=='gif' )

                                <td class="first_row">

                                  <img src="{{asset('storage/'.$cr->file)}}" height="50" width="50">

                                </td>

                               @endif

                          <td class="first_row"><a href="{{asset('storage/'.$cr->file)}}"  class="btn btn-primary"download>Download</a></td>

                          <td class="align_ellipse first_row">

                            <li class="nav-item dropdown">

                              <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <span class="material-icons">

                                  more_horiz

                                </span>

                                <div class="ripple-container"></div>

                              </a>
                               @if(auth()->user()->role_id != '5')
                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                <a class="dropdown-item" href="{{url('/resource/edit/' . $cr->id.'/'.$cid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                <a href="javascript:void(0);" data-id="<?php echo $cr->id; ?>" class="dropdown-item deletedown"><i class="fa fa-trash"></i>Delete</a>

                              </div>
                              @endif

                            </li>

                          </td>

                        </tr>

                        @endif

                      @endforeach

                    </tbody>

                  </table>  

               @else

                <p>There is no Downloadable data</p>

              @endif

              </div>

          </div>

        </div>


        <!-- end downloads tab -->


              </div>


          <!-- Tuesday end -->



        <!-- Wednesdays -->

        <div class="panel panel-default" data-toggle="collapse" data-target="{{'#wednesday'.$i}}">

          <div class="panel-heading">

            <h4 class="panel-title">

            <a data-toggle="collapse" class=" stmp_accordion">Wednesday  Quizzes:{{$wednesdayquiz}}   Lectures:{{$wednesdaylec}}  Links:{{$wednesdaylink}}  Videos:{{$wednesdayvid}}</a>

            </h4>

          </div>

        </div>


          <div id="{{'wednesday'.$i}}" class="collapse parent_collapse">

              <div class="panel-body">

                 
                 <!-- start videos tab -->


                <div class="panel panel-default" data-toggle="collapse" data-target="#wedvideostable">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$wedcountVid}} Videos</a>

                    </h4>

                  </div>

                </div>

                  <div id="wedvideostable" class="collapse">

                      <div class="panel-body">



                        <div class="table_filters">

                          @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/courseresoursevideo/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add New Video</a>
                          </div>
                          @endif

                        </div>
                        @if($wedcountVid > 0)

                        <div class="table_filters">

                          <!-- <div class="table_search">

                            <input type="text" name="search" id="search" value="" placeholder="Search...">

                            <a href="#"> <i class="fa fa-search"></i> </a>
                            
                          </div> -->
                          <!-- <a href="{{url('/courseresoursevideo/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Video</a> -->
                        </div>

                        <table class="table table-hover" id="table-id">

                          <thead>

                            <tr>

                              <th scope="col">ID</th>

                              <th scope="col">Title</th>

                              <th scope="col">Video Description</th>

                              <th scope="col">Resource</th>                
                              
                              <th scope="col">Action</th>

                            </tr>

                          </thead>

                          <tbody id="mybody">

                            @foreach($wednesdayvideos as $index =>$cr)

                            <tr>

                        <th scope="row">#{{$index+1}}</th>

                        <td class="first_row">

                          <div class="course_td">

                            

                            <p>{{$cr->title}}</p>

                          </div>

                        </td>

                        <td class="first_row"><div class="limit_description">{{$cr->short_description}}</div></td>

                        @if($cr->type =='mp4')

                          <td class="first_row viddeo_row">
                              <!--<iframe src="{{asset('storage/'.$cr->file)}}" height="60" width="85">{{($cr->file)}}</iframe><br>-->
                          
                                                      <video controls>
                                          
                                          <source src="{{asset('storage/'.$cr->file)}}">
                                          Your browser does not support HTML5 Video.
                                        </video> <br>
                          <a class ="btn btn-primary"  href="{{asset('storage/'.$cr->file)}}" download >Download</a>

                          </td>
                        @else
                          <td class="first_row">
                              <a href="{{$cr->link}}">{{$cr->link}}</a>
                              </td>

                        @endif

                        <td class="align_ellipse first_row">

                          <li class="nav-item dropdown">

                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                              <span class="material-icons">

                                more_horiz

                              </span>

                              <div class="ripple-container"></div>

                            </a>
                             @if(auth()->user()->role_id != '5')
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                              <a class="dropdown-item" href="{{url('/resource/editvid/' . $cr->id.'/'. $cid .'/'. $clasid)}}"><i class="fa fa-cogs"></i>Edit</a>

                              <a href="javascript:void(0);" data-id="<?php echo $cr->id; ?>" class="dropdown-item deletevideo"><i class="fa fa-trash"></i>Delete</a>

                            </div>
                            @endif

                          </li>

                        </td>

                      </tr>

                            @endforeach

                          </tbody>

                        </table>  

                       @else

                        <p>There is no Video</p>

                      @endif

                      </div>

                  </div>

       

                <!-- end videos tab -->




                <!-- start links tab -->



                <div class="panel panel-default" data-toggle="collapse" data-target="#wedlinkstable">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$wednesdaylink}} Links</a>

                    </h4>

                  </div>

                </div>


                  <div id="wedlinkstable" class="collapse">

                      <div class="panel-body">



                        <div class="table_filters">
                           @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/courselink/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Link</a>
                          </div>
                          @endif

                        </div>
                        
                        @if(count($wedlinks)>0)

                          <div class="table_filters">

                           <!--  <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div> -->
                            
                            <!-- <a href="{{url('/courselink/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Link</a> -->

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Title</th>

                                <th scope="col">Link Description</th>

                                <th scope="col">Links</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($wedlinks as $index =>$cl)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">

                                    <p>{{$cl->title}}</p>

                                  </div>

                                </td>

                                <td class="first_row"><div class="limit_description">{{$cl->short_description}}</div></td>

                                <td class="first_row"><a href="{{$cl->link}}">{{$cl->link}}</a></td>

                                <td class="align_ellipse first_row">

                                  <li class="nav-item dropdown">

                                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                      <span class="material-icons">

                                        more_horiz

                                      </span>

                                      <div class="ripple-container"></div>

                                    </a>
                                     @if(auth()->user()->role_id != '5')
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                      <a class="dropdown-item" href="{{url('/linkedit/' . $cl->id.'/'.$cid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                      <a href="javascript:void(0);" data-id="<?php echo $cl->id; ?>" class="dropdown-item deletelink"><i class="fa fa-trash"></i>Delete</a>

                                    </div>
                                    @endif

                                  </li>

                                </td>

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                       @else

                        <p>There is no Link</p>

                      @endif

                      </div>

                  </div>

       

                     <!-- end links tabs -->


                     <!-- start lectures tab -->


                  <div class="panel panel-default" data-toggle="collapse" data-target="#wedtablelecture">

                    <div class="panel-heading">

                      <h4 class="panel-title">

                      <a data-toggle="collapse" class=" stmp_accordion">{{$wednesdaylec}} Live Lessons</a>

                      </h4>

                    </div>

                  </div>

                  <div id="wedtablelecture" class="collapse">

                      <div class="panel-body">

                         

                        <div class="table_filters">
                           @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                          </div>
                          @endif

                        </div>

                        @if(count($wedlectures) > 0)

                          <div class="table_filters">

                            <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div>

                          <!--   <div>
                              <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                            </div> -->
                             @if(auth()->user()->role_id != '5')
                            <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                            @endif

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Topic</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($wedlectures as $index =>$lec)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">


                                    <p>{{$lec->topic}}</p>

                                  </div>

                                </td>
                                <td class="align_ellipse first_row">
                                      <a href="{{url('/instructor/launchmeeting/' . $lec->id .'/'. $cid)}}">
                                        <button class="btn btn-sm btn-info">
                                          <i class="fa fa-rocket" aria-hidden="true"></i>Join Lecture    
                                        </button>
                                      </a>
                                 @if(auth()->user()->role_id != '5')
                                      <a href="{{url('/instructor/edit_lecture/' .$lec->id)}}">
                                        <button class="btn btn-sm btn-success">
                                          <i class="fa fa-cogs" aria-hidden="true"></i>Edit    
                                        </button>
                                      </a>
                                      <a href="javascript:void(0);" data-id="<?php echo $lec->id; ?>" class=" deletelec">
                                        <button class="btn btn-sm btn-danger">
                                          <i class="fa fa-trash" aria-hidden="true"></i>Delete    
                                        </button>
                                      </a>
                                </td>
                                @endif

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                        @else

                          <p>There is no Lecture</p>

                        @endif

                      </div>

                  </div>

                  <!-- end lectures tab -->


                  <!-- start quizzes tab -->

                <div class="panel panel-default" data-toggle="collapse" data-target="#tablewednesday">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$wednesdayquiz}}  Quizzes</a>

                    </h4>

                  </div>

                </div>


                  <div id="tablewednesday" class="collapse">

                      <div class="panel-body">


                        
                        <div class="table_filters">
                            @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/quiz/create/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add Quiz</a>
                          </div>
                          @endif

                        </div>
                        @if(count($wedquizzes) > 0)

                          <div class="table_filters">

                            <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div>

                        <!-- <a href="{{url('/quiz/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add Quiz</a> -->

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Name</th>

                                <th scope="col">Questions</th>

                                <th scope="col">Total Students</th>

                                <th scope="col">Attempted by</th>

                                <th scope="col">Quiz</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($wedquizzes as $index =>$quiz)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">

                                    <p>{{$quiz->name}}</p>

                                  </div>

                                </td>

                                <td class="first_row">
                                  <?php
                                    $check_quiz = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->get()->first();
                                  ?>
                                  @if($check_quiz != null)
                      @if(auth()->user()->role_id != '5')
                                  <button type="button" class="btn btn-success" disabled>Add questions</button>
                                  @else
                                    <a href="{{url('/quiz/addquestion/toquiz/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id .'/'. $clasid)}}" class="btn btn-success" > Add questions</a>
                                  @endif
                                  @endif
                                </td>

                                <?php
                                  $totalStudents = DB::table('class_course_students')->where('course_id', $cid)->where('class_id', $clasid)->pluck('std_id')->toArray();
                                  $ts = count($totalStudents);

                                  $attemptesBy = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->pluck('student_id')->unique();
                                  $atmpted = count($attemptesBy);

                                ?>
                                <td class="first_row">
                                    {{$ts}}
                                </td>

                                <td class="first_row">
                                  {{$atmpted}}

                                  @if($atmpted > 0)
                                    <a class="btn btn-sm btn-warning" href="{{url('/quiz/attempted_by/'. $quiz->id .'/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}"><i class="fa fa-eye"></i></a>
                                  @endif
                                </td>

                                <td class="first_row">
                                  <a href="{{url('/quiz/showquiz/'.$quiz->id)}}" class="btn btn-success">Show</a>
                                </td>

                                <td class="align_ellipse first_row">

                                  <li class="nav-item dropdown">

                                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                      <span class="material-icons">

                                        more_horiz

                                      </span>

                                      <div class="ripple-container"></div>

                                    </a>
                                     @if(auth()->user()->role_id != '5')
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                      <a class="dropdown-item" href="{{url('/quiz/edit/quiz_questions/'.$quiz->id)}}"><i class="fa fa-cogs"></i>Edit Quiz Questions</a>

                                      <a class="dropdown-item" href="{{url('/mcq/create/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id)}}"><i class="fa fa-plus"></i>Create Questions</a>

                                      <a class="dropdown-item" href="{{url('/upload_quiz_questions/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id)}}"><i class="fa fa-plus"></i>Upload Questions (.xlsx)</a>

                                      <a class="dropdown-item" href="{{url('/quiz/edit/'.$quiz->id .'/'. $clasid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                      <a href="javascript:void(0);" data-id="<?php echo $quiz->id; ?>" class="dropdown-item deletequiz"><i class="fa fa-trash"></i>Delete</a>

                                    </div>
                                    @endif

                                  </li>

                                </td>

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                       @else

                        <p>There is no Quiz</p>

                      @endif

                      </div>

                  </div>

                

                <!-- end quizzes tab -->

                <!-- start discussions tab -->

                <div class="panel panel-default" data-toggle="collapse" data-target="#wedtablediscussions">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">Discussions</a>

                    </h4>

                  </div>

                </div>


                  

                

                <!-- end discussions tab -->



                <!-- start downloads tabs -->


                <div class="panel panel-default" data-toggle="collapse" data-target="#weddownloadablestable">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$weddown}} Downloadables</a>

                    </h4>

                  </div>

                </div>

                  <div id="weddownloadablestable" class="collapse">

                      <div class="panel-body">



                        <div class="table_filters">

                           @if(auth()->user()->role_id != '5')
                          <div>
                            <a href="{{url('/courseresourse/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add New Downloadable</a>
                          </div>
                          @endif

                        </div>

                        @if($weddown>0)

                          <div class="table_filters">

                            <!-- <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div> -->
                            
                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Title</th>

                                <th scope="col">File Description</th>

                                <th scope="col">File</th>

                                <th scope="col">Downloadable</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($wednesdaydownloadables as $index =>$cr)

                                @if ($cr->type=='pdf' || $cr->type=='docx' || $cr->type=='odt' || $cr->type=='xlsx' || $cr->type=='pptx' || $cr->type=='txt' || $cr->type=='jpg' || $cr->type=='jpeg' || $cr->type=='png' || $cr->type=='gif')

                                <tr>

                                  <th scope="row">#{{$index+1}}</th>

                                  <td class="first_row">

                                    <div class="course_td">

                                      <p>{{$cr->title}}</p>

                                    </div>

                                  </td>

                                  <td class="first_row">{{$cr->short_description}}</td>

                                      @if ($cr->type=='pdf')

                                        <td class="first_row">
                                          <embed src="{{asset('storage/'.$cr->file)}}" type="application/pdf" height="50" width="50">
                                        </td>

                                      @elseif ($cr->type=='docx'|| $cr->type=='odt' || $cr->type=='xlsx' || $cr->type=='pptx' || $cr->type=='txt')                        
                                        <td>
                                        
                                                <!-- 
                                        <iframe src="http://tonylea.com" width="100" height="100"></iframe>
                                              -->

                                        <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{asset('storage/'.$cr->file)}}" width='100px' height='100px'></iframe>


                                        </td>

                                      @elseif ($cr->type=='png'|| $cr->type=='jpeg' || $cr->type=='jpg' || $cr->type=='gif' )

                                        <td class="first_row">

                                          <img src="{{asset('storage/'.$cr->file)}}" height="50" width="50">

                                        </td>

                                       @endif

                                  <td class="first_row"><a href="{{asset('storage/'.$cr->file)}}"  class="btn btn-primary"download>Download</a></td>

                                  <td class="align_ellipse first_row">

                                    <li class="nav-item dropdown">

                                      <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <span class="material-icons">

                                          more_horiz

                                        </span>

                                        <div class="ripple-container"></div>

                                      </a>
                                       @if(auth()->user()->role_id != '5')
                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                        <a class="dropdown-item" href="{{url('/resource/edit/' . $cr->id.'/'.$cid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                        <a href="javascript:void(0);" data-id="<?php echo $cr->id; ?>" class="dropdown-item deletedown"><i class="fa fa-trash"></i>Delete</a>

                                      </div>
                                      @endif

                                    </li>

                                  </td>

                                </tr>

                                @endif

                              @endforeach

                            </tbody>

                          </table>  

                       @else

                        <p>There is no Downloadable data</p>

                      @endif

                      </div>

                  </div>

                </div>


                <!-- end downloads tab -->


                  </div>


          <!-- Wednesday end -->





                  <!-- Thursday -->

              <div class="panel panel-default" data-toggle="collapse" data-target="{{'#thursday'.$i}}">

                <div class="panel-heading">

                  <h4 class="panel-title">

                  <a data-toggle="collapse" class=" stmp_accordion">Thursday  Quizzes:{{$thursdayquiz}}   Lectures:{{$thursdaylec}}  Links:{{$thursdaylink}}  Videos:{{$thursdayvid}}</a>

                  </h4>

                </div>

              </div>


          <div id="{{'thursday'.$i}}" class="collapse parent_collapse">

              <div class="panel-body">

                 
                 <!-- start videos tab -->


                <div class="panel panel-default" data-toggle="collapse" data-target="#tvideostable">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$tcountVid}} Videos</a>

                    </h4>

                  </div>

                </div>

                  <div id="tvideostable" class="collapse">

                      <div class="panel-body">



                        <div class="table_filters">

                              @if(auth()->user()->role_id != '5')

                          <div>
                            <a href="{{url('/courseresoursevideo/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add New Video</a>
                          </div>
                          @endif

                        </div>
                        @if($tcountVid > 0)

                        <div class="table_filters">

                          <!-- <div class="table_search">

                            <input type="text" name="search" id="search" value="" placeholder="Search...">

                            <a href="#"> <i class="fa fa-search"></i> </a>
                            
                          </div> -->
                          <!-- <a href="{{url('/courseresoursevideo/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Video</a> -->
                        </div>

                        <table class="table table-hover" id="table-id">

                          <thead>

                            <tr>

                              <th scope="col">ID</th>

                              <th scope="col">Title</th>

                              <th scope="col">Video Description</th>

                              <th scope="col">Resource</th>                
                              
                              <th scope="col">Action</th>

                            </tr>

                          </thead>

                          <tbody id="mybody">

                            @foreach($thursdayvideos as $index =>$cr)

                            <tr>

                        <th scope="row">#{{$index+1}}</th>

                        <td class="first_row">

                          <div class="course_td">

                            

                            <p>{{$cr->title}}</p>

                          </div>

                        </td>

                        <td class="first_row"><div class="limit_description">{{$cr->short_description}}</div></td>

                        @if($cr->type =='mp4')

                          <td class="first_row viddeo_row">
                              <!--<iframe src="{{asset('storage/'.$cr->file)}}" height="60" width="85">{{($cr->file)}}</iframe><br>-->
                          
                                                      <video controls>
                                          
                                          <source src="{{asset('storage/'.$cr->file)}}">
                                          Your browser does not support HTML5 Video.
                                        </video> <br>
                          <a class ="btn btn-primary"  href="{{asset('storage/'.$cr->file)}}" download >Download</a>

                          </td>
                        @else
                          <td class="first_row">
                              <a href="{{$cr->link}}">{{$cr->link}}</a>
                              </td>

                        @endif

                        <td class="align_ellipse first_row">

                          <li class="nav-item dropdown">

                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                              <span class="material-icons">

                                more_horiz

                              </span>

                              <div class="ripple-container"></div>

                            </a>
                                    @if(auth()->user()->role_id != '5')

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                              <a class="dropdown-item" href="{{url('/resource/editvid/' . $cr->id.'/'. $cid .'/'. $clasid)}}"><i class="fa fa-cogs"></i>Edit</a>

                              <a href="javascript:void(0);" data-id="<?php echo $cr->id; ?>" class="dropdown-item deletevideo"><i class="fa fa-trash"></i>Delete</a>

                            </div>
                            @endif

                          </li>

                        </td>

                      </tr>

                            @endforeach

                          </tbody>

                        </table>  

                       @else

                        <p>There is no Video</p>

                      @endif

                      </div>

                  </div>

       

                <!-- end videos tab -->




                <!-- start links tab -->



                <div class="panel panel-default" data-toggle="collapse" data-target="#tlinkstable">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$thursdaylink}} Links</a>

                    </h4>

                  </div>

            </div>


                  <div id="tlinkstable" class="collapse">

                      <div class="panel-body">



                        <div class="table_filters">
                          @if(auth()->user()->role_id != '5')

                          <div>
                            <a href="{{url('/courselink/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Link</a>
                          </div>
                          @endif

                        </div>
                        
                        @if(count($tlinks)>0)

                          <div class="table_filters">

                           <!--  <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div> -->
                            
                            <!-- <a href="{{url('/courselink/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Link</a> -->

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Title</th>

                                <th scope="col">Link Description</th>

                                <th scope="col">Links</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($tlinks as $index =>$cl)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">

                                    <p>{{$cl->title}}</p>

                                  </div>

                                </td>

                                <td class="first_row"><div class="limit_description">{{$cl->short_description}}</div></td>

                                <td class="first_row"><a href="{{$cl->link}}">{{$cl->link}}</a></td>

                                <td class="align_ellipse first_row">

                                  <li class="nav-item dropdown">

                                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                      <span class="material-icons">

                                        more_horiz

                                      </span>

                                      <div class="ripple-container"></div>

                                    </a>
                          @if(auth()->user()->role_id != '5')

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                      <a class="dropdown-item" href="{{url('/linkedit/' . $cl->id.'/'.$cid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                      <a href="javascript:void(0);" data-id="<?php echo $cl->id; ?>" class="dropdown-item deletelink"><i class="fa fa-trash"></i>Delete</a>

                                    </div>

                              @endif
                                  </li>

                                </td>

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                       @else

                        <p>There is no Link</p>

                      @endif

                      </div>

                  </div>

       

                     <!-- end links tabs -->


                     <!-- start lectures tab -->


                  <div class="panel panel-default" data-toggle="collapse" data-target="#ttablelecture">

                    <div class="panel-heading">

                      <h4 class="panel-title">

                      <a data-toggle="collapse" class=" stmp_accordion">{{$thursdaylec}} Live Lessons</a>

                      </h4>

                    </div>

                  </div>

                  <div id="ttablelecture" class="collapse">

                      <div class="panel-body">

                         

                        <div class="table_filters">
                        @if(auth()->user()->role_id != '5')

                          <div>
                            <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                          </div>
                          @endif  

                        </div>

                       @if(count($thlectures) > 0)


                          <div class="table_filters">

                            <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div>

                          <!--   <div>
                              <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                            </div> -->
                             @if(auth()->user()->role_id != '5')

                            <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                            @endif

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Topic</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($thlectures as $index =>$lec)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">


                                    <p>{{$lec->topic}}</p>

                                  </div>

                                </td>

                                <td class="align_ellipse first_row">
                                      <a href="{{url('/instructor/launchmeeting/' . $lec->id .'/'. $cid)}}">
                                        <button class="btn btn-sm btn-info">
                                          <i class="fa fa-rocket" aria-hidden="true"></i>Join Lecture    
                                        </button>
                                      </a>
                                 @if(auth()->user()->role_id != '5')
                                      <a href="{{url('/instructor/edit_lecture/' .$lec->id)}}">
                                        <button class="btn btn-sm btn-success">
                                          <i class="fa fa-cogs" aria-hidden="true"></i>Edit    
                                        </button>
                                      </a>
                                      <a href="javascript:void(0);" data-id="<?php echo $lec->id; ?>" class=" deletelec">
                                        <button class="btn btn-sm btn-danger">
                                          <i class="fa fa-trash" aria-hidden="true"></i>Delete    
                                        </button>
                                      </a>
                                </td>
                                @endif

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                        @else

                          <p>There is no Lecture</p>

                        @endif

                      </div>

                  </div>

                  <!-- end lectures tab -->


                  <!-- start quizzes tab -->

                <div class="panel panel-default" data-toggle="collapse" data-target="#tablethursday">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$thursdayquiz}}  Quizzes</a>

                    </h4>

                  </div>

                </div>


                  <div id="tablethursday" class="collapse">

                      <div class="panel-body">


                        
                        <div class="table_filters">
                          @if(auth()->user()->role_id != '5')

                          <div>
                            <a href="{{url('/quiz/create/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add Quiz</a>
                          </div>
                          @endif

                        </div>
                        @if(count($tquizzes) > 0)

                          <div class="table_filters">

                            <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div>

                        <!-- <a href="{{url('/quiz/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add Quiz</a> -->

                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Name</th>

                                <th scope="col">Questions</th>

                                <th scope="col">Total Students</th>

                                <th scope="col">Attempted by</th>

                                <th scope="col">Quiz</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($tquizzes as $index =>$quiz)

                              <tr>

                                <th scope="row">#{{$index+1}}</th>

                                <td class="first_row">

                                  <div class="course_td">

                                    <p>{{$quiz->name}}</p>

                                  </div>

                                </td>

                                <td class="first_row">
                                  <?php
                                    $check_quiz = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->get()->first();
                                  ?>
                                  @if($check_quiz != null)
                              @if(auth()->user()->role_id != '5')

                                  <button type="button" class="btn btn-success" disabled>Add questions</button>
                                  @else
                                    <a href="{{url('/quiz/addquestion/toquiz/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id .'/'. $clasid)}}" class="btn btn-success" > Add questions</a>
                                  @endif
                                  @endif
                                </td>

                                <?php
                                  $totalStudents = DB::table('class_course_students')->where('course_id', $cid)->where('class_id', $clasid)->pluck('std_id')->toArray();
                                  $ts = count($totalStudents);

                                  $attemptesBy = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->pluck('student_id')->unique();
                                  $atmpted = count($attemptesBy);

                                ?>
                                <td class="first_row">
                                    {{$ts}}
                                </td>

                                <td class="first_row">
                                  {{$atmpted}}

                                  @if($atmpted > 0)
                                    <a class="btn btn-sm btn-warning" href="{{url('/quiz/attempted_by/'. $quiz->id .'/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}"><i class="fa fa-eye"></i></a>
                                  @endif
                                </td>

                                <td class="first_row">
                                  <a href="{{url('/quiz/showquiz/'.$quiz->id)}}" class="btn btn-success">Show</a>
                                </td>

                                <td class="align_ellipse first_row">

                                  <li class="nav-item dropdown">

                                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                      <span class="material-icons">

                                        more_horiz

                                      </span>

                                      <div class="ripple-container"></div>

                                    </a>
                              @if(auth()->user()->role_id != '5')

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                      <a class="dropdown-item" href="{{url('/quiz/edit/quiz_questions/'.$quiz->id)}}"><i class="fa fa-cogs"></i>Edit Quiz Questions</a>

                                      <a class="dropdown-item" href="{{url('/mcq/create/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id)}}"><i class="fa fa-plus"></i>Create Questions</a>

                                      <a class="dropdown-item" href="{{url('/upload_quiz_questions/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id)}}"><i class="fa fa-plus"></i>Upload Questions (.xlsx)</a>

                                      <a class="dropdown-item" href="{{url('/quiz/edit/'.$quiz->id .'/'. $clasid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                      <a href="javascript:void(0);" data-id="<?php echo $quiz->id; ?>" class="dropdown-item deletequiz"><i class="fa fa-trash"></i>Delete</a>

                                    </div>
                                    @endif

                                  </li>

                                </td>

                              </tr>

                              @endforeach

                            </tbody>

                          </table>  

                       @else

                        <p>There is no Quiz</p>

                      @endif

                      </div>

                  </div>

                

                <!-- end quizzes tab -->

                <!-- start discussions tab -->

                <div class="panel panel-default" data-toggle="collapse" data-target="#ttablediscussions">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">Discussions</a>

                    </h4>

                  </div>

                </div>


                  <div id="ttablediscussions" class="collapse">

                      <div class="panel-body">


                        
                        <div class="table_filters">

                        </div>

                        <p>There is no Discussion yet.</p>

                      </div>

                  </div>

                

                <!-- end discussions tab -->



                <!-- start downloads tabs -->


                <div class="panel panel-default" data-toggle="collapse" data-target="#tdownloadablestable">

                  <div class="panel-heading">

                    <h4 class="panel-title">

                    <a data-toggle="collapse" class=" stmp_accordion">{{$tdown}} Downloadables</a>

                    </h4>

                  </div>

                </div>

                  <div id="tdownloadablestable" class="collapse">

                      <div class="panel-body">



                        <div class="table_filters">

                              @if(auth()->user()->role_id != '5')

                          <div>
                            <a href="{{url('/courseresourse/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add New Downloadable</a>
                          </div>
                          @endif

                        </div>

                        @if($tdown>0)

                          <div class="table_filters">

                            <!-- <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div> -->
                            
                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Title</th>

                                <th scope="col">File Description</th>

                                <th scope="col">File</th>

                                <th scope="col">Downloadable</th>

                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($thursdaydownloadables as $index =>$cr)

                                @if ($cr->type=='pdf' || $cr->type=='docx' || $cr->type=='odt' || $cr->type=='xlsx' || $cr->type=='pptx' || $cr->type=='txt' || $cr->type=='jpg' || $cr->type=='jpeg' || $cr->type=='png' || $cr->type=='gif')

                                <tr>

                                  <th scope="row">#{{$index+1}}</th>

                                  <td class="first_row">

                                    <div class="course_td">

                                      <p>{{$cr->title}}</p>

                                    </div>

                                  </td>

                                  <td class="first_row">{{$cr->short_description}}</td>

                                      @if ($cr->type=='pdf')

                                        <td class="first_row">
                                          <embed src="{{asset('storage/'.$cr->file)}}" type="application/pdf" height="50" width="50">
                                        </td>

                                      @elseif ($cr->type=='docx'|| $cr->type=='odt' || $cr->type=='xlsx' || $cr->type=='pptx' || $cr->type=='txt')                        
                                        <td>
                                        
                                                <!-- 
                                        <iframe src="http://tonylea.com" width="100" height="100"></iframe>
                                              -->

                                        <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{asset('storage/'.$cr->file)}}" width='100px' height='100px'></iframe>


                                        </td>

                                      @elseif ($cr->type=='png'|| $cr->type=='jpeg' || $cr->type=='jpg' || $cr->type=='gif' )

                                        <td class="first_row">

                                          <img src="{{asset('storage/'.$cr->file)}}" height="50" width="50">

                                        </td>

                                       @endif

                                  <td class="first_row"><a href="{{asset('storage/'.$cr->file)}}"  class="btn btn-primary"download>Download</a></td>

                                  <td class="align_ellipse first_row">

                                    <li class="nav-item dropdown">

                                      <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <span class="material-icons">

                                          more_horiz

                                        </span>

                                        <div class="ripple-container"></div>

                                      </a>
                                  @if(auth()->user()->role_id != '5')

                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                        <a class="dropdown-item" href="{{url('/resource/edit/' . $cr->id.'/'.$cid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                        <a href="javascript:void(0);" data-id="<?php echo $cr->id; ?>" class="dropdown-item deletedown"><i class="fa fa-trash"></i>Delete</a>

                                      </div>
                                      @endif

                                    </li>

                                  </td>

                                </tr>

                                @endif

                              @endforeach

                            </tbody>

                          </table>  

                       @else

                        <p>There is no Downloadable data</p>

                      @endif

                      </div>

                  </div>

                </div>


                <!-- end downloads tab -->


                    </div>


          <!-- Thursday end -->




          <!-- Friday -->

            <div class="panel panel-default" data-toggle="collapse" data-target="{{'#friday'.$i}}">

              <div class="panel-heading">

                <h4 class="panel-title">

                <a data-toggle="collapse" class=" stmp_accordion">Friday Quizzes:{{$fridayquiz}}   Lectures:{{$fridaylec}}  Links:{{$fridaylink}}  Videos:{{$fridayvid}}</a>

                </h4>

              </div>

            </div>


            <div id="{{'friday'.$i}}" class="collapse parent_collapse">

                <div class="panel-body">

                   
                  <!-- start videos tab -->


                    <div class="panel panel-default" data-toggle="collapse" data-target="#fvideostable">

                      <div class="panel-heading">

                        <h4 class="panel-title">

                        <a data-toggle="collapse" class=" stmp_accordion">{{$fcountVid}} Videos</a>

                        </h4>

                      </div>

                    </div>

                    <div id="fvideostable" class="collapse">

                        <div class="panel-body">



                          <div class="table_filters">

                                @if(auth()->user()->role_id != '5')

                            <div>
                              <a href="{{url('/courseresoursevideo/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add New Video</a>
                            </div>
                            @endif

                          </div>
                          @if($fcountVid > 0)

                          <div class="table_filters">

                            <!-- <div class="table_search">

                              <input type="text" name="search" id="search" value="" placeholder="Search...">

                              <a href="#"> <i class="fa fa-search"></i> </a>
                              
                            </div> -->
                            <!-- <a href="{{url('/courseresoursevideo/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Video</a> -->
                          </div>

                          <table class="table table-hover" id="table-id">

                            <thead>

                              <tr>

                                <th scope="col">ID</th>

                                <th scope="col">Title</th>

                                <th scope="col">Video Description</th>

                                <th scope="col">Resource</th>                
                                
                                <th scope="col">Action</th>

                              </tr>

                            </thead>

                            <tbody id="mybody">

                              @foreach($fridayvideos as $index =>$cr)

                              <tr>

                          <th scope="row">#{{$index+1}}</th>

                          <td class="first_row">

                            <div class="course_td">

                              

                              <p>{{$cr->title}}</p>

                            </div>

                          </td>

                          <td class="first_row"><div class="limit_description">{{$cr->short_description}}</div></td>

                          @if($cr->type =='mp4')

                            <td class="first_row viddeo_row">
                                <!--<iframe src="{{asset('storage/'.$cr->file)}}" height="60" width="85">{{($cr->file)}}</iframe><br>-->
                            
                                                        <video controls>
                                            
                                            <source src="{{asset('storage/'.$cr->file)}}">
                                            Your browser does not support HTML5 Video.
                                          </video> <br>
                            <a class ="btn btn-primary"  href="{{asset('storage/'.$cr->file)}}" download >Download</a>

                            </td>
                          @else
                            <td class="first_row">
                                <a href="{{$cr->link}}">{{$cr->link}}</a>
                                </td>

                          @endif

                          <td class="align_ellipse first_row">

                            <li class="nav-item dropdown">

                              <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <span class="material-icons">

                                  more_horiz

                                </span>

                                <div class="ripple-container"></div>

                              </a>
                              @if(auth()->user()->role_id != '5')

                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                <a class="dropdown-item" href="{{url('/resource/editvid/' . $cr->id.'/'. $cid .'/'. $clasid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                <a href="javascript:void(0);" data-id="<?php echo $cr->id; ?>" class="dropdown-item deletevideo"><i class="fa fa-trash"></i>Delete</a>

                              </div>
                              @endif

                            </li>

                          </td>

                        </tr>

                              @endforeach

                            </tbody>

                          </table>  

                         @else

                          <p>There is no Video</p>

                        @endif

                        </div>

                    </div>

         

                  <!-- end videos tab -->




                  <!-- start links tab -->



                  <div class="panel panel-default" data-toggle="collapse" data-target="#flinkstable">

                    <div class="panel-heading">

                      <h4 class="panel-title">

                      <a data-toggle="collapse" class=" stmp_accordion">{{$fridaylink}} Links</a>

                      </h4>

                    </div>

                  </div>


                    <div id="flinkstable" class="collapse">

                        <div class="panel-body">



                          <div class="table_filters">
                                    @if(auth()->user()->role_id != '5')

                            <div>
                              <a href="{{url('/courselink/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Link</a>
                            </div>
                            @endif

                          </div>
                          
                          @if(count($flinks)>0)

                            <div class="table_filters">

                             <!--  <div class="table_search">

                                <input type="text" name="search" id="search" value="" placeholder="Search...">

                                <a href="#"> <i class="fa fa-search"></i> </a>
                                
                              </div> -->
                              
                              <!-- <a href="{{url('/courselink/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add New Link</a> -->

                            </div>

                            <table class="table table-hover" id="table-id">

                              <thead>

                                <tr>

                                  <th scope="col">ID</th>

                                  <th scope="col">Title</th>

                                  <th scope="col">Link Description</th>

                                  <th scope="col">Links</th>

                                  <th scope="col">Action</th>

                                </tr>

                              </thead>

                              <tbody id="mybody">

                                @foreach($flinks as $index =>$cl)

                                <tr>

                                  <th scope="row">#{{$index+1}}</th>

                                  <td class="first_row">

                                    <div class="course_td">

                                      <p>{{$cl->title}}</p>

                                    </div>

                                  </td>

                                  <td class="first_row"><div class="limit_description">{{$cl->short_description}}</div></td>

                                  <td class="first_row"><a href="{{$cl->link}}">{{$cl->link}}</a></td>

                                  <td class="align_ellipse first_row">

                                    <li class="nav-item dropdown">

                                      <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <span class="material-icons">

                                          more_horiz

                                        </span>

                                        <div class="ripple-container"></div>

                                      </a>
                                    @if(auth()->user()->role_id != '5')

                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                        <a class="dropdown-item" href="{{url('/linkedit/' . $cl->id.'/'.$cid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                        <a href="javascript:void(0);" data-id="<?php echo $cl->id; ?>" class="dropdown-item deletelink"><i class="fa fa-trash"></i>Delete</a>

                                      </div>
                                      @endif

                                    </li>

                                  </td>

                                </tr>

                                @endforeach

                              </tbody>

                            </table>  

                         @else

                          <p>There is no Link</p>

                        @endif

                        </div>

                    </div>

         

                       <!-- end links tabs -->


                       <!-- start lectures tab -->


                    <div class="panel panel-default" data-toggle="collapse" data-target="#ftablelecture">

                      <div class="panel-heading">

                        <h4 class="panel-title">

                        <a data-toggle="collapse" class=" stmp_accordion">{{$fridaylec}} Live Lessons</a>

                        </h4>

                      </div>

                    </div>

                    <div id="ftablelecture" class="collapse">

                        <div class="panel-body">

                           

                          <div class="table_filters">
                          @if(auth()->user()->role_id != '5')

                            <div>
                              <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                            </div>
                            @endif

                          </div>

                          @if( $fridaylec > 0)

                            <div class="table_filters">

                              <div class="table_search">

                                <input type="text" name="search" id="search" value="" placeholder="Search...">

                                <a href="#"> <i class="fa fa-search"></i> </a>
                                
                              </div>

                            <!--   <div>
                                <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                              </div> -->
                               @if(auth()->user()->role_id != '5')

                              <a href="{{url('/lecture/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Create New Lecture</a>
                              @endif

                            </div>

                            <table class="table table-hover" id="table-id">

                              <thead>

                                <tr>

                                  <th scope="col">ID</th>

                                  <th scope="col">Topic</th>

                                  <th scope="col">Action</th>

                                </tr>

                              </thead>

                              <tbody id="mybody">

                                @foreach($flectures as $index =>$lec)

                                <tr>

                                  <th scope="row">#{{$index+1}}</th>

                                  <td class="first_row">

                                    <div class="course_td">


                                      <p>{{$lec->topic}}</p>

                                    </div>

                                  </td>

                                    <td class="align_ellipse first_row">
                                          <a href="{{url('/instructor/launchmeeting/' . $lec->id .'/'. $cid)}}">
                                            <button class="btn btn-sm btn-info">
                                              <i class="fa fa-rocket" aria-hidden="true"></i>Join Lecture    
                                            </button>
                                          </a>
                                    @if(auth()->user()->role_id != '5')
                                          <a href="{{url('/instructor/edit_lecture/' .$lec->id)}}">
                                            <button class="btn btn-sm btn-success">
                                              <i class="fa fa-cogs" aria-hidden="true"></i>Edit    
                                            </button>
                                          </a>
                                          <a href="javascript:void(0);" data-id="<?php echo $lec->id; ?>" class=" deletelec">
                                            <button class="btn btn-sm btn-danger">
                                              <i class="fa fa-trash" aria-hidden="true"></i>Delete    
                                            </button>
                                          </a>
                                    </td>
                                  @endif

                                </tr>

                                @endforeach

                              </tbody>

                            </table>  

                          @else

                            <p>There is no Lecture</p>

                          @endif

                        </div>

                    </div>

                    <!-- end lectures tab -->


                    <!-- start quizzes tab -->

                    <div class="panel panel-default" data-toggle="collapse" data-target="#tablefriday">

                      <div class="panel-heading">

                        <h4 class="panel-title">

                        <a data-toggle="collapse" class=" stmp_accordion">{{$fridayquiz}}  Quizzes</a>

                        </h4>

                      </div>

                    </div>


                    <div id="tablefriday" class="collapse">

                        <div class="panel-body">


                          
                          <div class="table_filters">
                                      @if(auth()->user()->role_id != '5')

                            <div>
                              <a href="{{url('/quiz/create/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add Quiz</a>
                            </div>
                            @endif

                          </div>
                          @if(count($fquizzes) > 0)

                            <div class="table_filters">

                              <div class="table_search">

                                <input type="text" name="search" id="search" value="" placeholder="Search...">

                                <a href="#"> <i class="fa fa-search"></i> </a>
                                
                              </div>

                          <!-- <a href="{{url('/quiz/create/'. $insid .'/'. $cid .'/'. $week)}}" class="btn btn-primary">Add Quiz</a> -->

                            </div>

                            <table class="table table-hover" id="table-id">

                              <thead>

                                <tr>

                                  <th scope="col">ID</th>

                                  <th scope="col">Name</th>

                                  <th scope="col">Questions</th>

                                  <th scope="col">Total Students</th>

                                  <th scope="col">Attempted by</th>

                                  <th scope="col">Quiz</th>

                                  <th scope="col">Action</th>

                                </tr>

                              </thead>

                              <tbody id="mybody">

                                @foreach($fquizzes as $index =>$quiz)

                                <tr>

                                  <th scope="row">#{{$index+1}}</th>

                                  <td class="first_row">

                                    <div class="course_td">

                                      <p>{{$quiz->name}}</p>

                                    </div>

                                  </td>

                                  <td class="first_row">
                                    <?php
                                      $check_quiz = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->get()->first();
                                    ?>
                                    @if($check_quiz != null)
                                    @if(auth()->user()->role_id != '5')

                                    <button type="button" class="btn btn-success" disabled>Add questions</button>
                                    @else
                                      <a href="{{url('/quiz/addquestion/toquiz/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id .'/'. $clasid)}}" class="btn btn-success" > Add questions</a>
                                    @endif
                                    @endif
                                  </td>

                                  <?php
                                    $totalStudents = DB::table('class_course_students')->where('course_id', $cid)->where('class_id', $clasid)->pluck('std_id')->toArray();
                                    $ts = count($totalStudents);

                                    $attemptesBy = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->pluck('student_id')->unique();
                                    $atmpted = count($attemptesBy);

                                  ?>
                                  <td class="first_row">
                                      {{$ts}}
                                  </td>

                                  <td class="first_row">
                                    {{$atmpted}}

                                    @if($atmpted > 0)
                                      <a class="btn btn-sm btn-warning" href="{{url('/quiz/attempted_by/'. $quiz->id .'/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}"><i class="fa fa-eye"></i></a>
                                    @endif
                                  </td>

                                  <td class="first_row">
                                    <a href="{{url('/quiz/showquiz/'.$quiz->id)}}" class="btn btn-success">Show</a>
                                  </td>

                                  <td class="align_ellipse first_row">

                                    <li class="nav-item dropdown">

                                      <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        <span class="material-icons">

                                          more_horiz

                                        </span>

                                        <div class="ripple-container"></div>

                                      </a>
                                    @if(auth()->user()->role_id != '5')

                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                        <a class="dropdown-item" href="{{url('/quiz/edit/quiz_questions/'.$quiz->id)}}"><i class="fa fa-cogs"></i>Edit Quiz Questions</a>

                                        <a class="dropdown-item" href="{{url('/mcq/create/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id)}}"><i class="fa fa-plus"></i>Create Questions</a>

                                        <a class="dropdown-item" href="{{url('/upload_quiz_questions/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id)}}"><i class="fa fa-plus"></i>Upload Questions (.xlsx)</a>

                                        <a class="dropdown-item" href="{{url('/quiz/edit/'.$quiz->id .'/'. $clasid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                        <a href="javascript:void(0);" data-id="<?php echo $quiz->id; ?>" class="dropdown-item deletequiz"><i class="fa fa-trash"></i>Delete</a>

                                      </div>
                                      @endif

                                    </li>

                                  </td>

                                </tr>

                                @endforeach

                              </tbody>

                            </table>  

                         @else

                          <p>There is no Quiz</p>

                        @endif

                        </div>

                    </div>

                  

                        <!-- end quizzes tab -->

                        <!-- start discussions tab -->

                        <div class="panel panel-default" data-toggle="collapse" data-target="#ftablediscussions">

                          <div class="panel-heading">

                            <h4 class="panel-title">

                            <a data-toggle="collapse" class=" stmp_accordion">Discussions</a>

                            </h4>

                          </div>

                        </div>


                          <div id="ftablediscussions" class="collapse">

                              <div class="panel-body">


                                
                                <div class="table_filters">

                                </div>

                                <p>There is no Discussion yet.</p>

                              </div>

                          </div>

                        

                        <!-- end discussions tab -->



                        <!-- start downloads tabs -->


                        <div class="panel panel-default" data-toggle="collapse" data-target="#fdownloadablestable">

                          <div class="panel-heading">

                            <h4 class="panel-title">

                            <a data-toggle="collapse" class=" stmp_accordion">{{$fdown}} Downloadables</a>

                            </h4>

                          </div>

                        </div>

                          <div id="tdownloadablestable" class="collapse">

                              <div class="panel-body">



                                <div class="table_filters">

                                    @if(auth()->user()->role_id != '5')

                                  <div>
                                    <a href="{{url('/courseresourse/'. $insid .'/'. $cid .'/'. $week .'/'. $clasid)}}" class="btn btn-primary">Add New Downloadable</a>
                                  </div>
                                  @endif

                                </div>

                                @if($fdown>0)

                                  <div class="table_filters">

                                    <!-- <div class="table_search">

                                      <input type="text" name="search" id="search" value="" placeholder="Search...">

                                      <a href="#"> <i class="fa fa-search"></i> </a>
                                      
                                    </div> -->
                                    
                                  </div>

                                  <table class="table table-hover" id="table-id">

                                    <thead>

                                      <tr>

                                        <th scope="col">ID</th>

                                        <th scope="col">Title</th>

                                        <th scope="col">File Description</th>

                                        <th scope="col">File</th>

                                        <th scope="col">Downloadable</th>

                                        <th scope="col">Action</th>

                                      </tr>

                                    </thead>

                                    <tbody id="mybody">

                                      @foreach($fridaydownloadables as $index =>$cr)

                                        @if ($cr->type=='pdf' || $cr->type=='docx' || $cr->type=='odt' || $cr->type=='xlsx' || $cr->type=='pptx' || $cr->type=='txt' || $cr->type=='jpg' || $cr->type=='jpeg' || $cr->type=='png' || $cr->type=='gif')

                                        <tr>

                                          <th scope="row">#{{$index+1}}</th>

                                          <td class="first_row">

                                            <div class="course_td">

                                              <p>{{$cr->title}}</p>

                                            </div>

                                          </td>

                                          <td class="first_row">{{$cr->short_description}}</td>

                                              @if ($cr->type=='pdf')

                                                <td class="first_row">
                                                  <embed src="{{asset('storage/'.$cr->file)}}" type="application/pdf" height="50" width="50">
                                                </td>

                                              @elseif ($cr->type=='docx'|| $cr->type=='odt' || $cr->type=='xlsx' || $cr->type=='pptx' || $cr->type=='txt')                        
                                                <td>
                                                
                                                        <!-- 
                                                <iframe src="http://tonylea.com" width="100" height="100"></iframe>
                                                      -->

                                                <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{asset('storage/'.$cr->file)}}" width='100px' height='100px'></iframe>


                                                </td>

                                              @elseif ($cr->type=='png'|| $cr->type=='jpeg' || $cr->type=='jpg' || $cr->type=='gif' )

                                                <td class="first_row">

                                                  <img src="{{asset('storage/'.$cr->file)}}" height="50" width="50">

                                                </td>

                                               @endif

                                          <td class="first_row"><a href="{{asset('storage/'.$cr->file)}}"  class="btn btn-primary"download>Download</a></td>

                                          <td class="align_ellipse first_row">

                                            <li class="nav-item dropdown">

                                              <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                <span class="material-icons">

                                                  more_horiz

                                                </span>

                                                <div class="ripple-container"></div>

                                              </a>
                                            @if(auth()->user()->role_id != '5')

                                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                                <a class="dropdown-item" href="{{url('/resource/edit/' . $cr->id.'/'.$cid)}}"><i class="fa fa-cogs"></i>Edit</a>

                                                <a href="javascript:void(0);" data-id="<?php echo $cr->id; ?>" class="dropdown-item deletedown"><i class="fa fa-trash"></i>Delete</a>

                                              </div>
                                              @endif

                                            </li>

                                          </td>

                                        </tr>

                                        @endif

                                      @endforeach

                                    </tbody>

                                  </table>  

                               @else

                                <p>There is no Downloadable data</p>

                              @endif

                              </div>

                          </div>

                </div>


                    <!-- end downloads tab -->


            </div>


          <!-- Friday end -->




       

      </div>

    </div>

  </div>

  @endfor
              </div>

              <div class="tab-pane" id="2">

                @php
                  $students = DB::table('course_students')->where('course_id',$cat->id)->get()->pluck('id');

                  $students_count = DB::table('course_students')->where('course_id',$cat->id)->count();

                  $students = DB::table('students')->whereIn('id',$students)->get()->pluck('s_u_id');

                  $students = DB::table('users')->whereIn('id',$students)->get();
                @endphp
				
                @if($students_count > 0)
				<strong>Total Students: </strong>{{$students_count}}	
			  @else
                  <strong>No Students are currently enrolled in {{$cat->course_name}}</strong>
                @endif

              </div>


              <div class="tab-pane" id="4">

                @php
                  $instruc = DB::table('users')->where('id',$cat->ins_id)->first();
                @endphp

               @if(isset($instruc))
                <strong>Name: </strong> {{$instruc->name}}</br>
                <strong>Email: </strong> {{$instruc->email}}</br>
                <strong>Bio: </strong> {{$instruc->bio}}</br>
                @else
                 <strong>No Instructor assigned to {{$cat->course_name}}</strong>
               @endif

              </div>


              <div class="tab-pane" id="5">

                 <table class="table table-hover" id="table-id">
                        <thead>
                          <tr>
                            <th scope="col">Student</th>
                            <th scope="col">Course</th>
                            <th scope="col">Lecture</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                          </tr>
                        </thead>
                        <tbody id="mybody">
                          @php
                            $attendance = DB::table('attendance')->where('course_id',$cat->id)->get();
                          @endphp
                          @if(count($attendance) > 0)
                          @foreach($attendance as $index =>$atn)
                          <?php
                            $course_attend = DB::table('courses')->where('id', $atn->course_id)->get()->first();
                            $lecture = DB::table('lectures')->where('id', $atn->lecture_id)->get()->first();
                            $student_attend = DB::table('users')->where('id',$atn->student_id)->pluck('name')->first();
                          ?>
                          @if(isset($student_attend))
                          <tr>
                            <th scope="row">{{$student_attend}}</th>
                            <td class="first_row">
                              <div class="course_td">
                                <p>{{$course_attend->course_name}}</p>
                              </div>
                            </td>
                            <td class="first_row">
                              {{$lecture->topic}}
                            </td>
                            <td class="first_row">
                              {{$atn->date}}
                            </td>
                            <td class="first_row">
                              {{$atn->time}}
                            </td>
                            <td class="first_row">
                              {{$atn->status}}
                            </td>
                          </tr>
                          @endif
                          @endforeach
                          @else
                            <p>No attendance history for {{$cat->course_name}}</p>
                          @endif
                        </tbody>
                      </table>

              </div>



              <div class="tab-pane" id="6">

                @php
                  $weightage = DB::table('course_assigned_grade_percentages')->where('course_id',$cat->id)->get();
                @endphp

                @if(count($weightage) > 0)
                  <strong>Grading Scale</strong><br>

                  @foreach($weightage as $grade)
                  {{$grade->grade_title}} : {{$grade->grade_percentage}}%<br>
                 
                  @endforeach

                @else
                  <p>No grading criteria set for {{$cat->course_name}}</p>  
                @endif

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>
</div>

@endsection