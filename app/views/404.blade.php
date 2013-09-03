@extends('layouts.scaffold')

{{-- Web site Title --}}
@section('title')
@parent
:: 404
@stop


@section('css')
	<!-- <link rel="stylesheet" href="{{ asset('css/template.css')}} "> -->
@stop


@section('main')

<h4>404 - file not found</h4>

@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('js/template.js') }}"></script> -->
@stop

