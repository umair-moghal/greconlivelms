@extends('layouts.app')



@section('content')

<style type="text/css">
  
.textfirst {
      padding: 7px 10px;
    border: 1px solid #585858;
    box-sizing: border-box;
    border-radius: 5px;
    transition: .3s;
    transition: .3s ease-out;
    color: #585858 !important;
}

  div.mm-dropdown {
  /*border: 1px solid #ddd;*/
  width: 100%;
  border-radius: 3px;
}

div.mm-dropdown ul {
  list-style: none;
  padding: 0;
  /*border: 1px solid;*/
  margin: 0;
  border-top: 0;
  border-radius: 5px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

div.mm-dropdown div.textfirst img.down {
  float: right;
  margin-top: 5px
} 

div.mm-dropdown ul li {
  display: none;
  padding-left: 25px;
      padding: 6px 22px;
    border: 1px solid;
    border-top: 0;
}

div.mm-dropdown ul li.main {
  display: block;
}

div.mm-dropdown ul li img {
  width: 20px;
  height: 20px;
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

    <li class = "active">Add New Subject</li>

  </ol>

</div>

<div class="content_main">

  <div class="profile_main">

    <div class="profile mt-0">

      <div class="course card-header card-header-warning card-header-icon">

        

        <h3 class="main_title_ot">Add New Subject</h3>

        <div class="tab-content">

          <form method="POST" action="/classstore" enctype="multipart/form-data">

                 @csrf

            @foreach ($errors->all() as $error)

              <div class="alert alert-danger">{{ $error }}</div>

            @endforeach

            <div class="tab-pane active" id="tab_default_3">

              <div class="s_profile_fields">

                <div class="row">

                  <div class="col-md-6 p_left">

                    <div class="custom_input_main mobile_field">

                      <input type="text" class="form-control" value="{{ old('name')}}" name="name" required="" minlength="1" maxlength ="50" autofocus="">

                      <label>Subject<span class="red">*</span></label>

                    </div>

                    @error('name')

                      <span class="invalid-feedback" role="alert">

                      <strong>{{ $message }}</strong>

                      </span>

                    @enderror

                  </div>


                 



                  <div class="col-md-6 p_left">
                    <div class="mm-dropdown">
                    <div class="textfirst">Select Icon</div>
                    <ul>
                      @foreach($icons as $icon)
                      <li class="input-option" data-value="{{$icon->id}}" name="icon" value="{{$icon->id}}" >
                        <img src="{{asset('/assets/img/upload/'.$icon->image)}}" alt="" width="20" height="20" /> 
                        {{$icon->title}}
                      </li>
                      @endforeach
                    </ul>
                    <input type="hidden" class="option" name="icon" value="{{$icon->id}}" />
                  </div>
                  </div>

                    <div class="s_form_button w-100 text-center">

                      <a  href="{{url('/classes')}}"><button type="button" class="btn cncl_btn">Cancel</button></a>

                      <button type="submit" class="btn save_btn">Save</button>

                    </div>

                  </div>
                </div>
              </div>

              </form>

            </div>

            

          </div>

        </div>

      </div>

    </div>


    <script>

        $(":input").inputmask();

    </script>

    <script type="text/javascript">

      setTimeout(function() {

        $('#message').fadeOut('fast');

    }, 2000);

    </script>   
<script type="text/javascript">
  
  $(function() {
  // Set
  var main = $('div.mm-dropdown .textfirst')
  var li = $('div.mm-dropdown > ul > li.input-option')
  var inputoption = $("div.mm-dropdown .option")
  var default_text = 'Select<img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-arrow-down-b-128.png" width="10" height="10" class="down" />';

  // Animation
  main.click(function() {
    main.html(default_text);
    li.toggle('fast');
  });

  // Insert Data
  li.click(function() {
    // hide
    li.toggle('fast');
    var livalue = $(this).data('value');
    var lihtml = $(this).html();
    main.html(lihtml);
    inputoption.val(livalue);
  });
});
</script>
@endsection

       