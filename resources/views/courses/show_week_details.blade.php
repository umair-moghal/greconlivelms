@extends('layouts.app')

@section('content')

<style>
    .viddeo_row video {
        width: 180px;
    }
    .panel-heading {
        cursor: pointer;
    }
    .panel-default {
  position: relative;
}
  
.panel-default::after {
    content: "\f107";
    color: #333;
    top: 14px;
    right: 20px;
    position: absolute;
    font-family: "FontAwesome";
    font-size: 28px;
    font-weight: bold;
}

.panel-default[aria-expanded="true"]::after {
  content: "\f106";
      color: #fff;
}
</style>

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

      <li><a href = "{{url('/classes')}}">Terms/Sessions</a></li>

      <li>{{$course->course_name}} Course</li>

      <li class = "active">Course Weekly Details</li>

    </ol>

  </div>

  <div class="content_main">

    <div class="card-header sftp_main">

      <div class="align_dftp">


          <h3 class="mb-0"> Week {{$week}} details</h3>


      </div>



        <?php
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

          <div class="panel-group" id="accordion">
        <!-- Monday -->

        <div class="panel panel-default" data-toggle="collapse" data-target="#monday">

          <div class="panel-heading">

            <h4 class="panel-title">

            <a data-toggle="collapse" class=" stmp_accordion">Monday Quizzes:{{$mondayquiz}}   Lectures:{{$mondaylec}}  Links:{{$mondaylink}}  Videos:{{$mondayvid}}</a>

            </h4>

          </div>

        </div>


          <div id="monday"  class="collapse parent_collapse">

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

                                        $available = DB::table('questions')->where('instructor_id', $insid)->where('course_id', $cid)->count();

                                        $assigned = DB::table('quiz_questions')->where('quiz_id', $quiz->id)->pluck('question_id')->count();  

                                    ?>
                                    @if($check_quiz != null)
                                        <button type="button" class="btn btn-success" disabled>Add questions</button>
                                      @else
                                        <a href="{{url('/quiz/addquestion/toquiz/'. $insid .'/'. $cid .'/'. $week .'/'. $quiz->id .'/'. $clasid)}}" class="btn btn-success" ><span style="color: black">{{$available}}</span> Add questions <span style="color: orange">{{$assigned}}</span></a>
                                    @endif
                                  </td>

                                  <?php
                                    $totalStudents = DB::table('course_students')->where('course_id', $cid)->pluck('student_id')->toArray();
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
                                <?php
                                      $check_quiz = DB::table('solved_quizzes')->where('quiz_id', $quiz->id)->get()->first();
                                      $quizQuestions = DB::table('quiz_questions')->where('quiz_id', $quiz->id)->get()->toArray();
                                    ?>
                            		@if($check_quiz == null && $quizQuestions!= null) 
	                                <td class="first_row">
	                                  <a href="{{url('/quiz/solve_quiz_student/'.$quiz->id .'/'. $cid)}}" class="btn btn-success">Show/Solve</a>
	                                </td>
	                                @endif


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

                                        <!-- <a class="dropdown-item" href="{{url('/quiz/edit/quiz_questions/'.$quiz->id)}}"><i class="fa fa-cogs"></i>Edit Quiz Questions</a> -->

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

        <div class="panel panel-default" data-toggle="collapse" data-target="#tuesday">

          <div class="panel-heading">

            <h4 class="panel-title">

            <a data-toggle="collapse" class=" stmp_accordion">Tuesday  Quizzes:{{$tuesdayquiz}}   Lectures:{{$tuesdaylec}}  Links:{{$tuesdaylink}}  Videos:{{$tuesdayvid}}</a>

            </h4>

          </div>

        </div>


          <div id="tuesday" class="collapse parent_collapse">

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

                                      <!-- <a class="dropdown-item" href="{{url('/quiz/edit/quiz_questions/'.$quiz->id)}}"><i class="fa fa-cogs"></i>Edit Quiz Questions</a> -->

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

        <div class="panel panel-default" data-toggle="collapse" data-target="#wednesday">

          <div class="panel-heading">

            <h4 class="panel-title">

            <a data-toggle="collapse" class=" stmp_accordion">Wednesday Quizzes:{{$wednesdayquiz}}   Lectures:{{$wednesdaylec}}  Links:{{$wednesdaylink}}  Videos:{{$wednesdayvid}}</a>

            </h4>

          </div>

        </div>


          <div id="wednesday" class="collapse parent_collapse">

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

                                      <!-- <a class="dropdown-item" href="{{url('/quiz/edit/quiz_questions/'.$quiz->id)}}"><i class="fa fa-cogs"></i>Edit Quiz Questions</a> -->

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

              <div class="panel panel-default" data-toggle="collapse" data-target="#thursday">

                <div class="panel-heading">

                  <h4 class="panel-title">

                  <a data-toggle="collapse" class=" stmp_accordion">Thursday Quizzes:{{$thursdayquiz}}   Lectures:{{$thursdaylec}}  Links:{{$thursdaylink}}  Videos:{{$thursdayvid}}</a>

                  </h4>

                </div>

              </div>


          <div id="thursday" class="collapse parent_collapse">

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

                                      <!-- <a class="dropdown-item" href="{{url('/quiz/edit/quiz_questions/'.$quiz->id)}}"><i class="fa fa-cogs"></i>Edit Quiz Questions</a> -->

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

            <div class="panel panel-default" data-toggle="collapse" data-target="#friday">

              <div class="panel-heading">

                <h4 class="panel-title">

                <a data-toggle="collapse" class=" stmp_accordion">Friday Quizzes:{{$fridayquiz}}   Lectures:{{$fridaylec}}  Links:{{$fridaylink}}  Videos:{{$fridayvid}}</a>

                </h4>

              </div>

            </div>


            <div id="friday" class="collapse parent_collapse">

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

                                        <!-- <a class="dropdown-item" href="{{url('/quiz/edit/quiz_questions/'.$quiz->id)}}"><i class="fa fa-cogs"></i>Edit Quiz Questions</a> -->

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




        <a  href="{{ url()->previous() }}"><button type="button" class="btn" style="background-color: #e7e7e7; color: black">Cancel</button></a>



      </div>

    </div>

  </div>


<script type="text/javascript">

  $("body").on( "click", ".deletedown", function () {

  var task_id = $( this ).attr( "data-id" );

  console.log(task_id);

  var form_data = {

  id: task_id

  };

  swal({

  title: "Do you want to delete this file",



  type: 'info',

  showCancelButton: true,

  confirmButtonColor: '#F79426',

  cancelButtonColor: '#d33',

  confirmButtonText: 'Yes',

  showLoaderOnConfirm: true

  }).then( ( result ) => {

  if ( result.value == true ) {

  $.ajax( {

  type: 'get',



  url: '<?php echo url("/deleteres/{id}"); ?>',

  data: form_data,

  success: function ( msg ) {

  swal( "@lang('File Deleted')", '', 'success' )

  setTimeout( function () {

  location.reload();

  }, 1000 );

  }

  } );

  }

  } );

  } );

  </script>


<script type="text/javascript">

  $("body").on( "click", ".deletevideo", function () {

  var task_id = $( this ).attr( "data-id" );

  console.log(task_id);

  var form_data = {

  id: task_id

  };

  swal({

  title: "Do you want to delete this video",



  type: 'info',

  showCancelButton: true,

  confirmButtonColor: '#F79426',

  cancelButtonColor: '#d33',

  confirmButtonText: 'Yes',

  showLoaderOnConfirm: true

  }).then( ( result ) => {

  if ( result.value == true ) {

  $.ajax( {

  type: 'get',



  url: '<?php echo url("/deletevid/{id}"); ?>',

  data: form_data,

  success: function ( msg ) {

  swal( "@lang('Video Deleted')", '', 'success' )

  setTimeout( function () {

  location.reload();

  }, 1000 );

  }

  } );

  }

  } );

  } );

  </script>

<script type="text/javascript">

    $("body").on( "click", ".deletequiz", function () {

    var task_id = $( this ).attr( "data-id" );

    console.log(task_id);

    var form_data = {

    id: task_id

    };

    swal({

    title: "Do you want to delete this Quiz?",

    type: 'info',

    showCancelButton: true,

    confirmButtonColor: '#F79426',

    cancelButtonColor: '#d33',

    confirmButtonText: 'Yes',

    showLoaderOnConfirm: true

    }).then( ( result ) => {

    if ( result.value == true ) {

    $.ajax( {

    type: 'POST',
    headers: {

                    'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )

                },

    url: '<?php echo url("/quiz/delete"); ?>',

    data: form_data,

    success: function ( msg ) {

    swal( "@lang('Quiz Deleted')", '', 'success' )

    setTimeout( function () {

    location.reload();

    }, 1000 );

    }

    } );

    }

    } );

    } );

  </script>


  <script type="text/javascript">

    setTimeout(function() {

      $('#message').fadeOut('fast');

    }, 2000);

  </script>


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


  <script type="text/javascript">

    $("body").on( "click", ".deletelink", function () {

    var task_id = $( this ).attr( "data-id" );

    console.log(task_id);

    var form_data = {

    id: task_id

    };

    swal({

    title: "Do you want to delete this link",



    type: 'info',

    showCancelButton: true,

    confirmButtonColor: '#F79426',

    cancelButtonColor: '#d33',

    confirmButtonText: 'Yes',

    showLoaderOnConfirm: true

    }).then( ( result ) => {

    if ( result.value == true ) {

    $.ajax( {

    type: 'get',



    url: '<?php echo url("/linkdelete/{id}"); ?>',

    data: form_data,

    success: function ( msg ) {

    swal( "@lang('Link Deleted')", '', 'success' )

    setTimeout( function () {

    location.reload();

    }, 1000 );

    }

    } );

    }

    } );

    } );

  </script>



<script type="text/javascript">

  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

</script>
          <!-- <script src="{{url('backend/sweetalerts/sweetalert2.all.js')}}"></script> -->

<script type="text/javascript">

  $( "body" ).on( "click", ".deletelec", function () {

    var task_id = $( this ).attr( "data-id" );

    var form_data = {

        id: task_id

    };

    swal({

        title: "Do you want to delete this lecture",

        //text: "@lang('category.delete_category_msg')",

        type: 'info',

        showCancelButton: true,

        confirmButtonColor: '#F79426',

        cancelButtonColor: '#d33',

        confirmButtonText: 'Yes',

        showLoaderOnConfirm: true

    }).then( ( result ) => {

        if ( result.value == true ) {

            $.ajax( {

                type: 'POST',

                headers: {

                    'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )

                },

                url: '<?php echo url("/instructor/delete_lecture"); ?>',

                data: form_data,

                success: function ( msg ) {

                    swal( "@lang('Lecture Deleted Successfully')", '', 'success' )

                    setTimeout( function () {

                        location.reload();

                    }, 900 );

                }

            } );

        }

    } );

  } );

</script>


@endsection