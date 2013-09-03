@extends('layouts.vitumob')

{{-- Web site Title --}}
@section('title')
@parent
:: Info
@stop


@section('css')
	<!-- <link rel="stylesheet" href="{{ asset('css/info.css')}} "> -->
@stop


@section('main')

<div id='main'>

{{ $inf }}

</div>


<div id='footer'>
    <span>&copy;2013 VituMob</span>
</div>


@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('js/info.js') }}"></script> -->
@stop

