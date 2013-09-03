@extends('layouts.scaffold')

@section('main')

<h1>Edit Order</h1>
{{ Form::model($order, array('method' => 'PATCH', 'route' => array('orders.update', $order->id))) }}
	<ul>
        <li>
            {{ Form::label('session_id', 'Session_id:') }}
            {{ Form::text('session_id') }}
        </li>

        <li>
            {{ Form::label('user_id', 'User_id:') }}
            {{ Form::text('user_id') }}
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
            {{ Form::label('amount', 'Amount:') }}
            {{ Form::input('number', 'amount') }}
        </li>

        <li>
            {{ Form::label('order_status', 'Order_status:') }}
            {{ Form::text('order_status') }}
        </li>

        <li>
            {{ Form::label('notes', 'Notes:') }}
            {{ Form::textarea('notes') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('orders.show', 'Cancel', $order->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop