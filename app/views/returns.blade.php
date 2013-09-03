@extends('layouts.scaffold')

{{-- Web site Title --}}
@section('title')
@parent
:: Return Policy
@stop


@section('css')
	<!-- <link rel="stylesheet" href="{{ asset('css/returnpolicy.css')}} "> -->
@stop


@section('main')

<div id='main' class='legal'>

<h1>Return Policy</h1>

<p>If you receive an item from VituMob&copy; that is different than the item you ordered or is broken or defective when delivered, please notify the VituMob&copy; delivery person upon receipt. VituMob&copy; is happy to return such items for VituMob&copy; credit or a full refund, whichever you prefer. If an item you ordered is the wrong size or you decide you do not want it, VituMob&copy; is unable to accept returns. Please inspect your VituMob&copy; item when you receive it, prior to signing to accept receipt of the delivery.</p>

<p>Any questions or concerns regarding your order should be emailed to <a href='mailto:contact@vitumob.com'>contact@vitumob.com</a> with your name, order number and the problem with your order.</p>


</div>

@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('js/returnpolicy.js') }}"></script> -->
@stop

