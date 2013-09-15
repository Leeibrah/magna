@extends('layouts.scaffold')

@section('main')

<h2>Your Profile</h2>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Full Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>First Location</th>
				<!-- <th>Delete</th> -->
			</tr>

		</thead>

		<tbody>
				<tr>
					<td>{{{ Auth::user()->name }}} </a></td>
					<td>{{{ Auth::user()->email }}}</td>
					<td>{{{ Auth::user()->phone }}}</td>
					<td>{{{ Auth::user()->neighbourhood }}}, {{{ Auth::user()->city }}}</td>
				
				</tr>
				<!-- <tr>
					<th colspan="4">About 
						<a href="{{ Functions::root() }}/users/{{ Auth::user()->id }}/edit" 
							class="btn btn-info" style="float:right">Edit</a>
					</th>
				</tr>
				<tr>
					<td colspan="5">{{{ Auth::user()->notes }}}</td>
				</tr> -->
		</tbody>
	</table>

<h2>Your Orders</h2>

<?php
$orders =  DB::table('orders')->where('user_id', Auth::user()->id)->get();
$exchange_rate= Functions::exchRate(); //? $RATE_ADJUST
?>
@if (isset($orders['0']))
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Order ID</th>
				<th>Status</th>
				<th>Price(KSh)</th>
				<th>City</th>
				<th>Neighbourhood</th>
				<th>Notes</th>
				<th>Edit</th>
				<!-- <th>Delete</th> -->
			</tr>
		</thead>

		<tbody>
			@foreach ($orders as $order)
				<tr>
					<td><a href="{{ Functions::host() }}/orders/{{ $order->id }}">{{ $order->id }} </a></td>
					<td>{{{ $order->order_status }}}</td>
					<td>{{{ number_format((float)$order->amount*$exchange_rate) }}}</td>
					<td>{{{ $order->city }}}</td>
					<td>{{{ $order->neighbourhood }}}</td>
					<td style="max-width: 300px; overflow-x: scroll;">{{{ $order->notes }}}</td>
					
                   <td><a href="{{ Functions::host() }}/orders/{{ $order->id }}/edit" class="btn btn-info">Edit</a></td>
                   <!--  <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('orders.destroy', $order->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td> -->
				</tr>
			@endforeach
		</tbody>
	</table>

	<h2 style='margin-bottom: 0'>To pay with M-Pesa:</h2>
	<br/>
	<ol style='margin-top: 0'>
	    <li>Go to M-Pesa on your phone
	    <li>Choose "Pay Bill" from the M-PESA menu
	    <li>Enter the VituMob Business Number: <strong>997200</strong>
	    <li>Enter the OrderID as the account number.</strong>
	   	<li>Enter the Order Price as amount.</strong>
	    <li>Enter your secret <strong>PIN</strong> and press <strong>OK</strong>
	</ol>
@else
	You have no orders
@endif


@stop