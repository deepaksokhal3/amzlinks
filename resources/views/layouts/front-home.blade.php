<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Link Rotation & Tracking Tool for Amazon Sellers">
        <meta name="keywords" content="Tracking,Rotation,Sellers">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Amazon Sellers</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="site-url" content="{{ asset('/') }}">
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
        <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css">
      	<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/landing.css') }}" rel="stylesheet" type="text/css">
        <script src="{{ asset('vendors/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/wow.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/animation.js') }}"></script>
     	<link href="{{ asset('vendors/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <script src="{{ asset('vendors/js/jquery.min.js') }}"></script>
        <script>
            jQuery(document).ready(function(){
                jQuery('.nav-link').on('click',function(){
                    jQuery(this).css('border-bottom','4px solid #FFF');
                });
                jQuery('.navbar-nav .nav-link').each(function(e){
                    if(jQuery(this).attr('href') == window.location.href)
                    jQuery(this).css('border-bottom','4px solid #FFF');
                });
            });
        </script>
        <!-- Facebook Pixel Code -->
        <script>
         !function(f,b,e,v,n,t,s)
         {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
         n.callMethod.apply(n,arguments):n.queue.push(arguments)};
         if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
         n.queue=[];t=b.createElement(e);t.async=!0;
         t.src=v;s=b.getElementsByTagName(e)[0];
         s.parentNode.insertBefore(t,s)}(window, document,'script',
         'https://connect.facebook.net/en_US/fbevents.js');
         fbq('init', '279306179078431');
         fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
         src="https://www.facebook.com/tr?id=279306179078431&ev=PageView&noscript=1
        https://www.facebook.com/tr?id=279306179078431&ev=PageView&noscript=1
        "
        /></noscript>
        <!-- End Facebook Pixel Code -->
    </head>
 	<body class="app header-fixed aside-menu-hidden sidebar-lg-show">
		@include('layouts.front.single-header')
		    @yield('content')
	    @include('layouts.front.single-footer')
    </body>
</html>

