@extends('layouts.scaffold')

@section('main')

<h1>Edit Cc_transaction</h1>
{{ Form::model($cc_transaction, array('method' => 'PATCH', 'route' => array('cc_transactions.update', $cc_transaction->id))) }}
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
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('cc_transactions.show', 'Cancel', $cc_transaction->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop