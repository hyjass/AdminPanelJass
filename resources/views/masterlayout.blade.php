<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        @yield('title', 'Dashboard')
    </title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">

        <!-- jQuery -->


        <!-- End layout styles -->
        {{-- <link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}" /> --}}
        <style>
            select.form-control {
                color: black;
                background-color: white;

            }

            select.form-select {
                padding: 15px 30px;
                !important
            }

            .texts::placeholder {
                font-weight: 500;
                color: #6c757d;
            }

            /* Hide sidebar when 'active' class is added */
            .sidebar.sidebar-offcanvas.active {
                transform: translateX(-250px);
            }

            /* Optional: Shift main content if sidebar is hidden */
            .page-body-wrapper.sidebar-hidden .main-panel {
                margin-left: 0 !important;
                width: 100%;
            }
        </style>

</head>

<body>
    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <a class="navbar-brand brand-logo" href="#"><img src="{{ asset('assets/logo.svg') }}"
                        alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="#"><img src="{{ asset('assets/logo-mini.svg') }}"
                        alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="https://static.vecteezy.com/system/resources/previews/018/765/757/original/user-profile-icon-in-flat-style-member-avatar-illustration-on-isolated-background-human-permission-sign-business-concept-vector.jpg"
                                    alt="image">
                            </div>
                            <div class="nav-profile-text">
                                <p class="mt-3 text-black">

                                    {{ Auth::user()->name ?? 'Guest' }}
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">

                            @auth
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="mdi mdi-account-circle-outline me-2 text-primary"></i> Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    <i class="mdi mdi-logout me-2 text-primary"></i> Signout
                                </a>
                            @endauth

                        </div>
                    </li>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <a href="#" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="https://static.vecteezy.com/system/resources/previews/018/765/757/original/user-profile-icon-in-flat-style-member-avatar-illustration-on-isolated-background-human-permission-sign-business-concept-vector.jpg"
                                    alt="profile" />
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                                <span class="font-weight-bold">
                                    @auth
                                        {{ Auth::user()->name }}
                                    @else
                                        Guest
                                    @endauth
                                </span>
                            </div>
                        </a>
                    </li>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <span class="menu-title">Dashboard</span>
                                <i class="mdi mdi-home menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.userdata') }}">
                                <span class="menu-title">Users</span>
                                <i class="mdi mdi-view-list menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.categories') }}">
                                <span class="menu-title">Categories</span>
                                <i class="mdi mdi-view-list menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.subcategories') }}">
                                <span class="menu-title">Subcategories</span>
                                <i class="mdi mdi-view-list menu-icon"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.products') }}">
                                <span class="menu-title">Products</span>
                                <i class="mdi mdi-view-list menu-icon"></i>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.profile') }}">
                            <span class="menu-title">Profile</span>
                            <i class="mdi mdi-view-list menu-icon"></i>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span> Dashboard
                        </h3>
                    </div>
                    <div>
                        @section('data')
                        @show
                    </div>

                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js">
        </script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                $('.navbar-toggler[data-toggle="minimize"]').on('click', function() {
                    $('#sidebar').toggleClass('active'); // or any class you want
                    $('.page-body-wrapper').toggleClass('sidebar-hidden'); // optional for shifting main content
                });
            });


            $(document).ready(function() {
                let table = new DataTable('#datatable', {
                    searching: false
                });

                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                });

                $('#from').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                }).on('changeDate', function(e) {
                    const fromDate = $('#from').datepicker('getDate');
                    $('#to').datepicker('setStartDate', fromDate);
                });

                $('#to').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                }).on('changeDate', function(e) {
                    const toDate = $('#to').datepicker('getDate');
                    $('#from').datepicker('setEndDate', toDate);
                });

            });
        </script>

        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        @stack('scripts')
        @stack('scriptforuser')

</body>

</html>
