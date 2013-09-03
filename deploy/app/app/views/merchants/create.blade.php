@extends('layouts.scaffold')

@section('main')

<h1>Create Merchant</h1>

{{ Form::open(array('route' => 'merchants.store')) }}
	<ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('url', 'Url:') }}
            {{ Form::text('url') }}
        </li>

        <li>
            {{ Form::label('about', 'About:') }}
            {{ Form::text('about') }}
        </li>

        <li>
            {{ Form::label('logo', 'Logo:') }}
            {{ Form::text('logo') }}
        </li>

        <li>
            {{ Form::label('orders_count', 'Orders_count:') }}
            {{ Form::input('number', 'orders_count') }}
        </li>

        <li>
            {{ Form::label('orders_worth', 'Orders_worth:') }}
            {{ Form::text('orders_worth') }}
        </li>

        <li>
            {{ Form::label('notes', 'Notes:') }}
            {{ Form::textarea('notes') }}
        </li>

		<li>
			{{ Form::submit('Submit', array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


