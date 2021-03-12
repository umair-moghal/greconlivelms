<!DOCTYPE html>

<html>

    <head>

        <title>Grecon - Login</title>

        <!-- Latest compiled and minified CSS -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- jQuery library -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Popper JS -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <link href="{{asset('/assets/css/login.css')}}" rel="stylesheet" />

    </head>

    <body>

        <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">

            <div class="card card0 border-0">

                <div class="row d-flex">

                    <div class="col-lg-6">

                        <div class="card1 pb-5">

                            <div class="row"> <img src="{{asset('/assets/img/latest/logo.png')}}" class="logo"> </div>

                            <div class="row px-3 justify-content-center mt-4 mb-5 border-line"> <img src="{{('/assets/img/login.png')}}" class="image"> </div>

                        </div>

                    </div>

                    

                    <div class="col-lg-6">

                        <form method="POST" action="{{url('/loginuser')}}">

                            @csrf

                            <div class="card2 card border-0 px-4 py-5">

                                <div class="login_text">

                                    <h3>Login</h3>

                                </div>

                                <div class="row px-3"> <label class="mb-1">

                                    <h6 class="mb-0 text-sm">Email Address</h6>

                                    </label> <input type="email" name="email" class="mb-4 form-control @error('email') is-invalid @enderror" placeholder="Enter a valid email address" required="">

                                    @error('email')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                    @enderror

                                </div>

                                <div class="row px-3"> <label class="mb-1">

                                    <h6 class="mb-0 text-sm">Password</h6>

                                    </label> <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" required="">

                                    @error('password')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                    @enderror

                                </div>

                                <div class="row px-3 mb-4">

                                    <div class="custom-control custom-checkbox custom-control-inline">   </div>

                                </div>

                                <div class="row mb-3 px-3"> <button type="submit" class="btn btn-blue text-center">Login</button> </div>

                                {{-- <div class="row mb-4 px-3"> <small class="font-weight-bold">Don't have an account? <a href="{{url('/registerpage')}}" class="text-danger ">Register</a></small> </div> --}}

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </body>

</html>