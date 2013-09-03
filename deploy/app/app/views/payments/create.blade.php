@extends('layouts.scaffold')

@section('main')

<h1>Create Payment</h1>

{{ Form::open(array('route' => 'payments.store')) }}
	<ul>
        <li>
            {{ Form::label('order_id', 'Order_id:') }}
            {{ Form::input('number', 'order_id') }}
        </li>

        <li>
            {{ Form::label('order_cost', 'Order_cost:') }}
            {{ Form::text('order_cost') }}
        </li>

        <li>
            {{ Form::label('payment_type', 'Payment_type:') }}
            {{ Form::text('payment_type') }}
        </li>

        <li>
            {{ Form::label('payment_amount', 'Payment_amount:') }}
            {{ Form::text('payment_amount') }}
        </li>

        <li>
            {{ Form::label('balance', 'Balance:') }}
            {{ Form::text('balance') }}
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


