<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Dashboard</title>

    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{-- font awesome version 6 upgrade link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <style>
        /* Smooth styling transitions */
        .topbar {
            box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.05) !important;
            /* 🟩 REMOVE THE HUGE ROUNDED EDGES ON THE NAV BAR CONTAINER */
            border-radius: 0 !important;
        }

        /* Force the navbar element itself to be square */
        nav.navbar.topbar {
            border-radius: 0 !important;
        }

        .dropdown-list .dropdown-header {
            background-color: #4e73df !important;
            border: 1px solid #4e73df !important;
            padding-top: .75rem !important;
            padding-bottom: .75rem !important;
        }

        .sidebar-dark .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0 !important; /* Made this square too to match */
            margin: 0 8px;
            width: auto;
        }

        /* Keep dropdown menu windows, badges, and status lights sharp */
        .dropdown-menu,
        .dropdown-list,
        .badge,
        .btn,
        .icon-circle,
        .img-profile {
            border-radius: 0 !important;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin Dashboard</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin#dashboard')}}"><i class="fas fa-fw fa-table"></i><span>Dashboard </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('category#list') }}"><i class="fas fa-solid fa-circle-plus"></i></i><span>Category </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('product#createPage') }}"><i class="fas fa-solid fa-plus"></i></i><span>Add Products </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('product#list') }}"><i class="fas fa-solid fa-layer-group"></i><span>Product List </span></a>
            </li>

            @if (Auth()->user()->role == 'superadmin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('payment#list') }}"><i class="fas fa-solid fa-credit-card"></i></i><span>Payment Method </span></a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin#orderList') }}"><i class="fas fa-solid fa-cart-shopping"></i><span>Order Board </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile#changePasswordPage') }}"><i class="fas fa-solid fa-lock"></i><span>Change Password </span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <li class="nav-item px-3 mb-3">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger w-100 py-2 shadow-sm">
                        <i class="fas fa-solid fa-right-from-bracket me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw text-gray-600"></i>
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header font-weight-bold">
                                    Notifications Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center py-3" href="{{ route('admin#orderList') }}">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary text-white p-2 rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                            <i class="fas fa-file-invoice text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Just Now</div>
                                        <span class="font-weight-bold text-gray-800">A new customer order has been placed!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center py-3" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning text-white p-2 rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">2 hours ago</div>
                                        <span class="text-gray-700">Stock Alert: Certain items are running low.</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center py-3" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success text-white p-2 rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                            <i class="fas fa-wallet text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Today</div>
                                        <span class="text-gray-700">Daily transaction processing settlement complete.</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500 py-2" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw text-gray-600"></i>
                                <span class="badge badge-danger badge-counter">2</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header font-weight-bold">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center py-3" href="#">
                                    <div class="dropdown-list-image mr-3 position-relative">
                                        <img class="rounded-circle" src="{{ asset('picForDefault/adminProfile.webp') }}" alt="..." style="width: 40px; height:40px;">
                                        <div class="status-indicator bg-success position-absolute bottom-0 end-0 rounded-circle border border-white" style="width:10px; height:10px;"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate text-gray-800">Hi there! Is the payment verification step confirmed for Order #2839?</div>
                                        <div class="small text-gray-500">Customer Support · 45m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center py-3" href="#">
                                    <div class="dropdown-list-image mr-3 position-relative">
                                        <img class="rounded-circle" src="{{ asset('picForDefault/adminProfile.webp') }}" alt="..." style="width: 40px; height:40px;">
                                        <div class="status-indicator bg-warning position-absolute bottom-0 end-0 rounded-circle border border-white" style="width:10px; height:10px;"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate text-gray-700">The supplier updated items listings context for next week.</div>
                                        <div class="small text-gray-500">Inventory Management · 3h</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500 py-2" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-700 font-weight-bold small">
                                    {{ Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname }}
                                </span>
                                <img class="img-profile rounded-circle shadow-sm"
                                src="{{ Auth::user()->profile == null ? asset('picForDefault/adminProfile.webp') : asset('profile/'.Auth::user()->profile) }}" style="width:32px; height:32px;">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item py-2" href="{{ route('profile#edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    My Profile
                                </a>

                                @if (Auth()->user()->role == 'superadmin')
                                    <a class="dropdown-item py-2" href="{{ route('account#newAccountPage') }}">
                                        <i class="fas fa-user-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Add Admin Account
                                    </a>
                                    <a class="dropdown-item py-2" href="{{ route('account#adminList') }}">
                                        <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Admin Registry List
                                    </a>
                                    <a class="dropdown-item py-2" href="{{ route('account#userList') }}">
                                        <i class="fas fa-users-gear fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Customer Accounts List
                                    </a>
                                @endif

                                <a class="dropdown-item py-2" href="{{ route('profile#changePasswordPage') }}">
                                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <div class="p-2">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm text-white w-100 py-1">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </li>

                    </ul>

                </nav>
                @yield('content')

    {{-- for sweet alert --}}
    @include('sweetalert::alert')

    <script src="{{ asset ('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset ('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.css') }}">

    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset ('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset ('admin/js/sb-admin-2.min.js') }}"></script>

    {{-- sweet alert cdn link --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js-script')

    {{-- for photo file preview --}}
    <script>
        function loadFile(event) {
            var reader = new FileReader();

            reader.onload = function () {
                var output = document.getElementById("output");
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>

</html>
