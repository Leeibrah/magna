@extends('layouts.scaffold')

@section('main')

<h1>Create Order</h1>

{{ Form::open(array('route' => 'orders.store')) }}
	<ul>
        <li>
            {{ Form::label('city', 'City:') }}
            {{ Form::text('city') }}
        </li>

        <li>
            {{ Form::label('neighbourhood', 'Neighbourhood:') }}
            {{ Form::text('neighbourhood') }}
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


