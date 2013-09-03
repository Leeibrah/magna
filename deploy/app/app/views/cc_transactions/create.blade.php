@extends('layouts.scaffold')

@section('main')

<h1>Create Cc_transaction</h1>

{{ Form::open(array('route' => 'cc_transactions.store')) }}
	<ul>
        <li>
            {{ Form::label('order_id', 'Order_id:') }}
            {{ Form::input('number', 'order_id') }}
        </li>

        <li>
            {{ Form::label('provider', 'Provider:') }}
            {{ Form::text('provider') }}
        </li>

        <li>
            {{ Form::label('number', 'Number:') }}
            {{ Form::input('number', 'number') }}
        </li>

        <li>
            {{ Form::label('ccv', 'Ccv:') }}
            {{ Form::input('number', 'ccv') }}
        </li>

        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('expiry_date', 'Expiry_date:') }}
            {{ Form::text('expiry_date') }}
        </li>

        <li>
            {{ Form::label('amount', 'Amount:') }}
            {{ Form::text('amount') }}
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


