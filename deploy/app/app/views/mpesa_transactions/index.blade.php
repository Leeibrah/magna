@extends('layouts.scaffold')

@section('main')

<h1>All Mpesa_transactions</h1>

<p>{{ link_to_route('mpesa_transactions.create', 'Add new mpesa_transaction') }}</p>

@if ($mpesa_transactions->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Order_id</th>
				<th>Ipn_id</th>
				<th>Ipn_orig</th>
				<th>Ipn_dest</th>
				<th>Ipn_tstamp</th>
				<th>Ipn_text</th>
				<th>Ipn_user</th>
				<th>Ipn_pass</th>
				<th>Mpesa_code</th>
				<th>Mpesa_acc</th>
				<th>Mpesa_msisdn</th>
				<th>Mpesa_trx_date</th>
				<th>Mpesa_trx_time</th>
				<th>Mpesa_amt</th>
				<th>Mpesa_sender</th>
				<th>Notes</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($mpesa_transactions as $mpesa_transaction)
				<tr>
					<td>{{{ $mpesa_transaction->order_id }}}</td>
					<td>{{{ $mpesa_transaction->ipn_id }}}</td>
					<td>{{{ $mpesa_transaction->ipn_orig }}}</td>
					<td>{{{ $mpesa_transaction->ipn_dest }}}</td>
					<td>{{{ $mpesa_transaction->ipn_tstamp }}}</td>
					<td>{{{ $mpesa_transaction->ipn_text }}}</td>
					<td>{{{ $mpesa_transaction->ipn_user }}}</td>
					<td>{{{ $mpesa_transaction->ipn_pass }}}</td>
					<td>{{{ $mpesa_transaction->mpesa_code }}}</td>
					<td>{{{ $mpesa_transaction->mpesa_acc }}}</td>
					<td>{{{ $mpesa_transaction->mpesa_msisdn }}}</td>
					<td>{{{ $mpesa_transaction->mpesa_trx_date }}}</td>
					<td>{{{ $mpesa_transaction->mpesa_trx_time }}}</td>
					<td>{{{ $mpesa_transaction->mpesa_amt }}}</td>
					<td>{{{ $mpesa_transaction->mpesa_sender }}}</td>
					<td>{{{ $mpesa_transaction->notes }}}</td>
                    <td>{{ link_to_route('mpesa_transactions.edit', 'Edit', array($mpesa_transaction->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('mpesa_transactions.destroy', $mpesa_transaction->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no mpesa_transactions
@endif

@stop