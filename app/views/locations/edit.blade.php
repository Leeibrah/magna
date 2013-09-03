@extends('layouts.scaffold')

@section('main')

<h1>Edit Location</h1>
{{ Form::model($location, array('method' => 'PATCH', 'route' => array('locations.update', $location->id))) }}
	<ul>
        <li>
            {{ Form::label('country', 'Country:') }}
            {{ Form::text('country') }}
        </li>

        <li>
            {{ Form::label('city', 'City:') }}
            {{ Form::text('city') }}
        </li>

        <li>
            {{ Form::label('neighbourhood', 'Neighbourhood:') }}
            {{ Form::text('neighbourhood') }}
        </li>

        <li>
            {{ Form::label('agents', 'Agents:') }}
            {{ Form::textarea('agents') }}
        </li>

        <li>
            {{ Form::label('notes', 'Notes:') }}
            {{ Form::textarea('notes') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('locations.show', 'Cancel', $location->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop