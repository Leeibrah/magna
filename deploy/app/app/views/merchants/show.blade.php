@extends('layouts.scaffold')

@section('main')

<h1>Show Merchant</h1>

<p>{{ link_to_route('merchants.index', 'Return to all merchants') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
				<th>Url</th>
				<th>About</th>
				<th>Logo</th>
				<th>Orders_count</th>
				<th>Orders_worth</th>
				<th>Notes</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $merchant->name }}}</td>
					<td>{{{ $merchant->url }}}</td>
					<td>{{{ $merchant->about }}}</td>
					<td>{{{ $merchant->logo }}}</td>
					<td>{{{ $merchant->orders_count }}}</td>
					<td>{{{ $merchant->orders_worth }}}</td>
					<td>{{{ $merchant->notes }}}</td>
                    <td>{{ link_to_route('merchants.edit', 'Edit', array($merchant->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('merchants.destroy', $merchant->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop