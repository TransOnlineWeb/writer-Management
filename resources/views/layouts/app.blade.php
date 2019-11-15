<!DOCTYPE html>
<html lang="en">


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Writter</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="Free HTML5 Website Template by freehtml5.co" />
            <meta name="keywords" content="responsive" />

            <!-- Facebook and Twitter integration -->
            <meta property="og:title" content=""/>
            <meta property="og:image" content=""/>
            <meta property="og:url" content=""/>
            <meta property="og:site_name" content=""/>
            <meta property="og:description" content=""/>
            <meta name="twitter:title" content="" />
            <meta name="twitter:image" content="" />
            <meta name="twitter:url" content="" />
            <meta name="twitter:card" content="" />

            <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,700,800" rel="stylesheet">

            <!-- Animate.css -->
            <!--<link rel="stylesheet" href="{{ URL::asset('css/animate.css') }}c">-->
            <!-- Icomoon Icon Fonts-->
            <link rel="stylesheet" href="{{ URL::asset('front/css/icomoon.css') }}">
            <!-- Bootstrap  -->
            <link rel="stylesheet" href="{{ URL::asset('front/css/bootstrap.css') }}">

            <!-- Owl Carousel  -->
            <link rel="stylesheet" href="{{ URL::asset('front/css/owl.carousel.min.css') }}">
            <link rel="stylesheet" href="{{ URL::asset('front/css/owl.theme.default.min.css') }}">

            <!-- Theme style  -->
            <link rel="stylesheet" href="{{ URL::asset('front/css/style.css') }}">

            <!-- Modernizr JS -->
            <!--<script src="{{ URL::asset('js/modernizr-2.6.2.min.js') }}"></script>-->
            <!-- FOR IE9 below -->
            <!--[if lt IE 9]>
            <script src="js/respond.min.js"></script>
            <![endif]-->

    </head>


    <body>

        <div class="fh5co-loader"></div>

        <div id="page">

            <nav class="fh5co-nav" role="navigation">
           
                <div class="top-menu">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-2">
                                <div id="fh5co-logo"><a href="index.html">Smart<span>.Writters</span></a></div>
                            </div>
                            <div class="col-xs-10 text-right menu-1">
                                <ul>
                                    <!-- <li class="active"><a href="index.html">Home</a></li> -->
                                    <li><a href="{{URL::to('/')}}">Home</a></li>
                                    <li><a href="{{URL::to('/about')}}">About</a></li>
                                    <li class="has-dropdown">
                                        <a href="{{URL::to('/services')}}">Services</a>
<!--                                        <ul class="dropdown">
                                            <li><a href="#">Web Design</a></li>
                                            <li><a href="#">eCommerce</a></li>
                                            <li><a href="#">Branding</a></li>
                                            <li><a href="#">API</a></li>
                                        </ul>-->
                                    </li>
                                    <li><a href="{{URL::to('/contact')}}">Contact</a></li>
                                    <!--<li class="btn-cta"><a href="#"><span>Login</span></a></li>-->


                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                   
                                </ul>

                            </div>
                        </div>

                    </div>
                </div>
            </nav>

            

            
        <main class="py-4">
            @yield('content')
        </main>
   

            <footer id="fh5co-footer" role="contentinfo">
                <div class="container">
                    <div class="row row-pb-md">
                        <div class="col-md-4 fh5co-widget">
                            <h3>A Little About Us.</h3>
                            <p>Facilis ipsum reprehenderit nemo molestias. Aut cum mollitia reprehenderit. Eos cumque dicta adipisci architecto culpa amet.</p>
                            <p><a class="btn btn-primary btn-outline with-arrow" href="#">Learn More <i class="icon-arrow-right"></i></a></p>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                            <ul class="fh5co-footer-links">
                                 <li class="menu-1"><h3>PRODUCT</h3></li>

                                <li><a href="#">About</a></li>
                                <li><a href="#">Team</a></li>
                                <li><a href="#">Blog</a></li>
                            </ul>
                        </div>

                        <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                            <ul class="fh5co-footer-links">
                                 <li class="menu-1"><h3>SUPPORT</h3></li>

                                <li><a href="#">How it works</a></li>
                                <li><a href="#">Privacy</a></li>
                                <li><a href="#">Testimonials</a></li>
                            </ul>
                        </div>

                        <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                            <ul class="fh5co-footer-links">
                                  <li class="menu-1"><h3>RESOURCES</h3></li>

                                <li><a href="#">Testimonials</a></li>
                              
                            </ul>
                        </div>
                    </div>

                    <div class="row copyright">
                        <div class="col-md-12 text-center">
                            <p>
                                 &copy; 2017-<?php echo date("Y"); ?> All Rights Reserved.
                            </p>
                            <p>
                            <ul class="fh5co-social-icons">
                                <li><a href="#"><i class="icon-twitter"></i></a></li>
                                <li><a href="#"><i class="icon-facebook"></i></a></li>
                                <li><a href="#"><i class="icon-linkedin"></i></a></li>
                                <li><a href="#"><i class="icon-dribbble"></i></a></li>
                            </ul>
                            </p>
                        </div>
                    </div>

                </div>
            </footer>
        </div>

        <div class="gototop js-top">
            <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
        </div>

        <!-- jQuery -->
        <script src="front/js/jquery.min.js"></script>
        <!-- jQuery Easing -->
        <script src="front/js/jquery.easing.1.3.js"></script>
        <!-- Bootstrap -->
        <script src="front/js/bootstrap.min.js"></script>
        <!-- Waypoints -->
        <script src="front/js/jquery.waypoints.min.js"></script>
        <!-- Stellar Parallax -->
        <script src="front/js/jquery.stellar.min.js"></script>
        <!-- Carousel -->
        <script src="front/js/owl.carousel.min.js"></script>
        <!-- Main -->
        <script src="front/js/main.js"></script>
</body>
</html>
