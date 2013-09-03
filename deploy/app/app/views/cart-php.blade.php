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

<table id='cart' data-exchange-rate='<?php echo Functions::exchRate($RATE_ADJUST); ?>'>


<?php
$exchange_rate=Functions::exchRate($RATE_ADJUST);
	echo "<tbody data-merchant='".$bundle["host"]."'>";


	$max = sizeof($bundle["items"]);
	for ($i=0; $i<$max; $i++) {

		/*     PRINT EACH PRODUCT     */
		echo "<tr style='display:none;'>";

		echo "<td class='image'><img src='".$bundle["items"][$i]["image"]."'></td>";

		echo "<td class='name'><span>";
		echo "<a href='";
		echo $bundle["items"][$i]["link"];
		echo "'>";
		echo $bundle["items"][$i]["name"];
		echo "</a></span><br>";
		if ($bundle["items"][$i]["name2"]) {
				echo "<span class='name2'>";
				echo $bundle["items"][$i]["name2"];
				echo "</span><br>";
			}



		$price=$bundle["items"][$i]["price"]*$bundle["items"][$i]["quantity"];
		echo $price_kes=$price*$exchange_rate; //exchange to ksh

		$pricekes_1 = $bundle["items"][$i]["price"]*$exchange_rate; //exchange to ksh

		echo "<td class='price'>$".$price."</td>";
		echo "<td class='price' >".number_format($price_kes,0)."</td>";
		echo "<td class='quantity'><div><input type='text' value='".$bundle["items"][$i]["quantity"]."'><span class='delete'>delete</span></div></td>";
			//select statements & update stmts
		echo "</tr>";
   }


$sqlsel1 = "select * from order_totals where order_id='".session_id()."'";
$resel1 = mysql_query($sqlsel1);
if(mysql_num_rows($resel1)<1)
{
	$sqlinscardtotal = "insert into order_totals set order_id='".session_id()."'";
	mysql_query($sqlinscardtotal);
}

?>
  <table id='cart' data-exchange-rate='<?php echo Functions::exchRate($RATE_ADJUST); ?>'>
<?php

$i=0;

$sqlord = "select link, merchant_id from items where order_id='".session_id()."' and status='0' group by merchant_id order by merchant_id asc";
 $reord = mysql_query($sqlord) or die(mysql_error());
 if(mysql_num_rows($reord)>0)
 {
 ?>
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

<tbody data-merchant='<?php echo $bundle["host"];?>'>
<tr class='merchant'>
	<th colspan='5'>&nbsp;</th>
 </tr>
 <form name="form1" action="" method="post">
 
 
 <?php
 
 	while($roword = mysql_fetch_array($reord))
	{
	
	
	?>
	<tr class=''>
	<th colspan='5'><a href='<?php echo stripslashes($roword['link'])?>' style="color:#027FC2"><?php echo $bundle["host"]; ?></a></th>
 </tr>
	<?php

	$sql = "select * from items where order_id='".session_id()."' and status='0' and merchant_id='".$roword["merchant_id"]."'";
 $re = mysql_query($sql) or die(mysql_error());
 	while($row = mysql_fetch_array($re))
	{
		$price=$row['item_price']*$row["quantity"];
		
		$sbtotal+=$price;		
		
		$hostArr = array("bestbuy.com","cellhut.com","apple.com");

		if(in_array($row["merchant_id"],$hostArr) || (strpos(strtolower($row['name']),"phone") || strpos(strtolower($row['name']),"computer") || strpos(strtolower($row['name']),"printer") || strpos(strtolower($row['name']),"camera") || strpos(strtolower($row['name']),"electronic") || strpos(strtolower($row['name']),"camcorder") || strpos(strtolower($row['name']),"kindle")  || strpos(strtolower($row['name']),"ipad") || strpos(strtolower($row['name2']),"phone") || strpos(strtolower($row['name2']),"computer") || strpos(strtolower($row['name2']),"printer") || strpos(strtolower($row['name2']),"camera") || strpos(strtolower($row['name2']),"electronic") || strpos(strtolower($row['name2']),"camcorder") || strpos(strtolower($row['name2']),"kindle")  || strpos(strtolower($row['name2']),"ipad")))
		{
			$customrate = 2.25;
			
			$customamout = $price * $customrate/100;
			if($customamout>12)
			{
				$customs += $price * $customrate/100;	
				$vat = 0;	
			}
			else
			{
				$customs += 12;	
				$vat = 0;	
			}
		}
		else if($row["merchant_id"]=="autopartswarehouse.com")
		{
			$customrate = 10.25;
			$customs += $price * $customrate/100;	
			$vat += $price * 16/100;	
						
		}
		else
		{
			$customrate = 25.625;
		
			$customs += $price * $customrate/100;	
			$vat += $price * 16/100;	
		}
 ?>
 <tr class='item' data-item-id='<?php echo $row['item_id']?>' data-quantity='<?php echo $row['quantity']?>' data-price='<?php echo $row['item_price']?>' data-customs='0.25'>
 <td class='image'><img src='<?php echo $row['image']?>'></td>
 <td class='name'>
 <span><a href='<?php echo stripslashes($row['link'])?>'><?php echo stripslashes($row['name'])?></a></span>
 <?php if(!empty($row['color']) || !empty($row['size'])){echo "<br>";}?>
<span style="font-size:12px;">
 <?php
 if(!empty($row['name2']))
 {
 	echo "<br> ".stripslashes($row['name2']);
 }
 if(!empty($row['color']))
 {
 	echo "Color : ".stripslashes($row['color']);
 }
 if(!empty($row['size']))
 {
 	if(!empty($row['color']))
	{
		echo ",&nbsp;";
	}
 	echo "Size : ".stripslashes($row['size']);
 }
 if(!empty($row['designer']))
 {
 	echo "<br>Designer : ".stripslashes($row['designer']);
 }

 if(!empty($row['package']))
 {
 	echo "<br>Package : ".stripslashes($row['package']);
 }
 if(!empty($row['printondemand']))
 {
 	echo "<br>Print on demand : ".stripslashes($row['printondemand']);
 }
 if(!empty($row['front_logo']))
 {
 	echo "<br>Front Logo : ".stripslashes($row['front_logo']);
 }
 if(!empty($row['custombacknumber']))
 {
 	echo "<br>Custom Back Number : ".stripslashes($row['custombacknumber']);
 }
 if(!empty($row['custombackname']))
 {
 	echo "<br>Custom Back Name : ".stripslashes($row['custombackname']);
 }
 ?>
 </span>

 <br>
 <td class='price'>$<?php echo number_format($price, 2, '.', '')?></td>
 <td class='price' ><?php echo number_format($price*$exchange_rate)?></td>
 <td colspan="2" class='quantity'>
 	<div>
 		<input type="text" name="qty[<?php echo $row['id']?>]" value="<?php echo $row['quantity']?>"><br>
 		<a href="index.php?mode=del&id=<?php echo $row['id'];?>"><span class=''>Delete</span></a>
 	</div>
</tbody>
</td>        
    <?php
		$i++;
	}
	
	$shipping = ($sbtotal + $customrate) * 0.12;
	if ($shipping) {
		$minShipping = 10 + (5 * $i);
		if ($shipping < $minShipping) $shipping = $minShipping;
	}
	
	$total = (($sbtotal + $customs + $shipping + $vat) * 100) / 100;
 }?>

 <tr>
	  <td colspan="5" class="label"><input type="submit" name="updateqty" value="Update Cart" class="blue button">&nbsp;</td>
    </tr> 


<input type="hidden" name="mode" value="<?php echo $mode?>">
  <input type="hidden" name="subtotal" id="subtotal" value="$<?php echo number_format($sbtotal, 2, '.', '');?>">
  <input type="hidden" name="subtotal-ksh-fld" id="subtotal-ksh-fld" value="<?php echo number_format($subtotal*$exchange_rate);?>">
  
  <input type="hidden" name="customs" id="customs" value="$<?php echo number_format($customs, 2, '.', '');?>">
  <input type="hidden" name="customs-ksh-fld" id="customs-ksh-fld" value="<?php echo number_format($customrate*$exchange_rate);?>">
    
    
   <input type="hidden" name="shipping" id="shipping" value="$<?php echo number_format($shipping, 2, '.', '');?>">
  <input type="hidden" name="shipping-ksh-fld" id="shipping-ksh-fld" value="<?php echo number_format($shipping*$exchange_rate);?>">
  
  <input type="hidden" name="vat" id="vat" value="$<?php echo number_format($vat, 2, '.', '');?>">
  <input type="hidden" name="vat-ksh-fld" id="vat-ksh-fld" value="<?php echo number_format($vat*$exchange_rate);?>">
  
  <input type="hidden" name="total" id="total" value="$<?php echo number_format($total, 2, '.', '');?>">
  <input type="hidden" name="total-ksh-fld" id="total-ksh-fld" value="<?php echo number_format($total*$exchange_rate);?>"> 
  <tfoot>
 
   <tr><td></td><td class='label'>Subtotal</td><td  class='price'>$<?php echo number_format($sbtotal, 2, '.', '');?></td><td  class='price'><?php echo number_format($subtotal*$exchange_rate);?></td><td></td></tr>
    <tr><td></td><td class='label'>Customs &amp; Import Fees</td><td class='price' id="customfee">$<?php echo number_format($customs, 2, '.', '');?></td><td class='price' id="customfee-ksh"><?php echo number_format($customrate*$exchange_rate);?></td></tr>
    <tr><td></td><td class='label'>Shipping &amp; Handling</td><td class='price' id="shippingfee">$<?php echo number_format($shipping, 2, '.', '');?></td><td class='price' id="shipping-ksh"><?php echo number_format($shipping*$exchange_rate);?></td></tr>
    <tr><td></td><td class='label'>VAT</td><td class='price' id="vatfee">$<?php echo number_format($vat, 2, '.', '');?></td><td class='price' id="vat-ksh"><?php echo number_format($vat*$exchange_rate);?></td></tr>
    <tr><td></td><td class='label'>Total</td><td class='price' id="totalfee">$<?php echo number_format($total, 2, '.', '');?></td><td class='price' id="total-ksh"><?php echo number_format($total*$exchange_rate);?></td></tr>
    <tr><td></td><td></td><td colspan='2'><!--<a href='index.php?mode=checkout' class='blue button'>Checkout</a>-->
    <input type="submit" name="submit" value="Checkout" class="blue button">
    </td></tr>
   </tfoot>
</form>
<?php 
}else{
?>
	
	<tr>
    	<td colspan="5">
        <div id='notice'><p>There are no items in your VituMob shopping cart.</p></div>
        <?php
		$_SESSION=array();
		@session_regenerate_id();
		unset($_SESSION);
		session_unset();
		session_destroy();
		
		?>
                </td>
    </tr>
<?php } ?>
</table>

@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <!-- <script src="{{ asset('assets/scripts/js/vendor/bootstrap.min.js') }}"></script> -->
@stop

