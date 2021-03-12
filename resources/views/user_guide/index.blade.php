@extends('layouts.app')
@section('content')
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

              <div class="p_mob">

                <div class="edit_mob">

                  <a href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i></a>

                </div>

              </div>

          </div>
        </div>
        <div class="ug_boxes">
          <div class="row">
            <div class="col-md-6 p_left">
              <div class="box_outline">
                <div class="ug_img text-center">
                  <img src="{{asset('/assets/img/latest/guide1.png')}}" alt="" class="img-fluid">
                  <h5>1.Scope and Purpose</h5>
                </div>
                <div class="ug_description">
                  <p>"On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will,</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 p_right">
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
            </div>
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

      <form method="POST" action="/userguide/store">

        @csrf

        <!-- <input type="hidden" name="id" value=""> -->

        <div class="col-md-6 p_left">

          <div class="inputfile-box">
            <input type="file" name="image"   onchange='uploadFile(this)' accept="image/x-png,image/gif,image/jpeg" required="" autofocus="">
            <label>Image<span class="red">*</span></label>
            </label>
          </div>
        </div>
          <br><br>

        <div class="custom_input_main">
            <input type="text" class="form-control" value="{{ old('title')}}" name="sname" required="" minlength="3" maxlength ="50" autofocus="">

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


<script>

  CKEDITOR.replace( 'txtEditor' );

</script>
@endsection