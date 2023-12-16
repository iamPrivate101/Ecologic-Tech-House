<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="SiteMakers.in">
    <link href="{{ asset('front/images/favicon.png') }}" rel="shortcut icon">
    <title>Ecologic Tech House </title>
    <!--====== Google Font ======-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
    <!--====== Vendor Css ======-->
    <link rel="stylesheet" href="{{ url('front/css/vendor.css') }}">
    <!--====== Utility-Spacing ======-->
    <link rel="stylesheet" href="{{ url('front/css/utility.css') }}">
    <!--====== App ======-->
    <link rel="stylesheet" href="{{ url('front/css/app.css') }}">
</head>

<body class="config">
    <div class="preloader is-active">
        <div class="preloader__wrap">
            <img class="preloader__img" src="{{ asset('front/images/preloader.png') }}" alt="">
        </div>
    </div>

    <div id="app">
        <!--====== Main Header ======-->
        @include('front.layout.header')

        <!--====== End - Main Header ======-->
        <!--====== Main App ======-->
        @yield('content')
        <!--====== End - App Content ======-->
        <!--====== Main Footer ======-->
        @include('front.layout.footer')
        <!--====== Modal Section ======-->
        <!--====== Newsletter Subscribe Modal ======-->
        @include('front.newsletter')
        <!--====== End - Newsletter Subscribe Modal ======-->
        <!--====== End - Modal Section ======-->
    </div>
    <!--====== End - Main App ======-->
    <!--====== Google Analytics: change UA-XXXXX-Y to be your site's ID ======-->
    <script>
        window.ga = function() {
            ga.q.push(arguments)
        };
        ga.q = [];
        ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto');
        ga('send', 'pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async defer></script>
    <!--====== Vendor Js ======-->
    <script src="{{ url('front/js/vendor.js') }}"></script>
    <!--====== jQuery Shopnav plugin ======-->
    <script src="{{ url('front/js/jquery.shopnav.js') }}"></script>
    <!--====== App ======-->
    <script src="{{ url('front/js/app.js') }}"></script>
     <!--====== Custom JS ======-->
     <script src="{{ url('front/js/custom.js') }}"></script>
     <!--====== Filter JS ======-->
     <script src="{{ url('front/js/filters.js') }}"></script>
    <!--====== Noscript ======-->
    <noscript>
        <div class="app-setting">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="app-setting__wrap">
                            <h1 class="app-setting__h1">JavaScript is disabled in your browser.</h1>
                            <span class="app-setting__text">Please enable JavaScript in your browser or upgrade to a
                                JavaScript-capable browser.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </noscript>
</body>

</html>
