@extends('layouts.scaffold')

@section('main')

<h1>Edit Mpesa_transaction</h1>
{{ Form::model($mpesa_transaction, array('method' => 'PATCH', 'route' => array('mpesa_transactions.update', $mpesa_transaction->id))) }}
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
            {{ Form::label('ipn_orig', 'Ipn_orig:') }}
            {{ Form::text('ipn_orig') }}
        </li>

        <li>
            {{ Form::label('ipn_dest', 'Ipn_dest:') }}
            {{ Form::text('ipn_dest') }}
        </li>

        <li>
            {{ Form::label('ipn_tstamp', 'Ipn_tstamp:') }}
            {{ Form::text('ipn_tstamp') }}
        </li>

        <li>
            {{ Form::label('ipn_text', 'Ipn_text:') }}
            {{ Form::text('ipn_text') }}
        </li>

        <li>
            {{ Form::label('ipn_user', 'Ipn_user:') }}
            {{ Form::text('ipn_user') }}
        </li>

        <li>
            {{ Form::label('ipn_pass', 'Ipn_pass:') }}
            {{ Form::text('ipn_pass') }}
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
			{{ link_to_route('mpesa_transactions.show', 'Cancel', $mpesa_transaction->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop