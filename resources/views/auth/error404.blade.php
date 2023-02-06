
<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Error 404 | Agroxa - Responsive Bootstrap 5 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('adminassets/images/favicon.ico') }}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('adminassets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('adminassets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('adminassets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body data-topbar="colored">

    <!-- <body data-layout="horizontal" data-topbar="colored"> -->

        <!-- Background -->
        <div class="account-pages"></div>

        <!-- Begin page -->
        <div class="wrapper-page">
            <div class="card">
                <div class="card-block">

                    <div class="ex-page-content text-center">
                        <h1 class="text-dark">404!</h1>
                        <h4 class="">Sorry, page not found</h4><br>

                        <a class="btn btn-info mb-5 waves-effect waves-light" href=""><i class="mdi mdi-home"></i>
                            Back to Dashboard</a>
                    </div>

                </div>
            </div>

            <div class="mt-5 text-center">
                <p class="text-muted">©
                    <script>document.write(new Date().getFullYear())</script> Agroxa. Crafted with <i
                        class="mdi mdi-heart text-primary"></i> by Themesbrand
                </p>
            </div>

        </div>

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title px-3 py-4">
                    <a href="javascript:void(0);" class="right-bar-toggle float-end">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                    <h5 class="m-0">Settings</h5>
                </div>

                <!-- Settings -->
                <hr class="" />
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="{{ asset('adminassets/images/layouts/layout-1.png') }}" class="img-fluid img-thumbnail" alt="">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch" checked />
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="{{ asset('adminassets/images/layouts/layout-2.png') }}" class="img-fluid img-thumbnail" alt="">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch"
                            data-bsStyle="adminassets/css/bootstrap-dark.min.css" data-appStyle="adminassets/css/app-dark.min.css" />
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="{{ asset('adminassets/images/layouts/layout-3.png') }}" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input type="checkbox" class="form-check-input theme-choice" id="rtl-mode-switch"
                            data-appStyle="adminassets/css/app-rtl.min.css" />
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>

                </div>

            </div>
            <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('adminassets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('adminassets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('adminassets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('adminassets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('adminassets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('adminassets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

        <!-- App js -->

    </body>

</html>
