@extends('layouts.scaffold')

@section('main')

<h1>Edit Order_total</h1>
{{ Form::model($order_total, array('method' => 'PATCH', 'route' => array('order_totals.update', $order_total->id))) }}
	<ul>
        <li>
            {{ Form::label('order_id', 'Order_id:') }}
            {{ Form::text('order_id') }}
        </li>

        <li>
            {{ Form::label('sub_total', 'Sub_total:') }}
            {{ Form::text('sub_total') }}
        </li>

        <li>
            {{ Form::label('custom_import', 'Custom_import:') }}
            {{ Form::text('custom_import') }}
        </li>

        <li>
            {{ Form::label('shipping', 'Shipping:') }}
            {{ Form::text('shipping') }}
        </li>

        <li>
            {{ Form::label('vat', 'Vat:') }}
            {{ Form::text('vat') }}
        </li>

        <li>
            {{ Form::label('total', 'Total:') }}
            {{ Form::text('total') }}
        </li>

        <li>
            {{ Form::label('notes', 'Notes:') }}
            {{ Form::textarea('notes') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('order_totals.show', 'Cancel', $order_total->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop