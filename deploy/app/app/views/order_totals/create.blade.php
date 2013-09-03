@extends('layouts.scaffold')

@section('main')

<h1>Create Order_total</h1>

{{ Form::open(array('route' => 'order_totals.store')) }}
	<ul>
        <li>
            {{ Form::label('order_id', 'Order_id:') }}
            {{ Form::input('number', 'order_id') }}
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


