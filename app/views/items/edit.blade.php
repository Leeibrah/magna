@extends('layouts.scaffold')

@section('main')

<h1>Edit Item</h1>
{{ Form::model($item, array('method' => 'PATCH', 'route' => array('items.update', $item->id))) }}
	<ul>
        <li>
            {{ Form::label('session_id', 'Session_id:') }}
            {{ Form::text('session_id') }}
        </li>

        <li>
            {{ Form::label('ip_address', 'Ip_address:') }}
            {{ Form::text('ip_address') }}
        </li>

        <li>
            {{ Form::label('user_id', 'User_id:') }}
            {{ Form::text('user_id') }}
        </li>

        <li>
            {{ Form::label('order_id', 'Order_id:') }}
            {{ Form::text('order_id') }}
        </li>

        <li>
            {{ Form::label('md5', 'Md5:') }}
            {{ Form::text('md5') }}
        </li>

        <li>
            {{ Form::label('merchant_id', 'Merchant_id:') }}
            {{ Form::input('number', 'merchant_id') }}
        </li>

        <li>
            {{ Form::label('item_id', 'Item_id:') }}
            {{ Form::text('item_id') }}
        </li>

        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::label('quantity', 'Quantity:') }}
            {{ Form::input('number', 'quantity') }}
        </li>

        <li>
            {{ Form::label('link', 'Link:') }}
            {{ Form::text('link') }}
        </li>

        <li>
            {{ Form::label('image', 'Image:') }}
            {{ Form::text('image') }}
        </li>

        <li>
            {{ Form::label('designer', 'Designer:') }}
            {{ Form::text('designer') }}
        </li>

        <li>
            {{ Form::label('color', 'Color:') }}
            {{ Form::text('color') }}
        </li>

        <li>
            {{ Form::label('size', 'Size:') }}
            {{ Form::input('number', 'size') }}
        </li>

        <li>
            {{ Form::label('package', 'Package:') }}
            {{ Form::text('package') }}
        </li>

        <li>
            {{ Form::label('print_on_demand', 'Print_on_demand:') }}
            {{ Form::text('print_on_demand') }}
        </li>

        <li>
            {{ Form::label('front_logo', 'Front_logo:') }}
            {{ Form::text('front_logo') }}
        </li>

        <li>
            {{ Form::label('custom_back_number', 'Custom_back_number:') }}
            {{ Form::text('custom_back_number') }}
        </li>

        <li>
            {{ Form::label('custom_back_name', 'Custom_back_name:') }}
            {{ Form::text('custom_back_name') }}
        </li>

        <li>
            {{ Form::label('part_number', 'Part_number:') }}
            {{ Form::text('part_number') }}
        </li>

        <li>
            {{ Form::label('price_usd', 'Price_usd:') }}
            {{ Form::text('price_usd') }}
        </li>

        <li>
            {{ Form::label('price_ksh', 'Price_ksh:') }}
            {{ Form::text('price_ksh') }}
        </li>

        <li>
            {{ Form::label('status', 'Status:') }}
            {{ Form::text('status') }}
        </li>

        <li>
            {{ Form::label('notes', 'Notes:') }}
            {{ Form::textarea('notes') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('items.show', 'Cancel', $item->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop