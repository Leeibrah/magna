@extends('layouts.scaffold')

{{-- Web site Title --}}
@section('title')
@parent
:: Owner Filter
@stop


@section('css')
	<!-- <link rel="stylesheet" href="{{ asset('css/template.css')}} "> -->
@stop


@section('main')

<h4>Sorry, you do not have rights to this resource</h4>

@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('js/template.js') }}"></script> -->
@stop

