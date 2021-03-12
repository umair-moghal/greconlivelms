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

      <li class = "active">Grecon Safety Tips</li>

    </ol>

  </div>

  <div class="content_main">

    <div class="card-header sftp_main">

      <div class="align_dftp">

        @if(count($safetytips)>0)

          <h3 class="mb-0">Grecon Safety Tips</h3>

        @else

          <h3 class="mb-0">No Safety Tips Available</h3>

        @endif

        @if(Auth::user()->role_id == 3)

          <button><a href="{{url('/safetytips/create')}}">Add Safety Tip</a></button>

        @endif

      </div>

      <div class="panel-group" id="accordion">

        @php $counter=0; @endphp 

        @foreach ($safetytips as $safetytip)

          @if ($counter == 0)

            <div class="panel panel-default">

              <div class="panel-heading">

                <h4 class="panel-title">

                <a data-toggle="collapse" data-parent="#accordion" href="#collapse.{{$safetytip->id}}" class="active_stp stmp_accordion">{{$safetytip->title}}</a>

                </h4>

              </div>

              <div id="collapse.{{$safetytip->id}}" class="panel-collapse in collapse show">

                <div class="panel-body">

                  <p>{{$safetytip->description}}</p>

                </div>

                @if(Auth::user()->role_id == 3)

                  <div class="sftp_edit_del">

                    <a class="delete" href="javascript:void(0);" data-id="<?php echo $safetytip->id; ?>">Delete

                    </a>

                    <a href="{{url('/safetytips/edit/'.$safetytip->id)}}">Edit</a>

                  </div>

                @endif

              </div>

            </div>

          @else

            <div class="panel panel-default">

              <div class="panel-heading">

                <h4 class="panel-title">

                <a data-toggle="collapse" data-parent="#accordion" href="#collapse.{{$safetytip->id}}" class="stmp_accordion">

                {{$safetytip->title}}</a>

                </h4>

              </div>

              <div id="collapse.{{$safetytip->id}}" class="panel-collapse collapse">

                <div class="panel-body">

                  <p>{{$safetytip->description}}</p>

                </div>

                @if(Auth::user()->role_id == 3)

                  <div class="sftp_edit_del">

                    <a class="delete" href="javascript:void(0);" data-id="<?php echo $safetytip->id; ?>">Delete

                    </a>

                    <a href="{{url('/safetytips/edit/'.$safetytip->id)}}">Edit</a>

                  </div>

                @endif

              </div>

            </div>

          @endif

          @php $counter++; @endphp

        @endforeach

      </div>

    </div>

  </div>



  <script type="text/javascript">

    setTimeout(function() {

      $('#message').fadeOut('fast');

    }, 2000);

  </script>



  <script type="text/javascript">

  $("body").on( "click", ".delete", function () {

  var task_id = $( this ).attr( "data-id" );

  console.log(task_id);

  var form_data = {

  id: task_id

  };

  swal({

  title: "Do you want to delete this Safety Tip?",

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

  url: '<?php echo url("/safetytips/delete"); ?>',

  data: form_data,

  success: function ( msg ) {

  swal( "@lang('Safety Tip Deleted')", '', 'success' )

  setTimeout( function () {

  location.reload();

  }, 1000 );

  }

  } );

  }

  } );

  } );

  </script>



@endsection