<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Shoppiverse : E-commerce Website</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    {{-- custom css for rating --}}
    <link rel="stylesheet" href="{{ asset('user/css/custom.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('user/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('user/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <link href="{{ asset('user/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('user/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container-fluid fixed-top">
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="#" class="navbar-brand">
                    <h1 class="text-primary display-6">Shoppiverse</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="{{ route('user#homePage') }}" class="nav-item nav-link">Shop</a>
                        <a href="{{ route('user#cart') }}" class="nav-item nav-link">Cart</a>
                        <a href="{{ route('user#contactPage') }}" class="nav-item nav-link">Contact Us</a>
                    </div>
                    <div class="d-flex m-3 me-0">
                        <a href="{{ route('user#cart') }}" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                        </a>
                        <a href="{{ route('user#orderList') }}" class="position-relative me-4 my-auto">
                            <i class="fa-solid fa-list-check fa-2x"></i>
                        </a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle my-auto mt-2" data-bs-toggle="dropdown">
                                <img src="{{ asset(Auth::user()->profile == null ? 'picForDefault/adminProfile.webp' : 'profile/' . Auth::user()->profile) }}" style="width: 50px" class="img-profile rounded-circle" alt="">
                                <span>{{ Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname }}</span>
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="{{ route('user#editProfile') }}" class="dropdown-item my-2">Edit Profile</a>
                                <a href="{{ route('user#changePasswordPage') }}" class="dropdown-item my-2">Change Password</a>
                                <a href="#" class="dropdown-item my-2">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <input type="submit" value="Logout" class="btn btn-outline-success rounded w-100 mb-3">
                                    </form>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    @yield('content')

    @include('sweetalert::alert')

    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.3);">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-3">
                        <a href="{{ route('user#homePage') }}" class="text-decoration-none">
                            <h1 class="text-primary mb-0 fw-bold">Shoppiverse</h1>
                            <p class="text-secondary mb-0 small">Fresh products</p>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <form action="{{ route('user#subscribe') }}" method="POST" class="position-relative mx-auto">
                            @csrf
                            <input class="form-control border-0 w-100 py-3 px-4 rounded-pill bg-white text-dark"
                                   type="email"
                                   name="subscriber_email"
                                   placeholder="Your Email Address"
                                   required>
                            <button type="submit"
                                    class="btn btn-primary border-0 py-3 px-4 position-absolute rounded-pill text-white fw-bold"
                                    style="top: 0; right: 0; height: 100%;">
                                Subscribe Now
                            </button>
                        </form>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-lg-end justify-content-start pt-2 gap-2">
                            <a href="https://www.facebook.com" target="_blank" class="btn btn-outline-secondary rounded-0 d-flex align-items-center justify-content-center custom-social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://t.me//charmedChan" target="_blank" class="btn btn-outline-secondary rounded-0 d-flex align-items-center justify-content-center custom-social-icon"><i class="fab fa-telegram-plane"></i></a>
                            <a href="https://github.com/ChanMyaeKyaw1" target="_blank" class="btn btn-outline-secondary rounded-0 d-flex align-items-center justify-content-center custom-social-icon"><i class="fab fa-github"></i></a>
                            <a href="https://www.linkedin.com/in/chan-myae-kyaw-054105288" target="_blank" class="btn btn-outline-secondary rounded-0 d-flex align-items-center justify-content-center custom-social-icon"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3 fw-bold">Why People Like us!</h4>
                        <p class="mb-4 text-white-50">Easy to use our website and We deliver only fresh products with fair price.</p>
                        <a href="{{ route('user#homePage') }}" class="btn btn-sm btn-outline-primary py-2 px-4 rounded-0 text-uppercase fw-bold text-white">Shop Now</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3 fw-bold">Shop Info</h4>
                        <a class="btn-link text-decoration-none" href="#">About Us</a>
                        <a class="btn-link text-decoration-none" href="{{ route('user#contactPage') }}">Contact Us</a>
                        <a class="btn-link text-decoration-none" href="#">Privacy Policy</a>
                        <a class="btn-link text-decoration-none" href="#">Terms & Condition</a>
                        <a class="btn-link text-decoration-none" href="#">Return Policy</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3 fw-bold">Account</h4>
                        <a class="btn-link text-decoration-none" href="{{ route('user#editProfile') }}">My Profile</a>
                        <a class="btn-link text-decoration-none" href="{{ route('user#homePage') }}">Shop Details</a>
                        <a class="btn-link text-decoration-none" href="{{ route('user#cart') }}">Shopping Cart</a>
                        <a class="btn-link text-decoration-none" href="{{ route('user#orderList') }}">Order History</a>
                        <a class="btn-link text-decoration-none" href="{{ route('user#changePasswordPage') }}">Security Settings</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3 fw-bold">Contact</h4>
                        <p class="mb-2 text-white-50"><i class="fas fa-map-marker-alt text-primary me-2"></i> Address: Mingalardon, Yangon, Myanmar</p>
                        <p class="mb-2 text-white-50"><i class="fas fa-envelope text-primary me-2"></i> Email: chanmyaekyaw.charm@gmail.com</p>
                        <p class="mb-3 text-white-50"><i class="fas fa-phone text-primary me-2"></i> Phone: +959 975 897 338</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark border-top border-secondary py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-white-50 small">
                        &copy; {{ date('Y') }} <a href="{{ route('user#homePage') }}" class="text-primary text-decoration-none fw-bold">Shoppiverse</a>. All Rights Reserved.
                    </span>
                </div>
                <div class="col-md-6 text-center text-md-end text-white-50 small">
                    Handcrafted for fresh quality deliveries.
                </div>
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('user/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('user/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('user/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    {{-- sweet alert cdn link --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script src="{{ asset('user/js/main.js') }}"></script> --}}

    @yield('js-script')

</body>
</html>
