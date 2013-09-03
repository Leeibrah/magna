@extends('layouts.scaffold')

@section('main')

<h1>Edit Order #{{ $id }}</h1>
<?php
$order =  DB::table('orders')->where('id', $id)->first();
// var_dump($order->id);
$orderobject = (array) $order;
// var_dump($order['id']);

?>
<!-- {{ Form::model($order, array('method' => 'POST')) }} -->
{{ Form::model($orderobject, array('method' => 'PATCH', 'route' => array('orders.update', $order->id))) }}
	<ul>
        <li>
            {{ Form::label('neighbourhood', 'Neighbourhood:') }}
            {{ Form::select('neighbourhood', Functions::locations()) }}
        </li>

        <li>
            {{ Form::label('notes', 'Special Notes:') }}
            {{ Form::textarea('notes') }}
        </li>
        <BR/>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			<td><a href="{{ Functions::host() }}/orders/{{ $id }}" class="btn">Cancel</a></td>
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop