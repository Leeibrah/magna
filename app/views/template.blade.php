@extends('layouts.scaffold')

{{-- Web site Title --}}
@section('title')
@parent
:: Template
@stop


@section('css')
	<!-- <link rel="stylesheet" href="{{ asset('css/template.css')}} "> -->
@stop


@section('main')

<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	<fieldset>
		<legend>
			<h3 class="gradient-light">Sign in</h3>
		</legend>
		<p>Welcome.</p>
	<input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />

	<!-- Email -->
	<div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
		<label class="control-label" for="email">Email</label>
		<div class="controls">
			<input type="text" name="email" id="email" value="{{ Input::old('email') }}" />
			{{ $errors->first('email', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ email -->

	<!-- Password -->
	<div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
		<label class="control-label" for="password">Password</label>
		<div class="controls">
			<input type="password" name="password" id="password" value="" />
			{{ $errors->first('password', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ password -->

	<p><a href="/forgot_password" class="a-forgot-password"><!-- Forgot your password? --></a></p>
	<!-- Login button -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-primary">Login</button>
		</div>
	</div>
	<!-- ./ login button -->
	</fieldset>
</form>


<?php
function getFloat($pString) {
    if (strlen($pString) == 0) {
            return false;
    }
    $pregResult = array();

    $commaset = strpos($pString,',');
    if ($commaset === false) {$commaset = -1;}

    $pointset = strpos($pString,'.');
    if ($pointset === false) {$pointset = -1;}

    $pregResultA = array();
    $pregResultB = array();

    if ($pointset < $commaset) {
        preg_match('#(([-]?[0-9]+(\.[0-9])?)+(,[0-9]+)?)#', $pString, $pregResultA);
    }
    preg_match('#(([-]?[0-9]+(,[0-9])?)+(\.[0-9]+)?)#', $pString, $pregResultB);
    if ((isset($pregResultA[0]) && (!isset($pregResultB[0]) 
            || strstr($pregResultA[0],$pregResultB[0]) == 0 
            || !$pointset))) {
        $numberString = $pregResultA[0];
        $numberString = str_replace('.','',$numberString);
        $numberString = str_replace(',','.',$numberString);
    }
    elseif (isset($pregResultB[0]) && (!isset($pregResultA[0]) 
            || strstr($pregResultB[0],$pregResultA[0]) == 0 
            || !$commaset)) {
        $numberString = $pregResultB[0];
        $numberString = str_replace(',','',$numberString);
    }
    else {
        return false;
    }
    $result = (float)$numberString;
    return $result;
}
?>

<?php 

function parseFloat($ptString) { 
            if (strlen($ptString) == 0) { 
                    return false; 
            } 
            
            $pString = str_replace(" ", "", $ptString); 
            
            if (substr_count($pString, ",") > 1) 
                $pString = str_replace(",", "", $pString); 
            
            if (substr_count($pString, ".") > 1) 
                $pString = str_replace(".", "", $pString); 
            
            $pregResult = array(); 
        
            $commaset = strpos($pString,','); 
            if ($commaset === false) {$commaset = -1;} 
        
            $pointset = strpos($pString,'.'); 
            if ($pointset === false) {$pointset = -1;} 
        
            $pregResultA = array(); 
            $pregResultB = array(); 
        
            if ($pointset < $commaset) { 
                preg_match('#(([-]?[0-9]+(\.[0-9])?)+(,[0-9]+)?)#', $pString, $pregResultA); 
            } 
            preg_match('#(([-]?[0-9]+(,[0-9])?)+(\.[0-9]+)?)#', $pString, $pregResultB); 
            if ((isset($pregResultA[0]) && (!isset($pregResultB[0]) 
                    || strstr($pregResultA[0],$pregResultB[0]) == 0 
                    || !$pointset))) { 
                $numberString = $pregResultA[0]; 
                $numberString = str_replace('.','',$numberString); 
                $numberString = str_replace(',','.',$numberString); 
            } 
            elseif (isset($pregResultB[0]) && (!isset($pregResultA[0]) 
                    || strstr($pregResultB[0],$pregResultA[0]) == 0 
                    || !$commaset)) { 
                $numberString = $pregResultB[0]; 
                $numberString = str_replace(',','',$numberString); 
            } 
            else { 
                return false; 
            } 
            $result = (float)$numberString; 
            return $result; 
} 
?> 

Comparing of float parsing functions with the following function: 

<?php 
function testFloatParsing() { 
    $floatvals = array( 
        "22 000,76", 
        "22.000,76", 
        "22,000.76", 
        "22 000", 
        "22,000", 
        "22.000", 
        "22000.76", 
        "22000,76", 
        "1.022.000,76", 
        "1,022,000.76", 
        "1,000,000", 
        "1.000.000", 
        "1022000.76", 
        "1022000,76", 
        "1022000", 
        "0.76", 
        "0,76", 
        "0.00", 
        "0,00", 
        "1.00", 
        "1,00", 
        "-22 000,76", 
        "-22.000,76", 
        "-22,000.76", 
        "-22 000", 
        "-22,000", 
        "-22.000", 
        "-22000.76", 
        "-22000,76", 
        "-1.022.000,76", 
        "-1,022,000.76", 
        "-1,000,000", 
        "-1.000.000", 
        "-1022000.76", 
        "-1022000,76", 
        "-1022000", 
        "-0.76", 
        "-0,76", 
        "-0.00", 
        "-0,00", 
        "-1.00", 
        "-1,00" 
    ); 
    
    echo "<table> 
        <tr> 
            <th>String</th> 
            <th>floatval()</th> 
            <th>getFloat()</th> 
            <th>parseFloat()</th> 
        </tr>"; 
        
    foreach ($floatvals as $fval) { 
        echo "<tr>"; 
        echo "<td>" . (string) $fval . "</td>"; 
        
        echo "<td>" . (float) floatval($fval) . "</td>"; 
        echo "<td>" . (float) getFloat($fval) . "</td>"; 
        echo "<td>" . (float) parseFloat($fval) . "</td>"; 
        echo "</tr>"; 
    } 
    echo "</table>"; 
} 

testFloatParsing();
?>

@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- // <script src="{{ asset('js/template.js') }}"></script> -->
@stop

