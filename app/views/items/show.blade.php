@extends('layouts.scaffold')

@section('main')

<h1>Show Item</h1>

<p>{{ link_to_route('items.index', 'Return to all items') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Session_id</th>
				<th>Ip_address</th>
				<th>User_id</th>
				<th>Order_id</th>
				<th>Md5</th>
				<th>Merchant_id</th>
				<th>Item_id</th>
				<th>Name</th>
				<th>Quantity</th>
				<th>Link</th>
				<th>Image</th>
				<th>Designer</th>
				<th>Color</th>
				<th>Size</th>
				<th>Package</th>
				<th>Print_on_demand</th>
				<th>Front_logo</th>
				<th>Custom_back_number</th>
				<th>Custom_back_name</th>
				<th>Part_number</th>
				<th>Price_usd</th>
				<th>Price_ksh</th>
				<th>Status</th>
				<th>Notes</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $item->session_id }}}</td>
					<td>{{{ $item->ip_address }}}</td>
					<td>{{{ $item->user_id }}}</td>
					<td>{{{ $item->order_id }}}</td>
					<td>{{{ $item->md5 }}}</td>
					<td>{{{ $item->merchant_id }}}</td>
					<td>{{{ $item->item_id }}}</td>
					<td>{{{ $item->name }}}</td>
					<td>{{{ $item->quantity }}}</td>
					<td>{{{ $item->link }}}</td>
					<td>{{{ $item->image }}}</td>
					<td>{{{ $item->designer }}}</td>
					<td>{{{ $item->color }}}</td>
					<td>{{{ $item->size }}}</td>
					<td>{{{ $item->package }}}</td>
					<td>{{{ $item->print_on_demand }}}</td>
					<td>{{{ $item->front_logo }}}</td>
					<td>{{{ $item->custom_back_number }}}</td>
					<td>{{{ $item->custom_back_name }}}</td>
					<td>{{{ $item->part_number }}}</td>
					<td>{{{ $item->price_usd }}}</td>
					<td>{{{ $item->price_ksh }}}</td>
					<td>{{{ $item->status }}}</td>
					<td>{{{ $item->notes }}}</td>
                    <td>{{ link_to_route('items.edit', 'Edit', array($item->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('items.destroy', $item->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop