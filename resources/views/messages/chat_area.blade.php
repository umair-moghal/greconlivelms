<div id="message">

  @if (Session::has('message'))

    <div class="alert alert-info">

      {{ Session::get('message') }}

    </div>

  @endif

</div>
      <div class="ticket_chat">
        <div class="msg_img">
          <img src="{{asset('assets/img/upload/'.$msg_user->image)}}" alt="">
          <div class="msg_name">
            <h5>{{$msg_user->name}}</h5>
            <!--
			<p>M.Phil Biology</p>
          -->
		  </div>
        </div>
      </div>
      @foreach($messages as $msg)

        <div class="chat-messages">
          <!-- <div class="message-box-holder">
            <div class="message-box message-partner">
              Hello! Finally found the time to write to you) I need your help in creating interactive animations for my mobile application.
            </div>
          </div>
          <div class="message-box-holder">
            <div class="message-box message-partner">
              Can I send you files?
            </div>
            <p class="admin_days_ago">4 days ago</p>
          </div> -->
          <!-- <div class="message-box-holder">
            <div class="add_check">
              <div class="message-box">
                Hey! Okay, send out.
              </div>
              <span><img src="../assets/img/latest/all-done.svg" alt=""></span>
            </div>
            <p class="user_days_ago">4 days ago</p>
          </div> -->
         <!--  <div class="message-box-holder">
            <div class="message-box message-partner">
              <div class="attachment_send">
                <i class="fa fa-file-o"></i>
                <div class="attachmet_size">
                  <h6>Style.zip</h6>
                  <p>41.36 Mb</p>
                </div>
              </div>
            </div>
          </div> -->
         <!--  <div class="combine_date">
            <p>3 days ago</p>
          </div> -->

          @if($msg->sent_by == Auth::user()->id)
            <div class="message-box-holder">
              <div class="add_check">
                <div class="message-box">
                  {{$msg->content}}
                </div>
                <span><img src="../assets/img/latest/checkmark.svg" alt=""></span>
              </div>
              <!--<p class="user_days_ago">3 days ago</p>-->
            </div>
          @else
            <div class="message-box-holder">
              <div class="message-box message-partner">
                {{$msg->content}}
              </div>
			  
              <!--<p class="admin_days_ago">4 days ago</p>-->
            </div>
          @endif
        </div>
      @endforeach


     <!--  <form method="POST" action="{{ url('/sendmessage') }}" enctype="multipart/form-data">
        @csrf -->
        <!-- <input type="hidden" name="receiver" value="{{$msg_user->id}}"> -->
          <div class="chat-input-holder input-text">
            <div class="main_send">
              <div class="plus_icon">
                <a href="#"><i class="fa fa-plus"></i></a>
                <div class="option_list" style="display: none;">
                  <ul>
                    <li> <a href="#"> <i class="fa fa-file"> </i> Fidddle </a> </li>
                  </ul>
                </div>
              </div>
              {{-- <textarea class="chat-input" placeholder="Type a message here" name="content" value="{!!old('content')!!}" required=""></textarea> --}}
              <input placeholder="Type a message here" class="chat-input" id="mesg_write" name="content" value="{!!old('content')!!}" required="">
            </div>
            <div class="send_icon" id="msg_bottom">
              <a href="javascript:void(0);" data-id="<?php echo $msg_user->id; ?>" id="ahmad_saeed" class="send"><i class="fa fa-paper-plane"></i></a>
              <!-- <button  type="submit"><i class="fa fa-paper-plane"></i></button> -->
            </div>
          </div>
      <!-- </form> -->


<script type="text/javascript">


var Tm;
        Tm = setTimeout(function() {
          var mess = $('#mesg_write').val();
                 if(mess == ""){ 
                    theCall();
                 }   
                      }, 9000);
          

</script>

<script type="text/javascript">
  function theCall(){
                      var receiver = $('#ahmad_saeed').attr( "data-id" );
                      $.ajax( {

                              type: 'get',
                              url: "get_messages/" + receiver,
                              data: "",
                              cache: false,
                              success: function (data)
                              {
                                
                                $('.chat-area').html(data);
                              }

                          } );
                      clearTimeout(Tm);

  }
</script>



<input type="hidden" id="send_id" value="0" />
<script type="text/javascript">


        $( "body" ).on( "click", ".send", function () {
			var count = $("#send_id").val();
			  
			if(count>0) return false;
            count++;
			
			$("#send_id").val(count);
			
			var receiver = $( this ).attr( "data-id" );
			
            var content = $(".chat-input").val();
       
            var form_data = {

                receiver: receiver,

                content: content,

            };

                    $.ajax( {

                        type: 'POST',

                        headers: {

                            'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )

                        },

                        url: '<?php echo url("/sendmessage"); ?>',

                        data: form_data,

                        success: function ( data ) {
                         console.log(data);
                          // $(".input-text").find('textarea').val("");

                          $.ajax( {

                              type: 'get',
                              url: "get_messages/" + receiver,
                              data: "",
                              cache: false,
                              success: function (data)
                              {

                                $('.chat-area').html(data);
                              }

                          } );

                        }

                    } );


            } );
</script>
    