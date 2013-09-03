<!doctype html>
<html>
	<head>
		<title>
		    @section('title')
	        	VituMob:: kila kitu kila siku
	        @show
    	</title>
		<meta charset='utf-8'>
		<link rel='stylesheet' href="{{ asset('css/vitumob.css') }}">
		    @yield('css')

		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
		<style>
			table form { margin-bottom: 0; }
			form ul { margin-left: 0; list-style: none; }
			.error { color: red; font-style: italic; }
			body { padding-top: 20px; }
		</style>

	</head>

	<body>


		<div class="container">

			<div id=social>
			    <span><a href="https://www.facebook.com/vitumob" title="Facebook" target="_blank"><img width=24 height=24 src="{{ asset('images/facebook.jpg') }}"></a></span>
			    <span><a href="https://www.twitter.com/vitumob" title="Twitter" target="_blank"><img width=24 height=24 src="{{ asset('images/twitter.png') }}"></a></span>
			</div>


			<div id="header"><a href="{{ Functions::root() }}"><img id="logo" src="{{ asset('images/logo.png') }}" width="400"></a></div>


			@if (Session::has('message'))
				<div class="flash alert">
					<p>{{ Session::get('message') }}</p>
				</div>
			@endif

			<div id='main' style="text-align:center;">

			    <br/>
			    <br/>
			    <h1 style='color: #f27a29'>Coming: September 2013</h1>

			    <p style='font-size: larger; color: #027fc2'>To be notified when we launch, enter your email address:</p>

			    <!-- <form action='{{ Functions::host()}}/tonotify' method='get'> -->
			    <form action='{{ Functions::root() }}/users' method='post'>
			        <input name='email' type='email' required placeholder='your email address' style='margin-left: 24pt; width: 192pt'>
			        <input type='submit' class="small blue" value='Request Notification'>
			    </form>

			</div>

			<div id='footer'>
			    <span>&copy;2013 VituMob</span>
			</div>


		</div>

	</body>
	  @include('partials.javascript')
      @yield('js') <!-- page-specific javascript-->

</html>