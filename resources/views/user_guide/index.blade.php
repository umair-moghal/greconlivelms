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
@endsection