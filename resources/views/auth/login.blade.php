<!doctype html>
<html lang="en">

<head>
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <title>Miaki - Login</title>
</head>

<body class="bg-theme bg-theme1">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <h3 class="">Sign in</h3>
                                        <!-- <p>Don't have an account yet? <a href="authentication-signup.html">Sign up here</a></p> -->
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" action="{{route('login')}}" method="POST">
                                            @csrf
                                            <div class="col-12">
                                                <label for="email" class="form-label">Email Address</label>
                                                <div class="input-group" id="email">
                                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email Address">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label">Enter Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end"> <a href="authentication-forgot-password.html">Forgot Password ?</a>
                                            </div> -->
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-light"><i class="bx bxs-lock-open"></i>Sign in</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    </script>
</body>

</html>