<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laravel Payment API</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Gradient Able Bootstrap admin template made using Bootstrap 4. The starter version of Gradient Able is completely free for personal project." />
    <meta name="keywords" content="free dashboard template, free admin, free bootstrap template, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="codedthemes">
    <!-- Favicon icon -->
    <link rel="icon" href="assets/backend/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/bootstrap/css/bootstrap.min.css') }}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icon/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icon/font-awesome/css/font-awesome.min.css') }}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icon/icofont/css/icofont.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/jquery.mCustomScrollbar.css') }}">
</head>

<body class="fix-menu">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="loader-bar"></div>
        </div>
    </div>
    <!-- Pre-loader end -->

    <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <div class="login-card card-block auth-body mr-auto ml-auto">
                        <form action="{{ route('entry') }}" method="post" class="md-float-material">
                            @csrf
                            <div class="auth-box">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-left txt-primary">Few Clicks To Go..</h3>
                                    </div>
                                </div>
                                <hr />
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-left txt-primary">Email : frranad1@gmail.com</h3>
                                        <h3 class="text-left txt-primary">Password : 12345</h3>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input type="text" name="data" class="form-control" placeholder="Username\Email">
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                    <span class="md-line"></span>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <input type="submit" value="Enter" name="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">
                                    </div>
                                </div>

                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('assets/backend/js/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/backend/js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/backend/js/popper.js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/backend/js/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('assets/backend/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ asset('assets/backend/js/modernizr/modernizr.js') }}"></script>
    <!-- am chart -->
    <script src="{{ asset('assets/backend/pages/widget/amchart/amcharts.min.js') }}"></script>
    <script src="{{ asset('assets/backend/pages/widget/amchart/serial.min.js') }}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{ asset('assets/backend/js/chart.js/Chart.js') }}"></script>
    <!-- Todo js -->
    <script type="text/javascript " src="{{ asset('assets/backend/pages/todo/todo.js ') }}"></script>
    <!-- Custom js -->
    <script type="text/javascript" src="{{ asset('assets/backend/pages/dashboard/custom-dashboard.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/backend/js/script.js') }}"></script>
    <script type="text/javascript " src="{{ asset('assets/backend/js/SmoothScroll.js') }}"></script>
    <script src="{{ asset('assets/backend/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/vartical-demo.js') }}"></script>
    <script src="{{ asset('assets/backend/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
</body>

</html>