@extends('layouts.app')
@section('content')

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
        <li class = "active">User Guide</li>
    </ol>
  </div>
  <div class="assignment">
      <div class="card-header user_guide">
        <div class="user_guide_titl text-center">
          <h3>User Guide</h3>
          <div class="col-md-3 d-flex align-items-center">

            

                  <a href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i></a>

                

          </div>
        </div>
        <div class="ug_boxes">
          <div class="row">
            @if(count($guides) > 0)
              @foreach($guides as $guide)

                <div class="col-md-6 p_left">
                  <div class="box_outline">
                      <a href="#" data-toggle="modal" data-target="#editguide"><i class="fa fa-pencil"></i></a>
                    <div class="ug_img text-center">
                      <img src="{{asset('assets/img/upload/'.$guide->image)}}"width="50" height="50" alt="" class="img-fluid">
                      <!-- <img src="{{asset('/assets/img/latest/guide1.png')}}" alt="" class="img-fluid"> -->
                      <h5>{{$guide->title}}</h5>
                    </div>
                    <div class="ug_description">
                      <p>{!! $guide->description !!}</p>
                    </div>
                  </div>
                </div>





                <div class="modal fade" id="editguide" tabindex="-1" role="dialog" aria-labelledby="editguideTitle" aria-hidden="true">

                  <div class="modal-dialog modal-dialog-centered" role="document">

                    <div class="modal-content">

                      <div class="cross_modal">

                        <div class="modal_title">

                          <h3>Edit User Guide</h3>

                        </div>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                          <span aria-hidden="true" class="cross_btn">&times;</span>

                        </button>

                      </div>

                      <div class="modal-body">

                        <form method="POST" action="/userguide/update" enctype="multipart/form-data">

                          @csrf
                          <input type="hidden" name="guide" value="{{$guide->id}}">


                          <!-- <input type="hidden" name="id" value=""> -->
                            <div class="col-md-12 p_right">

                                <div class="file_spacing">

                                    <input type="file" class="choose" name="image" accept="image/x-png,image/gif,image/jpeg" size="max:255" >
                                    <img src="{{asset('assets/img/upload/'.$guide->image)}}"width="50" height="50" alt="" class="img-fluid">

                                     <label>Image<span class="red">*</span></label>
                                </div>

                                  @error('image')

                                  <span class="invalid-feedback" role="alert">

                                  <strong>{{ $message }}</strong>

                                  </span>

                                  @enderror

                            </div>

                            <br><br>

                          <div class="custom_input_main">
                              <input type="text" class="form-control" value="{{ $guide->title }}" name="title" required="" minlength="3" maxlength ="50" autofocus="">

                              <label>Title<span class="red">*</span></label>

                            @error('title')

                              <span class="invalid-feedback" role="alert">

                              <strong>{{ $message }}</strong>

                              </span>

                            @enderror

                          </div>
                            <br><br>


                          <div class=" custom_input_main">

                            <textarea name="description" cols="8" id="txtEditor" value="{!! $guide->description !!}" style="height: 35px;width: 100%;" required="">
                              {!! $guide->description !!}
                            </textarea>


                            <label>Enter Description <span class="red">*</span></label>

                          </div>

                           
                          <div class="s_form_button">

                            <a href="{{ url()->previous() }}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                            <button type="submit" class="btn save_btn">Update</button>

                          </div>

                        </form>

                      </div>

                    </div>

                  </div>

                </div> 





























              @endforeach
            @else
              <p>No Guide is available for you.</p>
            @endif
           <!--  <div class="col-md-6 p_right">
              <div class="box_outline">
                <div class="ug_img text-center">
                  <img src="{{asset('/assets/img/latest/guide2.png')}}" alt="" class="img-fluid">
                  <h5>2.Finibus Bonorum</h5>
                </div>
                <div class="ug_description">
                  <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                </div>
              </div>
            </div>
            <div class="col-md-6 p_left">
              <div class="box_outline">
                <div class="ug_img text-center">
                  <img src="{{asset('/assets/img/latest/guide3.png')}}" alt="" class="img-fluid">
                  <h5>3.The standard Lorem</h5>
                </div>
                <div class="ug_description">
                  <p>"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes.</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 p_right">
              <div class="box_outline">
                <div class="ug_img text-center">
                  <img src="{{asset('/assets/img/latest/guide4.png')}}" alt="" class="img-fluid">
                  <h5>4.Ipsum passage</h5>
                </div>
                <div class="ug_description">
                  <p>"At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
                </div>
              </div>
            </div> -->
          </div>
        </div>               	 
      </div>
  </div>   


<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="cross_modal">

        <div class="modal_title">

          <h3>Add User Guide</h3>

        </div>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true" class="cross_btn">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <form method="POST" action="/userguide/store" enctype="multipart/form-data">

          @csrf

          <!-- <input type="hidden" name="id" value=""> -->
            <div class="col-md-12 p_right">

                <div class="file_spacing">

                    <input type="file" class="choose" name="image" accept="image/x-png,image/gif,image/jpeg" size="max:255" required>

                     <label>Image<span class="red">*</span></label>
                </div>

                  @error('image')

                  <span class="invalid-feedback" role="alert">

                  <strong>{{ $message }}</strong>

                  </span>

                  @enderror

            </div>

            <br><br>

          <div class="custom_input_main">
              <input type="text" class="form-control" value="{{ old('title')}}" name="title" required="" minlength="3" maxlength ="50" autofocus="">

              <label>Title<span class="red">*</span></label>

            @error('title')

              <span class="invalid-feedback" role="alert">

              <strong>{{ $message }}</strong>

              </span>

            @enderror

          </div>
            <br><br>


          <div class=" custom_input_main">

            <textarea name="description" cols="8" id="txtEditor" value="{!! old('description') !!}" style="height: 35px;width: 100%;" required="">

            </textarea>

            <label>Enter Description <span class="red">*</span></label>

          </div>

           
          <div class="s_form_button">

            <a href="{{ url()->previous() }}"><button type="button" class="btn cncl_btn">Cancel</button></a>

            <button type="submit" class="btn save_btn">Save</button>

          </div>

        </form>

      </div>

    </div>

  </div>

</div> 







<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'txtEditor' );
</script>
<script type="text/javascript">
  setTimeout(function() {
  $('#message').fadeOut('fast');
  }, 2000);
</script>
@endsection