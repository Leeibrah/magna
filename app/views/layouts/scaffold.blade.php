<!doctype html>
<html>
	<head>
		<title>
		    @section('title')
	        	VituMob
	        @show
    	</title>
		<meta charset='utf-8'>

		<!-- ICO -->
		<link rel="shortcut icon" href="{{ asset('images/icon18.png') }}">

		<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
		<style>
			table form { margin-bottom: 0; }
			form ul { margin-left: 0; list-style: none; }
			.error { color: red; font-style: italic; }
			body { padding-top: 20px; }
		</style>

		   	@yield('css')
			<link rel='stylesheet' href="{{ asset('css/vitumob.css') }}">
	</head>

	<body>

		<!--[if IE]>
		Please download <a href="http://www.google.com/chrome/‎">Chrome</a>, <a href="http://www.mozilla.org/firefox/">Firefox</a> or <a href="http://www.apple.com/safari/‎">Safari</a> browser to access this site.
		<![endif]--> 

		<![if !IE]>
		<div class="container">

			<div id=social>
			    <span><a href="https://www.facebook.com/vitumob" title="Facebook" target="_blank"><img width=24 height=24 src="{{ asset('images/facebook.jpg') }}"></a></span>
			    <span><a href="https://www.twitter.com/vitumob" title="Twitter" target="_blank"><img width=24 height=24 src="{{ asset('images/twitter.png') }}"></a></span>
			</div>

			<div id="nav-bar">			


			@if(Auth::user())
				<a href="{{ Functions::host() }}/orders">{{ Auth::user()->name }}</a>
				<span><a href="{{ Functions::host() }}/cart">cart</a></span>
				<span><a href="{{ Functions::root() }}/logout">log out</a></span>
				<p float="right">
					<a href="{{ Functions::host() }}/check">order status</a>
					<span><a href="{{ Functions::host() }}/contacts">contact us</a></span>
				</p>
			@else
				<a href="{{ Functions::host() }}/cart">cart</a>
				<span><a href="{{ Functions::host() }}/check">orders</a></span>
				<span><a href="{{ Functions::host() }}/contacts">contacts</a></span>
				<span><a href="{{ Functions::root() }}/login">log In</a></span>
				<span><a href="{{ Functions::root() }}/register">register</a></span>
			@endif
			
			
			</div>

			<div id="header"><a href="{{ Functions::host() }}"><img id="logo" src="{{ asset('images/logo.png') }}" width="400"></a></div>

			@if (Session::has('message'))
				<div class="flash alert">
					<p>{{ Session::get('message') }}</p>
				</div>
			@endif

			<!-- Notifications -->
            @include('partials.notifications')
            <!-- ./ notifications -->


			@yield('main')


		</div>
		<![endif]>
	</body>
	<script src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
	<script src="{{ asset('js/jquery-ui.custom.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	  @include('partials.javascript')
      @yield('js') <!-- page-specific javascript-->

</html>