@extends('layouts.scaffold')

{{-- Web site Title --}}
@section('title')
@parent
:: Account Signup
@stop

{{-- Content --}}
@section('main')
<div class="page-header">
	<h1>Signup</h1>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	<input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />

	<!-- Name -->
	<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
		<label class="control-label" for="name">Full Name</label>
		<div class="controls">
			<input type="text" name="name" id="name" value="{{ Request::old('name') }}" />
			{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ name -->

	<!-- Email -->
	<div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
		<label class="control-label" for="email">Email</label>
		<div class="controls">
			<input type="text" name="email" id="email" value="{{ Request::old('email') }}" />
			{{ $errors->first('email', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ email -->

	<!-- Mobile Number -->
	<div class="control-group {{ $errors->has('phone') ? 'error' : '' }}">
		<label class="control-label" for="phone">Mobile Number</label>
		<div class="controls">
			<input type="text" name="phone" id="phone" value="{{ Request::old('phone') }}" />
			{{ $errors->first('phone', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ phone -->

	<!-- Password -->
	<div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
		<label class="control-label" for="password">Password</label>
		<div class="controls">
			<input type="password" name="password" id="password" value="" />
			{{ $errors->first('password', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ password -->

	<!-- Password Confirm -->
	<div class="control-group {{ $errors->has('password_confirmation') ? 'error' : '' }}">
		<label class="control-label" for="password_confirmation">Password Confirm</label>
		<div class="controls">
			<input type="password" name="password_confirmation" id="password_confirmation" value="" />
			{{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ password confirm -->

	<!-- Signup button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">Signup</button>
		</div>
	</div>
	<!-- ./ signup button -->
</form>
@stop
