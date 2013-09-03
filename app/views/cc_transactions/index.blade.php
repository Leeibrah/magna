@extends('layouts.scaffold')

@section('main')

<h1>All Cc_transactions</h1>

<p>{{ link_to_route('cc_transactions.create', 'Add new cc_transaction') }}</p>

@if ($cc_transactions->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Order_id</th>
				<th>Provider</th>
				<th>Number</th>
				<th>Ccv</th>
				<th>Name</th>
				<th>Expiry_date</th>
				<th>Amount</th>
				<th>Notes</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($cc_transactions as $cc_transaction)
				<tr>
					<td>{{{ $cc_transaction->order_id }}}</td>
					<td>{{{ $cc_transaction->provider }}}</td>
					<td>{{{ $cc_transaction->number }}}</td>
					<td>{{{ $cc_transaction->ccv }}}</td>
					<td>{{{ $cc_transaction->name }}}</td>
					<td>{{{ $cc_transaction->expiry_date }}}</td>
					<td>{{{ $cc_transaction->amount }}}</td>
					<td>{{{ $cc_transaction->notes }}}</td>
                    <td>{{ link_to_route('cc_transactions.edit', 'Edit', array($cc_transaction->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('cc_transactions.destroy', $cc_transaction->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no cc_transactions
@endif

@stop