@extends('layouts.scaffold')

{{-- Web site Title --}}
@section('title')
@parent
:: Your Cart
@stop


@section('css')
<!-- <link rel="stylesheet" href="{{ asset('assets/styles/css/error.css')}} "> -->
@stop


@section('main')

<div id='main' class=''>

<h1>Checkout</h1>

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

<?php
// var_dump(Input::all());
// $items =  DB::table('items')->where('session_id', session_id())->where('quantity', '>', 0)->get();
$totals = DB::table('order_totals')->where('order_id', session_id())->first();
if(isset($totals)):
    $exchange_rate= Functions::exchRate();
    $usd = Functions::getFloat($totals->total);
    $total_ksh = number_format($exchange_rate*$usd);
    ?>

    <h3>Total: KSh {{ $total_ksh }}</h3>

    <form id="checkout" method="POST" name="checkout" action="order"> <!-- PATCH does not deliver back errors -->




    @if(!Auth::user())

<br/>
    <table style="margin: 0px;">
    <tr>
    	<td style="border-right: 1px solid #999;">
            <h2 style="line-height: 10px;">New customer:</h2></td>
    	<td><h2 style="line-height: 10px;">Returning customer:</h2></td>
    </tr>
    <tr style="border-bottom: 1px solid #999;">
    	<td class="register" style="border-right: 1px solid #999;">
    		<span>
    		<label for="name">Name:</label>
    		<input type="text" id="name" name="name" title="FirstName Surname" placeholder="full name" pattern="[A-z]+ [A-z ]+" value="{{ Input::old('name') }}">
    		</span>
    		<span>
    		<label for="email">Email:</label>
    		<input type="email" id="email" name="email" placeholder="email address" value="{{ Input::old('email') }}">
    		</span>
    		<span>
    		<label for="phone">Phone:</label>
    		<input type="tel" id="phone" name="phone" title="07##-######" placeholder="mobile telephone number" pattern="07\d{2}-?\d{3}-?\d{3}" value="{{ Input::old('phone') }}">
    		</span>
    		<span>
    		<label for="password">Password:</label>
    		<input type="password" id="password" name="password" placeholder="password">
    		</span>
    		<span>
    		<label for="password">Confirm:</label>
    		<input type="password" name="password_confirmation" id="password_confirmation" placeholder="repeat password">
    		</span>
    	</td>

        <td class="login">
            <input type="hidden" name="csrf_token" id="csrf_token" value="{{ Session::getToken() }}" />
            <span>
            <label for="email">Email:</label>
            <input type="email" id="loginemail" name="login_email" placeholder="email address" value="{{ Input::old('login_email') }}">
            </span>
            <span>
            <label for="password">Password:</label>
            <input type="password" id="loginpassword" name="login_password" placeholder="password" value="">
            </span>
        </td>
    </tr>
    </table>

    @else

    <h4>Thank you {{ Auth::user()->name }}. Complete your order below...</h4>

    @endif

    <h2>Delivery Information:</h2>

    <div style="text-align: center;">

    <span style="display:block">
        <label for="city">City:</label>
        <select id="city" name="city" title="city">
            <option value="Nairobi">Nairobi</option>
        </select>
    </span>

        <label for="neighbourhood" style="width:100px">Neighbourhood:</label>
       {{ Form::select('neighbourhood', Functions::locations()) }}

    </div>

    <h2>Payment Information:</h2>


    <div style="text-align: center">

        <label>
            <input type="radio" id="m-pesa" name="payment_type" class="payment_type" value="m-pesa" required="" >
            <!-- {{ (Input::old('payment_type')== "m-pesa") ? 'checked="checked"' : '' }} -->
            <img src="{{ asset('images/m-pesa.jpg')}}">
        </label>


        <label>
            <input type="radio" id="cc" name="payment_type" class="payment_type" value="cc" required="">
            <!-- {{ (Input::old('payment_type')== "cc") ? 'checked="checked"' : 'first-time="true"' }} -->
            <img src="{{ asset('images/visa.png')}}">
            <img src="{{ asset('images/mastercard.jpg')}}">
        </label>
    </div>

    <div id="cc-info" style="visibility: hidden;margin-left: 50%;">
        <div>
            <label for="cc-num">Number:</label>
            <input id="cc-num" name="cc-num" type="text" required="" title="credit card number"
             placeholder="credit card number" pattern="[0-9]{13,16}" value="{{ Input::old('cc-num') }}">
        </div>
        <div>
            <label for="cc-month">Expires:</label>
            <select id="cc-month" name="cc-month" required="" title="expiration month">
                <option value="{{ Input::old('cc-month') }}">{{ Input::old('cc-month') ? Input::old('cc-month') : 'month' }}</option>
                <option value="01">1</option>
                <option value="02">2</option>
                <option value="03">3</option>
                <option value="04">4</option>
                <option value="05">5</option>
                <option value="06">6</option>
                <option value="07">7</option>
                <option value="08">8</option>
                <option value="09">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
            <select id="cc-year" name="cc-year" required="" title="expiration year">
                <option value="{{ Input::old('cc-year') }}">{{ Input::old('cc-year') ? Input::old('cc-year') : 'year' }}</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
            </select>
        </div>
    </div>

    <div class="button-wrapper" style="clear: both;"><input type="submit" name="submitorder" class="blue" value="Submit Order"></div>
<?php
if(isset(Auth::user()->email)):
    $email = Auth::user()->email;
endif;
// elseif(isset(var))
?>

    </form>
    <?php
else:
  echo '<h4>Your cart is empty :( </h4>';
endif;
?>

</div>
	
@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->


<script type="text/javascript">

$('.login input').on('focus', function(){
    $('.register span input').each(function(){ $(this).val('');});
})
$('.register span input').on('focus', function(){
    $('.login input').each(function(){ $(this).val('');});
})

var form = document.getElementById('checkout');
var ccInfo = document.getElementById('cc-info');
var ccNum = document.getElementById('cc-num');
var ccExpMonth = document.getElementById('cc-month');
var ccExpYear = document.getElementById('cc-year');

if(document.getElementById('cc').checked){
    //form.setAttribute('action', "https://backoffice.host.iveri.com/Lite/Transactions/New/Authorise.aspx");
    ccNum.removeAttribute('disabled');
    ccExpMonth.removeAttribute('disabled');
    ccExpYear.removeAttribute('disabled');
    ccInfo.style.visibility='visible';
}

document.getElementById('m-pesa').addEventListener('click', function() {
    form.setAttribute('action', "{{ Functions::host() }}/order");
    ccInfo.style.visibility='hidden';
    ccNum.setAttribute('disabled');
    ccExpMonth.setAttribute('disabled');
    ccExpYear.setAttribute('disabled');
    // document.getElementById('cc').setAttribute('off');
}, false);

document.getElementById('cc').addEventListener('click', function() {
    form.setAttribute('action', "https://backoffice.host.iveri.com/Lite/Transactions/New/Authorise.aspx");
    // form.setAttribute('action', "https://backoffice.iveri.co.za/Lite/Transactions/New/EasyAuthorise.aspx");
    ccNum.removeAttribute('disabled');
    ccExpMonth.removeAttribute('disabled');
    ccExpYear.removeAttribute('disabled');
    ccInfo.style.visibility='visible';
    this.removeAttribute('first-time');
}, false);

form.addEventListener('submit', function() {
    var fullName = document.getElementById('name').value.trim();
    var firstSpaceIndex = fullName.indexOf(" ");
    if (firstSpaceIndex != -1) {
        document.getElementById('iveri-lite-name-first').value = fullName.substring(0, firstSpaceIndex);
        document.getElementById('iveri-lite-name-last').value = fullName.substring(firstSpaceIndex+1).trim();
    }
    if(document.getElementById('phone')!=''){
        document.getElementById('iveri-lite-phone').value = document.getElementById('phone').value;
        document.getElementById('iveri-lite-email').value = document.getElementById('email').value;
    }
    else{
        // document.getElementById('iveri-lite-phone').value = document.getElementById('phone').value;
        document.getElementById('iveri-lite-email').value = document.getElementById('loginemail').value;
    }
}, false);


</script>


@stop

