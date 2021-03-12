@extends('layouts.app')



@section('content')

<form method="POST" action="{{url('update',Auth::user()->id)}}" enctype="multipart/form-data">

  @csrf

  <label><h6 style="color:black; margin-right: 10px">name </h6></label>

  <input type="text" name="name" value="{{$user->name}}">

  <br><br>

  <label><h6 style="color:black; margin-right: 10px">email</h6></label>

  <input type="email" name="email" value="{{$user->email}}">

  @error('email')

    <span class="invalid-feedback" role="alert">

        <strong>{{ $message }}</strong>

    </span>

  @enderror

    <br><br>

  <label>

    <h6 style="color:black; margin-right: 10px">Contact</h6></label>

  <input type="tel" name="contact" value="{{$user->contact }}"  class="mb-4" placeholder="xxxx-xxxxxxx" pattern="03[0-9]{2}-(?!1234567)(?!1111111)(?!7654321)[0-9]{7}" required="" minlength="12" maxlength = "12">



  <br><br>

  <label><h6 style="color:black; margin-right: 10px">Your Image</h6></label>

  <input type="file" name="image" value="{{$user->image}}" accept="image/x-png,image/gif,image/jpeg">

  <br>

  <img src="{{asset('/img/upload/'.$user->image)}}" width ="100" >

  <br><br>

  <label><h6 style="color:black; margin-right: 10px">Bio</h6></label>

  <input type="text" name="bio" value="{{ $user->bio }}" min="3" max="200">

  <input type="submit" name="update" value="update">

</form>

<script>

  $(":input").inputmask();

</script>

@endsection