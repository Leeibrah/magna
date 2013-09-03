@extends('layouts.vitumob')

{{-- Web site Title --}}
@section('title')
@parent
:: Your Cart
@stop


@section('css')
	<!-- <link rel="stylesheet" href="{{ asset('assets/styles/css/error.css')}} "> -->
@stop


@section('main')
<?php
//session_start();
isset($_REQUEST['mode']) ?  $mode = $_REQUEST['mode'] : $mode = "nothing";
// echo $mode;

$subtotal = isset($_REQUEST['mode']) ? $_REQUEST['subtotal']: null;
$customs = isset($_REQUEST['mode']) ? $_REQUEST['customs']: null;
$shipping = isset($_REQUEST['mode']) ? $_REQUEST['shipping']: null;
$vat = isset($_REQUEST['mode']) ? $_REQUEST['vat']: null;
$total = isset($_REQUEST['mode']) ? $_REQUEST['total']: null;

if(isset($mode) && $mode=="del") //delete items
{
	$del  = "delete from items where id='".$_REQUEST['id']."'";
	mysql_query($del);
}

if(isset($_POST['submit'])) //submit to checkout...
{
		$updcartdetail = "update order_totals set 
		sub_total='".$subtotal."',
		custom_import='$customs',
		shipping='$shipping',
		vat='$vat',
		total='$total',
		where order_id='".session_id()."'";
		mysql_query($updcartdetail);
		//echo "<script>document.location.href='http://localhost/vitumob/VituMob_code_and_other_files/checkout'<\/script>";
		echo "<script>document.location.href='".Functions::host()."/checkout/'</script>";
}

if(isset($_POST['updateqty'])) //update qty
{
	if(is_array($_REQUEST['qty']))
	{
		foreach($_REQUEST['qty'] as $key=>$val)
		{
			$upd_produt = "UPDATE items SET quantity='".$val."' WHERE id='".$key."'";
			mysql_query($upd_produt);
			
		}
	}
}
?>


<div id='main' class=''>

	<h1 class='cart'>Cart</h1>

	<table id='cart' data-exchange-rate='90.43'>

	  <!--  <thead>
	        <tr>
	            <td width='15%'></td>
	            <td width='55%'></td>
	            <td width='10%' class='price'>Price&nbsp;USD</td>
	            <td width='10%' class='price'>Price&nbsp;KSh</td>
	            <td width='10%'>Quantity</td>
	        </tr>
	    </thead>-->

	<tbody data-merchant='amazon.com'><tr style='display:none;'><td class='image'><img src='http://ecx.images-amazon.com/images/I/51VCxDVBn2L._SL500_SS100_.jpg'></td><td class='name'><span><a href='http://www.amazon.com/gp/product/B00BT7RAPG/ref=ox_sc_act_title_1?ie=UTF8&psc=1&smid=A389UX2GHRBG9'>Tech Armor Samsung Galaxy S4 SIV Premium High Definition (HD) Clear Screen Protectors with Lifetime Replacement Warranty [3-Pack] - Retail Packaging</a></span><br>628.4885<td class='price'>$6.95</td><td class='price' >628</td><td class='quantity'><div><input type='text' value='1'><span class='delete'>delete</span></div></td><tr style='display:none;'><td class='image'><img src='http://ecx.images-amazon.com/images/I/51dnOzvXU5L._SL500_PIsitb-sticker-arrow-big,TopRight,35,-73_OU01_SS100_.jpg'></td><td class='name'><span><a href='http://www.amazon.com/gp/product/0847833380/ref=ox_sc_act_title_2?ie=UTF8&psc=1&smid=ATVPDKIKX0DER'>Louis Vuitton: Art, Fashion and Architecture</a></span><br>4837.1007<td class='price'>$53.49</td><td class='price' >4,837</td><td class='quantity'><div><input type='text' value='1'><span class='delete'>delete</span></div></td></tr>  <table id='cart' data-exchange-rate='90.43'>
	    <thead>
	        <tr>
	          <td>&nbsp;</td>
	          <td></td>
	          <td class='price'>&nbsp;</td>
	          <td class='price'>&nbsp;</td>
	          <td>&nbsp;</td>
	        </tr>
	        <tr>
	            <td width='15%'>Items</td>
	            <td width='55%'></td>
	            <td width='10%' class='price'>USD</td>
	          <td width='10%' class='price'>KSh</td>
	          <td width='10%'>Quantity</td>
	        </tr>
	    </thead>

	<tbody data-merchant='amazon.com'>
	<tr class='merchant'>
		<th colspan='5'>&nbsp;</th>
	 </tr>
	 <form name="form1" action="" method="post">
	 
	 
	 	<tr class=''>
		<th colspan='5'><a href='http://www.amazon.com/gp/product/B00BT7RAPG/ref=ox_sc_act_title_1?ie=UTF8&psc=1&smid=A389UX2GHRBG9' style="color:#027FC2">amazon.com</a></th>
	 </tr>
		 <tr class='item' data-item-id='B00BT7RAPG' data-quantity='1' data-price-usd='6.95' data-customs='0.25'>
	 <td class='image'><img src='http://ecx.images-amazon.com/images/I/51VCxDVBn2L._SL500_SS100_.jpg'></td>
	 <td class='name'>
	 <span><a href='http://www.amazon.com/gp/product/B00BT7RAPG/ref=ox_sc_act_title_1?ie=UTF8&psc=1&smid=A389UX2GHRBG9'>Tech Armor Samsung Galaxy S4 SIV Premium High Definition (HD) Clear Screen Protectors with Lifetime Replacement Warranty [3-Pack] - Retail Packaging</a></span>
	 <span style="font-size:12px;">
	  </span>

	 <br>
	 <td class='price'>$6.95</td>
	 <td class='price' >628</td>
	 <td colspan="2" class='quantity'><div><input type="text" name="qty[393]" value="1"><br>
	<a href="index.php?mode=del&id=393"><span class=''>Delete</span></a></div>
	   </tbody></td>        
	     <tr class='item' data-item-id='0847833380' data-quantity='1' data-price-usd='53.49' data-customs='0.25'>
	 <td class='image'><img src='http://ecx.images-amazon.com/images/I/51dnOzvXU5L._SL500_PIsitb-sticker-arrow-big,TopRight,35,-73_OU01_SS100_.jpg'></td>
	 <td class='name'>
	 <span><a href='http://www.amazon.com/gp/product/0847833380/ref=ox_sc_act_title_2?ie=UTF8&psc=1&smid=ATVPDKIKX0DER'>Louis Vuitton: Art, Fashion and Architecture</a></span>
	 <span style="font-size:12px;">
	  </span>

	 <br>
	 <td class='price'>$53.49</td>
	 <td class='price' >4,837</td>
	 <td colspan="2" class='quantity'><div><input type="text" name="qty[394]" value="1"><br>
	<a href="index.php?mode=del&id=394"><span class=''>Delete</span></a></div>
	   </tbody></td>        
	    
	 <tr>
		  <td colspan="5" class="label"><input type="submit" name="updateqty" value="Update Cart" class="blue button">&nbsp;</td>
	    </tr> 


	<input type="hidden" name="mode" value="">
	  <input type="hidden" name="subtotal-usd-fld" id="subtotal-usd-fld" value="$60.44">
	  <input type="hidden" name="subtotal-ksh-fld" id="subtotal-ksh-fld" value="5,466">
	  
	  <input type="hidden" name="customs-usd-fld" id="customs-usd-fld" value="$15.49">
	  <input type="hidden" name="customs-ksh-fld" id="customs-ksh-fld" value="1,401">
	    
	    
	   <input type="hidden" name="shipping-usd-fld" id="shipping-usd-fld" value="$20.00">
	  <input type="hidden" name="shipping-ksh-fld" id="shipping-ksh-fld" value="1,809">
	  
	  <input type="hidden" name="vat-usd-fld" id="vat-usd-fld" value="$9.67">
	  <input type="hidden" name="vat-ksh-fld" id="vat-ksh-fld" value="874">
	  
	  <input type="hidden" name="total-usd-fld" id="total-usd-fld" value="$105.60">
	  <input type="hidden" name="total-ksh-fld" id="total-ksh-fld" value="9,549"> 
	  <tfoot>
	 
	   <tr><td></td><td class='label'>Subtotal</td><td  class='price'>$60.44</td><td  class='price'>5,466</td><td></td></tr>
	    <tr><td></td><td class='label'>Customs &amp; Import Fees</td><td class='price' id="customfee-usd">$15.49</td><td class='price' id="customfee-ksh">1,401</td></tr>
	    <tr><td></td><td class='label'>Shipping &amp; Handling</td><td class='price' id="shippingfee-usd">$20.00</td><td class='price' id="shipping-ksh">1,809</td></tr>
	    <tr><td></td><td class='label'>VAT</td><td class='price' id="vatfee-usd">$9.67</td><td class='price' id="vat-ksh">874</td></tr>
	    <tr><td></td><td class='label'>Total</td><td class='price' id="totalfee-usd">$105.60</td><td class='price' id="total-ksh">9,549</td></tr>
	    <tr><td></td><td></td><td colspan='2'><!--<a href='index.php?mode=checkout' class='blue button'>Checkout</a>-->
	    <input type="submit" name="submit" value="Checkout" class="blue button">
	    </td></tr>
	   </tfoot>
	</form>
	</table>


</div>

@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('assets/scripts/js/vendor/bootstrap.min.js') }}"></script> -->
@stop

