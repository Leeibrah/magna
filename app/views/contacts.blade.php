@extends('layouts.scaffold')

{{-- Web site Title --}}
@section('title')
@parent
:: Contact Us
@stop


@section('css')
	<!-- <link rel="stylesheet" href="{{ asset('css/contact.css')}} "> -->
@stop


@section('main')

<div id='main' class=''>


<h1>Contacts</h1>

<pre>
VituMob Company Limited
P.O. Box 26309-00100
Nairobi, Kenya
tel: 0717-363433
<?php
//php test playground
// $knownmerchant = DB::select('SELECT `id` FROM merchants where `url` like "%toysrus.com%"');
// echo $knownmerchant['0']->id;
?>
 
</pre>

<p>For questions about an order, please email <a href='mailto:orders@vitumob.com' class='email'>orders@vitumob.com</a>.</p>

<p>For questions about using the VituMob software, please email <a href='mailto:help@vitumob.com' class='email'>help@vitumob.com</a>.</p>

<p>Please direct all other inquiries to <a href='mailto:contact@vitumob.com' class='email'>contact@vitumob.com</a>.</p>


</div>


@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('js/contact.js') }}"></script> -->
@stop

