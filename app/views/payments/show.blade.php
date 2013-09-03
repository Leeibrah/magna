@extends('layouts.scaffold')

@section('main')

<h1>Show Payment</h1>

<p>{{ link_to_route('payments.index', 'Return to all payments') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Order_id</th>
				<th>Order_cost</th>
				<th>Payment_type</th>
				<th>Payment_amount</th>
				<th>Balance</th>
				<th>Notes</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $payment->order_id }}}</td>
					<td>{{{ $payment->order_cost }}}</td>
					<td>{{{ $payment->payment_type }}}</td>
					<td>{{{ $payment->payment_amount }}}</td>
					<td>{{{ $payment->balance }}}</td>
					<td>{{{ $payment->notes }}}</td>
                    <td>{{ link_to_route('payments.edit', 'Edit', array($payment->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('payments.destroy', $payment->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop