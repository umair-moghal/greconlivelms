@extends('layouts.app')
@section('content')

<div>
  <div id="message">
  @if (Session::has('message'))
    <div class="alert alert-info">
      {{ Session::get('message') }}
    </div>
  @endif
</div>
  <form action="{{url('/resource/create')}}" method="post" enctype="multipart/form-data">
    
    {{@csrf_field()}}

    <div class="title">

      <i class="fas fa-pencil-alt"></i> 

    <h2>Course Resources</h2>

    </div>

    <div class="info">

    <label for="course">Course id:</label>

        <select name="course" id="">
        @foreach ($courses as $course)
          <option value="{{$course->id}}">{{$course->course_name}}</option>
        @endforeach
        </select><br><br>

    <label for="title">Titile:</label><br>
    <input type="text" name="title" value="{{old('title')}}" minlength="3" maxlength ="50" autofocus=""><br><br>

      @error('title')
      <div>
        {{$message}}
      </div>
      @enderror

      <label for="short_des">Short Description:</label><br>
    <input type="text" name="short_des" value="{{old('short_des')}}" minlength="10" maxlength ="1000"><br><br>

      @error('short_des')
      <div>
        {{$message}}
      </div>
      @enderror

    
      <label for="resource">Resource:</label><br>
      <input class="form-control" type="url" name="resource" value={{old('resource')}} minlength="10" maxlength ="110"><br><br>
      
      @error('resource')
        <div>
          {{ $message }}
        </div>
      @enderror

       <div class="form-check">
        <input type="checkbox" name="send_notification"><label> Check to Send Notification for Resource Updates.</label>   
      </div>

    <button type="submit">Submit</button>
  </form>
</div>

<script>

var uploadField = document.getElementById("file");

uploadField.onchange = function() {
    if(this.files[0].size > 100 * 1024 * 1024){
       alert("File is too big!");
       this.value = "";
    };
};

</script>
<script type="text/javascript">
  setTimeout(function() {
    $('#message').fadeOut('fast');
}, 2000);
</script>

 @endsection