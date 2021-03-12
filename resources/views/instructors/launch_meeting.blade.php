<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/assets/img/apple-icon.png')}}">

    <link rel="icon" type="image/png" href="{{asset('/assets/img/favicon.png')}}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>

    Grecon

    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.8.5/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.8.5/css/react-select.css" />

</head>
<body>
        <div style="margin-top:50px; " id="zmmtg-root"></div>
        <div id="aria-notify-area"></div>
        <div class="ReactModalPortal"></div>
        <div class="ReactModalPortal"></div>
        <div class="ReactModalPortal"></div>
        <div class="ReactModalPortal"></div>
        <div class="global-pop-up-box"></div>
        <div class="sharer-controlbar-container sharer-controlbar-container--hidden"></div>
      
    <!-- import ZoomMtg dependencies -->
    <script src="https://source.zoom.us/1.8.5/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/1.8.5/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/1.8.5/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/1.8.5/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/1.8.5/lib/vendor/lodash.min.js"></script>

    <!-- import ZoomMtg -->
    <script src="https://source.zoom.us/zoom-meeting-1.8.5.min.js"></script>
    
    <!-- import local .js file -->
    <?php
      $user = Auth::user();
    ?>

    <script>
        ZoomMtg.setZoomJSLib('https://source.zoom.us/1.8.5/lib', '/av'); 
        ZoomMtg.preLoadWasm();
        ZoomMtg.prepareJssdk();
        const zoomMeeting = document.getElementById("zmmtg-root");
        ZoomMtg.init({
            leaveUrl: "{{url('/course')}}"
        });
        ZoomMtg.join({
            signature: "{!! $a !!}",
            apiKey: "qrmEqiqIS7C244YKZoJyMw",
            meetingNumber: "{!! $lec->meeting_id !!}",
            userName: "{!! $user->name !!}",
            passWord: "123456789",
            error(res) { 
                console.log(res) 
            }
        });

    </script>
</body>
</html>