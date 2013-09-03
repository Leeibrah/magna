@extends('layouts.scaffold')

@section('main')

<h1>All Users</h1>

<p>{{ link_to_route('users.create', 'Add new user') }}</p>

@if ($users->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>Password</th>
				<th>Phone</th>
				<th>City</th>
				<th>Neighbourhood</th>
				<th>Order_count</th>
				<th>Spent_ksh</th>
				<th>Spent_dollars</th>
				<th>Notes</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{{ $user->name }}}</td>
					<td>{{{ $user->email }}}</td>
					<td>{{{ $user->password }}}</td>
					<td>{{{ $user->phone }}}</td>
					<td>{{{ $user->city }}}</td>
					<td>{{{ $user->neighbourhood }}}</td>
					<td>{{{ $user->order_count }}}</td>
					<td>{{{ $user->spent_ksh }}}</td>
					<td>{{{ $user->spent_dollars }}}</td>
					<td>{{{ $user->notes }}}</td>
                    <td>{{ link_to_route('users.edit', 'Edit', array($user->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('users.destroy', $user->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no users
@endif

@stop