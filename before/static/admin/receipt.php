<?php
session_start();

if(empty($_SESSION['AdminID']))
{
	echo "<script>document.location.href='login.php'</script>";
}
include("../../config.php");
$sqlorderdata = "select * from orders where id='".$_REQUEST['orderid']."'";
$reorderdata = mysql_query($sqlorderdata);
$roworderdata = mysql_fetch_array($reorderdata);
?>
<link rel='stylesheet' href="../vitumob.css">
<div id='header'><a href='http://www.vitumob.com/beta'><img id='logo' src='../../images/logo.png'></a></div>
<div  style="background:url(http://www.vitumob.com/images/tag_without.png) no-repeat; background-position:58% top">
<div id='main' class=''>


<div align="center" style="font-weight:bold">Order #<?php echo $_REQUEST['orderid'];?></div>
<br>

<div align="center" style="text-align:left; margin-left:430px; ">
<?php echo $roworderdata['name']?><br>
<?php echo $roworderdata['email']?><br>
<?php echo $roworderdata['phone']?>
</div>

<style>

    table.order { min-width: 80%; border-spacing: 0 }
    table.order > tbody > tr:first-child > th { border-top: thin solid gray; padding-top: 12pt }
    table.order > tfoot > tr:first-child > td { border-top: medium double gray; padding-top: 12pt }

</style>

<table id='cart'>
<?php

$i=0;
$sqlord = "select link,host_name from cart where order_id='".$_REQUEST['orderid']."' and status='1' group by host_name order by host_name asc";
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
          
          <td width='10%' class='price'>KSh</td>
          <td width='10%' colspan="2">Quantity</td>
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
	<th colspan='5'><a href='<?php echo $roword["link"]?>' style="color:#027FC2"><?php echo $roword["host_name"];?></a></th>
 </tr>
	<?php
	
	$sql = "select * from cart inner join cart_total on cart.session_id=cart_total.session_id where order_id='".$_REQUEST['orderid']."' and status='1' and host_name='".$roword["host_name"]."'";
 $re = mysql_query($sql) or die(mysql_error());
 	while($row = mysql_fetch_array($re))
	{
			
		
 ?>
 <tr class='item' data-item-id='<?php echo $row['item_id']?>' data-quantity='<?php echo $row['quantity']?>' data-price-usd='<?php echo $row['item_price_usd']?>' data-customs='0.25'>
 <td class='image'><img src='<?php echo $row['image']?>'></td>
 <td class='name'>
 <span><a href='<?php echo stripslashes($row['link'])?>'><?php echo stripslashes($row['name'])?></a></span>
  <?php if(!empty($row['color']) || !empty($row['size'])){echo "<br>";}?>
 
 <span style="font-size:12px;">
 <?php
 if(!empty($row['name2']))
 {
 	echo "<br>".stripslashes($row['name2']);
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
 $price_ksh = $row['item_price_ksh']*  $row['quantity'] ;
 ?>
 </span>
 <br>
 <td class='price' ><?php echo number_format($price_ksh)?></td>
 <td colspan="2" class='quantity'><div><?php echo $row['quantity']?></div>
   </tbody></td>        
    <?php
		$i++;
		
		$subtotal_ksh=$row['sub_total_ksh'];
		
		$customrate_ksh = $row['custom_import_fee_ksh'];
		$vat_ksh = $row['vat_ksh'];
		
		$shipping_ksh = $row['shipping_ksh'];
		$total_ksh = $row['total_ksh'];
	}
	
	
 }?>
  <tfoot>
 
   <tr><td>&nbsp;</td><td class='label'>Subtotal</td>
     <td  class='price'><?php echo $subtotal_ksh;?></td>
     <td  class='price'>&nbsp;</td><td></td></tr>
    <tr><td></td><td class='label'>Customs &amp; Import Fees</td>
      <td class='price' id="customfee-usd"><?php echo $customrate_ksh;?></td><td class='price' id="customfee-ksh">&nbsp;</td></tr>
    <tr><td></td><td class='label'>Shipping &amp; Handling</td>
      <td class='price' id="shippingfee-usd"><?php echo $shipping_ksh;?></td><td class='price' id="shipping-ksh">&nbsp;</td></tr>
    <tr><td></td><td class='label'>VAT</td>
      <td class='price' id="vatfee-usd"><?php echo $vat_ksh;?></td><td class='price' id="vat-ksh">&nbsp;</td></tr>
    <tr><td></td><td class='label'>Total</td>
      <td class='price' id="totalfee-usd"><?php echo $total_ksh;?></td><td class='price' id="total-ksh">&nbsp;</td></tr>
      
       <tr><td></td><td class='label'></td>
      <td class='pricesa' id="vatfee-usdsas"></td><td class='pricesa' id="vat-kshsas">&nbsp;</td></tr>
   </tfoot>
</form>
<?php 
}else{
?>
	
	<tr>
    	<td colspan="5">
        <div id='notice'><p>There are no items in your VituMob shopping cart.</p></div>        </td>
    </tr>
<?php }?>
</table>


</div>
</div>