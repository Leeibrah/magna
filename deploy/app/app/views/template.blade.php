@extends('layouts.vitumob')

{{-- Web site Title --}}
@section('title')
@parent
:: Template
@stop


@section('css')
	<!-- <link rel="stylesheet" href="{{ asset('css/template.css')}} "> -->
@stop


@section('main')


@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('js/template.js') }}"></script> -->
@stop

