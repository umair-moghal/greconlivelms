@extends('layouts.app')

@section('content')

   <style>
   #lod{
   visibility:hidden;
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

    <li class = "active">Grades Scale</li>

  </ol>

</div>


  <div class="content_main">

    <div class="all_courses_main">

      

      <div class="course_table mt-0">

        <div class="course card-header card-header-warning card-header-icon">

          

          <h3>Grades Scale</h3>
          
          

          @if(count($grades)>0)

            <div class="table_filters">

             

             

            </div>

            <table class="table table-hover" id="table-id">

              <thead>

                <tr>

                <!--   <th scope="col">Sr.no</th>
 -->
                  <th scope="col">Range</th>

                  <th scope="col">Grade</th>

                  <th scope="col">Action</th>

                </tr>

              </thead>

              <tbody id="mybody">

                @foreach($grades as $index =>$g)
                

                <tr>

                 <!--  <th scope="row">#{{$index+1}}</th>
 -->
                  <td class="first_row">

                    <div class="course_td">

                      <p>{{$g->marks_from}} - {{$g->marks_to}}</p>

                    </div>

                  </td>

                  <td class="first_row">
                    {{$g->grade}}
                  </td>




                  <td class="align_ellipse first_row">

                    <a href="#" data-toggle="modal" data-target="{{'#exampleModalgrade'.$g->id}}"><i class="fa fa-pencil"></i></a>


                  </td>

                </tr>


                <!-- modal -->


      <div class="modal fade" id="{{'exampleModalgrade'.$g->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalgradeTitle" aria-hidden="true">

      <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

          <div class="cross_modal">

            <div class="modal_title">

              <h3>Edit Grade Scale</h3>

            </div>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true" class="cross_btn">&times;</span>

            </button>

          </div>

          <div class="modal-body">

            <form method="POST" action="/updategrades">

              @csrf

              <input type="hidden" name="id" value="{{$g->id}}">

                  <div class="row">
                  <div class="col-md-12">
                    <div class="custom_input_main">
                      <input class="form-control" type="number"  name="from" value="{{$g->marks_from}}" required autofocus="">

                      <label>Marks From<span class="red">*</span></label>
                    </div>
                  </div>
                  <br><br>

                  <div class="col-md-12">
                    <div class="custom_input_main">
                      <input class="form-control" type="number" name="to" value="{{$g->marks_to}}" required autofocus="">

                      <label>Marks To<span class="red">*</span></label>
                    </div>
                  </div>
                  <br>
                  <br>

                    <div class="col-md-12">

                      <div class="custom_input_main select_plugin">

                        <select name="grade" value = "{{$g->grade}}">

                          <option   @if($g->grade == 'A+') Selected @endif  value="A+">A+</option>
                          <option   @if($g->grade == 'A') Selected @endif  value="A">A</option>
                          <option   @if($g->grade == 'B+') Selected @endif  value="B+">B+</option>
                          <option   @if($g->grade == 'B') Selected @endif  value="B">B</option>
                          <option   @if($g->grade == 'C+') Selected @endif  value="C+">C+</option>
                          <option   @if($g->grade == 'C') Selected @endif  value="C">C</option>
                          <option   @if($g->grade == 'D+') Selected @endif  value="D+">D+</option>
                          <option   @if($g->grade == 'D') Selected @endif  value="D">D</option>
                          <option   @if($g->grade == 'F') Selected @endif  value="F">F</option>

                        </select>

                        <label class="select_lable">Grade</label>

                      </div>

                    </div>
            
                    <div class="col-md-12">
                      <div class="s_form_button text-center">
                        <a href="{{ url()->previous() }}" class="btn cncl_btn">Cancel</a>
                        <button type="submit" class="btn save_btn">Update<div class="ripple-container"></div></button>
                      </div>
                    </div>
          </div>

            </form>

          </div>

        </div>

      </div>

      </div>







                @endforeach

              </tbody>

            </table>   

           @else

            <p>There is no Grade yet created</p>

          @endif

        </div>

      </div>

    </div>

  </div>









  <script type="text/javascript">
    setTimeout(function() {
      $('#message').fadeOut('fast');
  }, 2000);
  </script>

@endsection