<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Page-->
    <title>Waitlist Apps</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('scripts/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('scripts/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('scripts/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('scripts/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- scripts CSS-->
    <link href="{{ asset('scripts/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <!-- Main CSS-->
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <header class="">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="header-wrap">
                    <div class="logo">
                        User Dashboard
                    </div>
                    <h3 class="mx-auto text-success text-uppercase">
                            Waitlist Application
                    </h3>
                    <div class="d-flex header-button">
                        <div class="account-wrap">
                            <div class="account-item clearfix js-item-menu">
                                <div class="content">
                                    <a class="js-acc-btn" href="#">{{ auth::user()->name}}</a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="account-dropdown__footer">
                                        <a onclick="event.preventDefault();                     document.getElementById('logout-form').submit();" role="button">
                                            <i class="zmdi zmdi-power"></i>Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                             @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END HEADER DESKTOP-->

    <!-- MAIN CONTENT-->
    <div class="main-content" style="padding-top: 50px;">
        <div class="section__content section__content--p30">
            <div class="container-fluid justify-content-center">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        @if(Session::has('flash_message'))
                            <div class="alert alert-danger">
                                {{ Session::get('flash_message') }}
                                {{ Session::forget('flash_message') }}
                            </div>
                        @endif
                            <div class="alert alert-success">
                                Share your referral links online with your friends and family. It will help you buy a new iPhone Product Quickly.
                            </div>
                                <div class="card">
                                    <div class="card-header text-center">
                                        <strong class="card-title">Your Details
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group mt-3">
                                            <li class="list-group-item"><strong>Name:</strong> {{ Auth::user()->name }}</li>
                                            <li class="list-group-item"><strong>Email:</strong> {{ Auth::user()->email }}</li>
                                            <li class="list-group-item"><strong>Referral link:</strong> {{ URL::to('/register?ref='.auth::user()->referral_token) }}</li>
                                            <li class="list-group-item"><strong>Referrer:</strong> {{ Auth::user()->referrer->name ?? 'Not Specified' }}</li>
                                            <li class="list-group-item"><strong>Referral Count:</strong> {{ count(Auth::user()->referrals)  ?? '0' }}</li>
                                            <li class="list-group-item"><strong>Your Position:</strong> {{ Auth::user()->position }}</li>
                                        </ul>
                                        
                                    </div>
                                  </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
        
    <!-- Jquery JS-->
    <script src="{{ asset('scripts/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('scripts/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ asset('scripts/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>