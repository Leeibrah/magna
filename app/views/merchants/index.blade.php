@extends('layouts.scaffold')

@section('main')

<h1>All Merchants</h1>

<p>{{ link_to_route('merchants.create', 'Add new merchant') }}</p>

@if ($merchants->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Url</th>
				<th>About</th>
				<th>Logo</th>
				<th>Agents</th>
				<th>Notes</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($merchants as $merchant)
				<tr>
					<td>{{{ $merchant->name }}}</td>
					<td>{{{ $merchant->url }}}</td>
					<td>{{{ $merchant->about }}}</td>
					<td>{{{ $merchant->logo }}}</td>
					<td>{{{ $merchant->agents }}}</td>
					<td>{{{ $merchant->notes }}}</td>
                    <td>{{ link_to_route('merchants.edit', 'Edit', array($merchant->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('merchants.destroy', $merchant->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no merchants
@endif

@stop