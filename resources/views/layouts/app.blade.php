<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
       	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Link Rotation & Tracking Tool for Amazon Sellers">
		<meta name="keywords" content="Tracking,Rotation,Sellers">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Amazon Sellers</title>
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="site-url" content="{{ asset('/') }}">
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
      	<link href="{{ asset('vendors/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
      	<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.3.0/css/flag-icon.css" rel="stylesheet" type="text/css">
      	<link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="{{ asset('js/tags/bootstrap-tagsinput.css') }}">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/daterangepicker.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/gauge.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/toastr.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
 		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('vendors/js/jquery.min.js') }}"></script>
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
        <script>
		    var APP_URL = "{{ URL::to('/') }}";
		</script>
    </head>
	<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden ">
		@include('layouts.front.header')
		    @yield('content')
		@include('layouts.front.footer')
		<script src="{{ asset('js/app.js') }}"></script>
		@yield('scripts')
		<script src="{{ asset('vendors/js/popper.min.js') }}"></script>
		<script src="{{ asset('vendors/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('vendors/js/pace.min.js') }}"></script>
		<!-- CoreUI Pro main scripts -->
		<!-- <script src="{{ asset('vendors/js/Chart.min.js')}}"></script> -->


		<script src="{{ asset('js/tags/bootstrap-tagsinput.min.js') }}"></script>
		<script src="{{ asset('vendors/js/jquery.maskedinput.min.js')}}"></script>
		<!-- Plugins and scripts required by this views -->
		<script src="{{ asset('vendors/js/toastr.min.js') }}"></script>
		<script src="{{ asset('vendors/js/gauge.min.js') }}"></script>
		<script src="{{ asset('vendors/js/select2.min.js')}}"></script>
		<script src="{{ asset('vendors/js/moment.min.js') }}"></script>
		<script src="{{ asset('vendors/js/daterangepicker.min.js') }}"></script>
		<script src="{{ asset('js/views/advanced-forms.js')}}"></script>
		<script type="text/javascript" src="{{ asset('js/wow.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/animation.js') }}"></script>
		<!-- Custom scripts required by this view -->
		<script src="{{ asset('js/views/main.js') }}"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="{{ asset('js/tags/bootstrap-select.min.js')}}"></script>
		<script src="{{ asset('js/custom.js') }}"></script>
		<script src="{{ asset('js/views/highcharts.js')}}"></script>
		<script src="{{ asset('js/views/series-label.js')}}"></script>
		<script src="{{ asset('js/views/exporting.js')}}"></script>
		<script src="{{ asset('js/views/export-data.js')}}"></script>
		<script src="{{ asset('js/views/charts.js')}}"></script>

	</body>
</html>
