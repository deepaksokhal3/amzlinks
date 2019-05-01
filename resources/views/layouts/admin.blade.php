<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Amazon Sellers</title>
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="site-url" content="{{ asset('/') }}">
		<link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
		<link href="{{ asset('vendors/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="{{ asset('js/tags/bootstrap-tagsinput.css') }}">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/daterangepicker.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/gauge.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/toastr.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('vendors/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    </head>
    <body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
		@include('layouts.backend.header')
		    @yield('content')
		@include('layouts.backend.footer')
		  <!-- Bootstrap and necessary plugins -->
		<script src="{{ asset('vendors/js/jquery.min.js') }}"></script>
		<script src="{{ asset('vendors/js/popper.min.js') }}"></script>
		<script src="{{ asset('vendors/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('vendors/js/pace.min.js') }}"></script>
		<script src="{{ asset('js/tags/bootstrap-tagsinput.min.js') }}"></script>
		<!-- CoreUI Pro main scripts -->
		<script src="{{ asset('vendors/js/Chart.min.js')}}"></script>
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('vendors/js/jquery.maskedinput.min.js')}}"></script>
		<!-- Plugins and scripts required by this views -->
		<script src="{{ asset('vendors/js/toastr.min.js') }}"></script>
		<script src="{{ asset('vendors/js/gauge.min.js') }}"></script>
		<script src="{{ asset('vendors/js/select2.min.js')}}"></script>
		<script src="{{ asset('vendors/js/moment.min.js') }}"></script>
		<script src="{{ asset('vendors/js/daterangepicker.min.js') }}"></script>
		<script src="{{ asset('js/custom.js') }}"></script>
		<script src="{{ asset('js/views/highcharts.js')}}"></script>
		<script src="{{ asset('js/views/series-label.js')}}"></script>
		<script src="{{ asset('js/views/exporting.js')}}"></script>
		<script src="{{ asset('js/views/export-data.js')}}"></script>
		<script src="{{ asset('js/views/main.js') }}"></script>
		<script src="{{ asset('backend/custom.js') }}"></script>

		<script src="{{ asset('js/text-editer.js') }}"></script>
		@yield('scripts')

	</body>
</html>
