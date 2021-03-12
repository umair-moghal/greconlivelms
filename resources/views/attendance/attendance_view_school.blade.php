@extends('layouts.app')
<link href="{{asset('/assets/css/calendar.css')}}" rel="stylesheet" />
@section('content')



    <div class="content_main">
        <div class="school_clndr_main">   
            <div class="calender card-header card-header-warning card-header-icon">
                  
                <h3>Calendar View</h3>
                  
                <div class="calendar_main">

                    <div class="row">

                        <div class="col-md-3">

                        </div>

                    </div> 

                </div>


                <div class="col-md-12">

                    <div class="top_clndr">

                      <div class="">

                        <div class="card-body p-0">

                          <div id="calendar"></div>

                        </div>

                      </div>

                    </div>

                </div>

                <br><br><br><br>
        <h3>List View</h3>
               
        <div class="row">
                <div class="col-md-6">
                    <div class="form-group {{ ($errors->has('roll'))?'has-error':'' }}">
                    <label for="roll">Term <span class="required">*</span></label>
                    <select name="cls" class="form-control" id="cls">
                        <option value="">-- Select Term --</option>
                        @foreach ($classes as $cls)
                            <option value="{{ $cls->id }}">{{ ucfirst($cls->name) }}</option>
                        @endforeach
                    </select>
                 </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ ($errors->has('name'))?'has-error':'' }}">
                    <label for="roll">Course </label>
                    <select name="course" class="form-control" id="course">
                    </select>
                 </div>
                </div>

                <table class="table table-hover stds" id="table-id">
                   <thead id="myhead">
                       
                   </thead>
                    <tbody id="mybody">
                        
                    </tbody>
                </table>

        </div>




            </div>
        </div>
    </div>
</div>
</div>


        
<script>
    $(document).ready(function() {
        $('#cls').on('change', function() {
            var clsID = $(this).val();
            if(clsID) {
                $.ajax({
                    url: '/attendance_dropdown-data/'+clsID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                        //console.log(data);
                      if(data){
                        $('#course').empty();
                        $('#course').focus;
                        $('#course').append('<option value="">-- Select Course --</option>'); 
                        $.each(data, function(key, value){
                        $('select[name="course"]').append('<option value="'+ value.id +'">' + value.course_name+ '</option>');
                    });
                  }else{
                    $('#course').empty();
                  }
                  }
                });
            }else{
              $('#course').empty();
            }
        });
    });



    $(document).ready(function() {
        $('#course').on('change', function() {
            var courseID = $(this).val();
            if(courseID) {
                $.ajax({
                    url: '/attendance_course_dropdown-data/'+courseID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    success:function(data) {
                      if(data.length){
                        $("#mybody").empty();
                        $("#mybody").focus;
                        $("#myhead").empty();
                        $("#myhead").append(
                             '<tr>'+
                                '<th> Student </th>'+
                                '<th> Course </th>'+
                                '<th> Lecture </th>'+
                                '<th> date </th>'+
                                '<th> Time </th>'+
                                '<th> Status </th>'+
                                '</tr>'
                                );

                        $.each(data, function(key, value){
                            $("#mybody ").append(
                                '<tr>'+
                                '<td>' + value.student + '</td>'+
                                '<td>' + value.course + '</td>'+
                                '<td>' + value.lecture_id + '</td>'+
                                '<td>' + value.date+ '</td>'+
                                '<td>' + value.time+ '</td>'+
                                '<td>' + value.status+ '</td>'+
                                '</tr>'
                                );
                    });
                  }else{
                    $('#mybody ').empty();
                    $('#myhead ').empty();
                    $('#mybody ').append(
                        '<p>There is no student</p>'
                        );

                  }
                  }
                });
            }else{
              $('#mybody').empty();
            }
        });
    });


</script>
@endsection​