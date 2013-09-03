<?php include("../config.php");
$updorder = "update orders set order_status='1',payment_received=now() where id='".$_REQUEST['orderid']."'";
mysql_query($updorder);

$updcart = "update cart set status='1' where order_id='".$_REQUEST['orderid']."'";
mysql_query($updcart);
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>VituMob: kila kitu kila siku</title>
    <meta charset='utf-8'>
     <link rel='stylesheet' href="../static/vitumob.css">
<link rel="shortcut icon" href="../favicon.ico">
    <link rel='chrome-webstore-item' href="https://chrome.google.com/webstore/detail/ndfakojkecjkdibnkcoljkdbkbkoloik">
    
</head>

<body>



<div id='nav-bar'>


<span><a href='/cart'>cart</a></span>



<span><a href='/orders'>orders</a></span>



<span><a href='/contact'>contact</a></span>


</div>

<div id='header'><a href='http://www.vitumob.com/beta'><img id='logo' src='../images/logo.png'></a></div>

<div id='main' class=''>


<h1>Order #<?php echo $_REQUEST['id'];?></h1>

<h2>Status: <span>shipping</span></h2>
<?php 
$sqlord = "select link,host_name from cart inner join orders on cart.order_id=orders.id where order_id='".$_REQUEST['id']."' and status='1' group by host_name order by host_name asc";
 $reord = mysql_query($sqlord) or die(mysql_error());
 if(mysql_num_rows($reord)>0)
 { 
?>
<table id='order-status'>

<?php

	$sqlflag = "select * from cart inner join orders on cart.order_id=orders.id where order_id='".$_REQUEST['id']."' and status='1' group by host_name order by host_name asc";
	$reflag = mysql_query($sqlflag);
	$rowflag = mysql_fetch_array($reflag);

	if($rowflag['arrived']=="0000-00-00 00:00:00")
	{
		$kenya = "../images/kenya-dim.png";
		$arrow = "../images/arrow_orange-dim3.png";
		$home = "../images/home-dim2.png";
	}
	else
	{
		$kenya = "../images/kenya.png";
		$arrow = "../images/arrow_orange-dim3.png";
		$home = "../images/home-dim2.png";
	}
	if($rowflag['delivered']!="0000-00-00 00:00:00")
	{
		$kenya = "../images/kenya.png";
		$arrow = "../images/arrow_orange.png";
		$home = "../images/home.png";
	}
	



?>

    <tr>
        <td><img src='../images/plane.png'></td>
        <td><img src='../images/arrow_orange.png'></td>
        <td class='not-yet'><img src='<?php echo $kenya;?>'></td>
        <td class='not-yet'><img src='<?php echo $arrow;?>'></td>
        <td class='not-yet'><img src='<?php echo $home?>'></td>
    </tr>

</table>
<?php
}
?>

<style>

    table.order { min-width: 80%; border-spacing: 0 }
    table.order > tbody > tr:first-child > th { border-top: thin solid gray; padding-top: 12pt }
    table.order > tfoot > tr:first-child > td { border-top: medium double gray; padding-top: 12pt }

</style>

<table id='cart'>
<?php

$i=0;

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
	
	$sql = "select *,cart.name as cartname from cart inner join cart_total on cart.session_id=cart_total.session_id where order_id='".$_REQUEST['id']."' and status='1' and host_name='".$roword["host_name"]."'";
 $re = mysql_query($sql) or die(mysql_error());
 	while($row = mysql_fetch_array($re))
	{
		
		
 ?>
 <tr class='item' data-item-id='<?php echo $row['item_id']?>' data-quantity='<?php echo $row['quantity']?>' data-price-usd='<?php echo $row['item_price_usd']?>' data-customs='0.25'>
 <td class='image'><img src='<?php echo $row['image']?>'></td>
 <td class='name'>
 <span><a href='<?php echo stripslashes($row['link'])?>'><?php echo stripslashes($row['cartname'])?></a></span>
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
     <td  class='price'>&nbsp;</td><td>&nbsp;</td></tr>
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

<div id='footer'>
<hr>

<p style='margin-top: 36pt; color: dimgray'>Click any site below to shop</p>

  <a href='http://www.amazon.com/' title='electronics, apparel, computers, books, & DVDs'><img src='../images/merchant_logos/amazon.png'></a>
  <a href='http://store.apple.com/' title='iPad, iPhone, MacBook, iMac & Mac mini'><img src='../images/merchant_logos/apple.png'></a>
  <a href='http://www.cellhut.com/' title='unlocked cell phones: Motorola, Nokia, Sony Ericsson'><img src='../images/merchant_logos/cellhut.jpg'></a>
  <a href='http://www.macys.com/' title='fashion clothing & accessories'><img src='../images/merchant_logos/macys.gif'></a>
  <a href='http://www.bestbuy.com/' title='consumer electronics'><img src='../images/merchant_logos/bestbuy.png'></a>
  <a href='http://www.autopartswarehouse.com/' title='car parts & accessories'><img src='../images/merchant_logos/autopartswarehouse.png'></a>
  <a href='http://www.fragrancenet.com/' title='perfume, cologne & discount fragrances'><img src='../images/merchant_logos/fragrancenet.gif'></a>
  <a href='http://www.victoriassecret.com/' title='lingerie, women&#39;s clothing & accessories'><img src='../images/merchant_logos/victoriassectret.gif'></a>
  <a href='http://www.neimanmarcus.com/' title='designers Eileen Fisher, Tory Burch, Gucci, Christian Louboutin & more'><img src='../images/merchant_logos/neimanmarcus.png'></a>
  <a href='http://www.worldsoccershop.com/' title='official soccer jerseys, shirts, cleats, shoes, balls & gear'><img src='../images/merchant_logos/worldsoccershop.jpg'></a>
  <a href='http://www.worldrugbyshop.com/' title='rugby jerseys, rugby shirts, rugby boots, balls & equipment'><img src='../images/merchant_logos/worldrugbyshop.jpg'></a>
  <a href='http://www.armaniexchange.com/home.do' title='youthful fashion label created by Italian designer Giorgio Armani'><img src='../images/merchant_logos/ax.jpg'></a>
  <a href='http://www.bathandbodyworks.com/home/index.jsp' title='body care, home fragrance, beauty & gifts'><img src='../images/merchant_logos/bbw.png'></a>
  <a href='http://www.motherhood.com/' title='maternity clothes'><img src='../images/merchant_logos/motherhood.gif'></a>
  <a href='http://www.barneys.com/' title='luxury designer handbags, shoes & clothing'><img src='../images/merchant_logos/barneys.jpg'></a>
  <a href='http://www.gap.com/' title='clothes for women, men, maternity, baby, & kids'><img src='../images/merchant_logos/gap.gif'></a>
  <a href='http://oldnavy.gap.com/' title='clothes for women, men, kids & baby'><img src='../images/merchant_logos/oldnavy.gif'></a>
  <a href='http://bananarepublic.gap.com/' title='apparel, handbags, shoes & accessories for women and men'><img src='../images/merchant_logos/bananarepublic.gif'></a>
  <a href='http://www.drugstore.com/' title='prescription drugs, health & beauty products'><img src='../images/merchant_logos/drugstore.gif'></a>
  <a href='http://www.beauty.com/' title='bareMinerals, Origins, Urban Decay, NARS & more beauty products'><img src='../images/merchant_logos/beauty.gif'></a>
  <a href='http://www.sephora.com/' title='makeup, fragrance & skincare'><img src='../images/merchant_logos/sephora.gif'></a>
  <a href='http://www.davidsbridal.com/Browse_Buy-Online' title='wedding dresses & prom dresses'><img src='../images/merchant_logos/davids_bridal.gif'></a>
  <a href='http://www.familychristian.com/' title='America&#39;s leading Christian book store'><img src='../images/merchant_logos/familychristian.png'></a>
  <a href='http://www.toysrus.com/shop/index.jsp' title='toys, games, & more'><img src='../images/merchant_logos/toysrus.gif'></a>



</div>



<div id='bottom-bar'>
    <span>&copy;2013 VituMob</span>
    <span><a href='http://www.vitumob.com/faq'>FAQ</a></span>
    <span><a href='http://www.vitumob.com/privacy'>privacy</a></span>
    <span><a href='http://www.vitumob.com/returns'>returns</a></span>
</div>

</body>

</html>