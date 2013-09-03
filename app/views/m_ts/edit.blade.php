@extends('layouts.scaffold')

@section('main')

<h1>Edit M_t</h1>
{{ Form::model($m_t, array('method' => 'PATCH', 'route' => array('m_ts.update', $m_t->id))) }}
	<ul>
        <li>
            {{ Form::label('order_id', 'Order_id:') }}
            {{ Form::input('number', 'order_id') }}
        </li>

        <li>
            {{ Form::label('ipn_id', 'Ipn_id:') }}
            {{ Form::text('ipn_id') }}
        </li>

        <li>
            {{ Form::label('orig', 'Orig:') }}
            {{ Form::text('orig') }}
        </li>

        <li>
            {{ Form::label('dest', 'Dest:') }}
            {{ Form::text('dest') }}
        </li>

        <li>
            {{ Form::label('tstamp', 'Tstamp:') }}
            {{ Form::text('tstamp') }}
        </li>

        <li>
            {{ Form::label('text', 'Text:') }}
            {{ Form::text('text') }}
        </li>

        <li>
            {{ Form::label('customer_id', 'Customer_id:') }}
            {{ Form::text('customer_id') }}
        </li>

        <li>
            {{ Form::label('user', 'User:') }}
            {{ Form::text('user') }}
        </li>

        <li>
            {{ Form::label('pass', 'Pass:') }}
            {{ Form::text('pass') }}
        </li>

        <li>
            {{ Form::label('routemethod_id', 'Routemethod_id:') }}
            {{ Form::text('routemethod_id') }}
        </li>

        <li>
            {{ Form::label('routemethod_name', 'Routemethod_name:') }}
            {{ Form::text('routemethod_name') }}
        </li>

        <li>
            {{ Form::label('mpesa_code', 'Mpesa_code:') }}
            {{ Form::text('mpesa_code') }}
        </li>

        <li>
            {{ Form::label('mpesa_acc', 'Mpesa_acc:') }}
            {{ Form::text('mpesa_acc') }}
        </li>

        <li>
            {{ Form::label('mpesa_msisdn', 'Mpesa_msisdn:') }}
            {{ Form::text('mpesa_msisdn') }}
        </li>

        <li>
            {{ Form::label('mpesa_trx_date', 'Mpesa_trx_date:') }}
            {{ Form::text('mpesa_trx_date') }}
        </li>

        <li>
            {{ Form::label('mpesa_trx_time', 'Mpesa_trx_time:') }}
            {{ Form::text('mpesa_trx_time') }}
        </li>

        <li>
            {{ Form::label('mpesa_amt', 'Mpesa_amt:') }}
            {{ Form::text('mpesa_amt') }}
        </li>

        <li>
            {{ Form::label('mpesa_sender', 'Mpesa_sender:') }}
            {{ Form::text('mpesa_sender') }}
        </li>

        <li>
            {{ Form::label('notes', 'Notes:') }}
            {{ Form::textarea('notes') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('m_ts.show', 'Cancel', $m_t->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop