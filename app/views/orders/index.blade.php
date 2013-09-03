@extends('layouts.scaffold')

@section('main')

<h1>Your Profile</h1>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Full Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>First City</th>
				<th>Neighbourhood</th>
				<!-- <th>Delete</th> -->
			</tr>

		</thead>

		<tbody>
				<tr>
					<td>{{{ Auth::user()->name }}} </a></td>
					<td>{{{ Auth::user()->email }}}</td>
					<td>{{{ Auth::user()->phone }}}</td>
					<td>{{{ Auth::user()->city }}}</td>
					<td>{{{ Auth::user()->neighbourhood }}}</td>
				
				</tr>
				<tr>
					<th colspan="4">About</th>
					<!-- <td><a href="{{ Functions::root() }}/users/{{ Auth::user()->id }}/edit" class="btn btn-info">Edit</a></td> -->
				</tr>
				<tr>
					<td colspan="5">{{{ Auth::user()->notes }}}</td>
				</tr>
		</tbody>
	</table>

<h1>All Your Orders</h1>

<?php
$orders =  DB::table('orders')->where('user_id', Auth::user()->id)->where('order_status', 'shipping')->get();
?>
@if (isset($orders['0']))
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#Order ID</th>
				<th>Status</th>
				<th>City</th>
				<th>Neighbourhood</th>
				<th>Notes</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($orders as $order)
				<tr>
					<td><a href="{{ Functions::host() }}/orders/{{ $order->id }}">#{{ $order->id }} </a></td>
					<td>{{{ $order->order_status }}}</td>
					<td>{{{ $order->city }}}</td>
					<td>{{{ $order->neighbourhood }}}</td>
					<td>{{{ $order->notes }}}</td>
					
                   <td><a href="{{ Functions::host() }}/orders/{{ $order->id }}/edit" class="btn btn-info">Edit</a></td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('orders.destroy', $order->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	You have no orders
@endif


@stop