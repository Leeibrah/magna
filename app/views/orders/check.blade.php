@extends('layouts.scaffold')

{{-- Web site Title --}}
@section('title')
@parent
:: Check Status
@stop


@section('css')
	<!-- <link rel="stylesheet" href="{{ asset('css/template.css')}} "> -->
	<style>

	    #main { font-size: 14pt }
	    form { text-align: center }

	    input { font-size: 12pt; margin-right: 12pt }
	    #email-phone, #email { width: 256pt }
	    input#order-id { width: 48pt }


	    table.order { min-width: 80%; border-spacing: 0 }
	    table.order > tbody > tr:first-child > th { border-top: thin solid gray; padding-top: 12pt }
	    table.order > tfoot > tr:first-child > td { border-top: medium double gray; padding-top: 12pt }

	</style>
@stop


@section('main')
<div id='main' class=''>

<h1>Orders</h1>
<p>To check the status of an order, enter your email address or phone number and your order number:</p>

<form id='search' name="ordersearch" method="post">

   Email/phone:<input id='email-phone' name='email' type='text' required title='email address or phone number' placeholder='email address or phone number' autofocus>
   Order # <input id='order-id' name='id' type='text' required title='order number' placeholder='' pattern='[0-9]+'>
    <input type='submit' class='small blue'>
</form>


<p style='margin-top: 48pt'>Or to receive a summary of your orders via email, enter your address below:</p>

<form action='' method='POST' name="requestmailform">
    Email: <input id='email' name='email' type='email' required title='email address' placeholder='email address'>
    <input type='submit' value='Request Email' name="requestemail" class='small blue'>
</form>

</div>
@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('js/template.js') }}"></script> -->
@stop

