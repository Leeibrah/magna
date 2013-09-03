@extends('layouts.scaffold')

@section('main')

<h1>Show M_t</h1>

<p>{{ link_to_route('m_ts.index', 'Return to all m_ts') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Order_id</th>
				<th>Ipn_id</th>
				<th>Orig</th>
				<th>Dest</th>
				<th>Tstamp</th>
				<th>Text</th>
				<th>Customer_id</th>
				<th>User</th>
				<th>Pass</th>
				<th>Routemethod_id</th>
				<th>Routemethod_name</th>
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
		<tr>
			<td>{{{ $m_t->order_id }}}</td>
					<td>{{{ $m_t->ipn_id }}}</td>
					<td>{{{ $m_t->orig }}}</td>
					<td>{{{ $m_t->dest }}}</td>
					<td>{{{ $m_t->tstamp }}}</td>
					<td>{{{ $m_t->text }}}</td>
					<td>{{{ $m_t->customer_id }}}</td>
					<td>{{{ $m_t->user }}}</td>
					<td>{{{ $m_t->pass }}}</td>
					<td>{{{ $m_t->routemethod_id }}}</td>
					<td>{{{ $m_t->routemethod_name }}}</td>
					<td>{{{ $m_t->mpesa_code }}}</td>
					<td>{{{ $m_t->mpesa_acc }}}</td>
					<td>{{{ $m_t->mpesa_msisdn }}}</td>
					<td>{{{ $m_t->mpesa_trx_date }}}</td>
					<td>{{{ $m_t->mpesa_trx_time }}}</td>
					<td>{{{ $m_t->mpesa_amt }}}</td>
					<td>{{{ $m_t->mpesa_sender }}}</td>
					<td>{{{ $m_t->notes }}}</td>
                    <td>{{ link_to_route('m_ts.edit', 'Edit', array($m_t->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('m_ts.destroy', $m_t->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop