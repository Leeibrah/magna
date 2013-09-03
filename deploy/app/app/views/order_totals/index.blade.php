@extends('layouts.scaffold')

@section('main')

<h1>All Order_totals</h1>

<p>{{ link_to_route('order_totals.create', 'Add new order_total') }}</p>

@if ($order_totals->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Order_id</th>
				<th>Sub_total</th>
				<th>Custom_import</th>
				<th>Shipping</th>
				<th>Vat</th>
				<th>Total</th>
				<th>Notes</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($order_totals as $order_total)
				<tr>
					<td>{{{ $order_total->order_id }}}</td>
					<td>{{{ $order_total->sub_total }}}</td>
					<td>{{{ $order_total->custom_import }}}</td>
					<td>{{{ $order_total->shipping }}}</td>
					<td>{{{ $order_total->vat }}}</td>
					<td>{{{ $order_total->total }}}</td>
					<td>{{{ $order_total->notes }}}</td>
                    <td>{{ link_to_route('order_totals.edit', 'Edit', array($order_total->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('order_totals.destroy', $order_total->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no order_totals
@endif

@stop