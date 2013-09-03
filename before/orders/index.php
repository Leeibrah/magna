<?php 
session_start();
include("../config.php");

if(isset($_POST['requestemail']))
{
	$sqlord = "select link,host_name from cart inner join orders on cart.order_id=orders.id where email='".$_REQUEST['email']."' and status='1' group by host_name order by host_name asc";
	 $reord = mysql_query($sqlord);
	 if(mysql_num_rows($reord)>0)
	 {
		$to= $_REQUEST['email'];
		$subject = 'Vitumob - Requested order summary';
		$message .= '
		<div  align="center"><a href="http://www.vitumob.com/beta"><img id="logo" src="http://www.vitumob.com/images/logo.png" width="220"></a></div>
		
		<table id="order-status" align="center">';

	$sqlflag = "select * from cart inner join orders on cart.order_id=orders.id where email='".$_REQUEST['email']."' and status='1' group by host_name order by host_name asc";
	$reflag = mysql_query($sqlflag);
	$rowflag = mysql_fetch_array($reflag);

	if($rowflag['arrived']=="0000-00-00 00:00:00")
	{
		$kenya = "http://www.vitumob.com/images/kenya-dim.png";
		$arrow = "http://www.vitumob.com/images/arrow_orange-dim3.png";
		$home = "http://www.vitumob.com/images/home-dim2.png";
	}
	else
	{
		$kenya = "http://www.vitumob.com/images/kenya.png";
		$arrow = "http://www.vitumob.com/images/arrow_orange-dim3.png";
		$home = "http://www.vitumob.com/images/home-dim2.png";
	}
	if($rowflag['delivered']!="0000-00-00 00:00:00")
	{
		$kenya = "http://www.vitumob.com/images/kenya.png";
		$arrow = "http://www.vitumob.com/images/arrow_orange.png";
		$home = "http://www.vitumob.com/images/home.png";
	}

   $message .= ' <tr>
        <td><img src="http://www.vitumob.com/images/plane.png"></td>
        <td><img src="http://www.vitumob.com/images/arrow_orange.png"></td>
        <td class="not-yet"><img src="'.$kenya.'"></td>
        <td class="not-yet"><img src="'.$arrow.'"></td>
        <td class="not-yet"><img src="'.$home.'"></td>
    </tr>

</table>

<table id="cart">';
	
   $message .= ' <thead>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td class="price">&nbsp;</td>
          <td class="price">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="15%" style="color:gray"><b>Items</b></td>
            <td width="55%"></td>
          
          <td width="10%" class="price" style="color:gray"><b>KSh</b></td>
          <td width="10%" colspan="2" style="color:gray"><b>Quantity</b></td>
        </tr>
		<tr><td colspan="5" style="border-top:thin solid gray">&nbsp;</td></tr>
    </thead>

<tbody>
<tr class="merchant">
	<th colspan="5">&nbsp;</th>
 </tr>
 <form name="form1" action="" method="post">';
 
 	while($roword = mysql_fetch_array($reord))
	{
	
	
	 /* $message .= ' <tr class="">
	<th colspan="5" align="left"><a href="'.$roword['link'].'" style="color:#027FC2">'.$roword['host_name'].'</a></th>
 </tr>';*/
	$sql = "select *,cart.name as cartname from cart inner join cart_total on cart.session_id=cart_total.session_id left join orders on cart.order_id=orders.id where email='".$_REQUEST['email']."' and status='1' and host_name='".$roword["host_name"]."'";
 $re = mysql_query($sql) or die(mysql_error());
 	while($row = mysql_fetch_array($re))
	{
		
		
		
		  $message .= ' <tr class="item">
 <td class="image"><img src="'.$row['image'].'"></td>
 <td class="name">
 <span><a href="'.stripslashes($row['link']).'" style="color:gray; text-decoration:none">'.stripslashes($row['cartname']).'</a></span>';
  if(!empty($row['color']) || !empty($row['size']))
  {
  	$message.="<br>";
  }
 $message .= ' <span style="font-size:12px color:gray">';
 if(!empty($row['name2']))
 {
 	  $message .= ' <br>'.stripslashes($row['name2']);
 }
 if(!empty($row['color']))
 {
 	  $message .= 'Color : '.stripslashes($row['color']);
 }
 if(!empty($row['size']))
 {
 	if(!empty($row['color']))
	{
		$message.= ",&nbsp;";
	}
 	$message .= 'Size : '.stripslashes($row['size']);
 }
 if(!empty($row['designer']))
 {
 	  $message .= " <br>Designer : ".stripslashes($row['designer']);
 }
 
 if(!empty($row['package']))
 {
 	  $message .= ' <br>Package : '.stripslashes($row['package']);
 }
 if(!empty($row['printondemand']))
 {
 	  $message .= ' <br>Print on demand : '.stripslashes($row['printondemand']);
 }
 if(!empty($row['front_logo']))
 {
 	  $message .= ' <br>Front Logo : '.stripslashes($row['front_logo']);
 }
 if(!empty($row['custombacknumber']))
 {
 	  $message .= ' <br>Custom Back Number : '.stripslashes($row['custombacknumber']);
 }
 if(!empty($row['custombackname']))
 {
 	  $message .= ' <br>Custom Back Name : '.stripslashes($row['custombackname']);
 }
 $price_ksh = $row['item_price_ksh']*  $row['quantity'] ;
   $message .= ' </span>
 <br>
 <td class="price" style="color:gray">'.number_format($price_ksh).'</td>
 <td colspan="2" class="quantity"><div style="color:gray">'.$row['quantity'].'</div>
   </tbody></td>';        
		
		$subtotal_ksh=$row['sub_total_ksh'];
		
		$customrate_ksh = $row['custom_import_fee_ksh'];
		$vat_ksh = $row['vat_ksh'];
		
		$shipping_ksh = $row['shipping_ksh'];
		$total_ksh = $row['total_ksh'];
	}
	

	
 }
 $message.='<tfoot>
 <tr><td colspan="5" style="border-top:medium double gray">&nbsp;</td></tr>
   <tr><td>&nbsp;</td><td class="label" align="right">Subtotal&nbsp;</td>
     <td  class="price">'.$subtotal_ksh.'</td>
     <td  class="price">&nbsp;</td><td>&nbsp;</td></tr>
    <tr><td></td><td class="label" align="right">Customs &amp; Import Fees&nbsp;</td>
      <td class="price" id="customfee-usd">'.$customrate_ksh.'</td><td class="price" id="customfee-ksh">&nbsp;</td></tr>
    <tr><td></td><td class="label" align="right">Shipping &amp; Handling&nbsp;</td>
      <td class="price" id="shippingfee-usd">'.$shipping_ksh.'</td><td class="price" id="shipping-ksh">&nbsp;</td></tr>
    <tr><td></td><td class="label" align="right">VAT&nbsp;</td>
      <td class="price" id="vatfee-usd">'.$vat_ksh.'</td><td class="price" id="vat-ksh">&nbsp;</td></tr>
    <tr><td></td><td class="label" align="right">Total&nbsp;</td>
      <td class="price" id="totalfee-usd">'.$total_ksh.'</td><td class="price" id="total-ksh">&nbsp;</td></tr>
      
       <tr><td></td><td class="label"></td>
      <td class="pricesa" id="vatfee-usdsas"></td><td class="pricesa" id="vat-kshsas">&nbsp;</td></tr>
	  
	  
	   <tr><td align="left">Thanks & Regards
	   <br>
	   <a href="http://www.vitumob.com/">Vitumob</a>
	   </td></tr>
      
   </tfoot>
</form>
</table>
';
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Vitumob <contact@vitumob.com>' . "\r\n";
		
		if(@mail($to, $subject, $message, $headers,"-f contact@vitumob.com"))
		{
			$_SESSION['confirmation'] = "Order summary has been sent to your email.";
			echo "<script>document.location.href='index.php'</script>";
		}
	}
	else
	{
		$err = "No any order has been purchased by this email id.";
	}	
	
}

?>
<!DOCTYPE HTML>
<html>

<head>
    <title>VituMob: kila kitu kila siku</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' href="../static/vitumob.css">
<link rel="shortcut icon" href="../favicon.ico">
 
    <style>

    #main { font-size: 14pt }
    form { text-align: center }

    input { font-size: 12pt; margin-right: 12pt }
    #email-phone, #email { width: 256pt }
    input#order-id { width: 48pt }


    table.order { min-width: 80%; border-spacing: 0 }
    table.order > tbody > tr:first-child > th { border-top: thin solid gray; padding-top: 12pt }
    table.order > tfoot > tr:first-child > td { border-top: medium double gray; padding-top: 12pt }

</style>
</head>

<body>

<div id='header'>
    <img id='logo' src='../images/logo.png'>
</div>



<?php include("../header.php")?>

<div id='main' class=''>


<h1>Orders</h1>
<?php
if(isset($_SESSION['confirmation']))
{
	echo "<span style='color:#FF0000'>".$_SESSION['confirmation']."</span>";
}
if(isset($err))
{
	echo "<span style='color:#FF0000'>".$err."</span>";
}
if(!isset($_POST['requestemail']))
{
	unset($_SESSION['confirmation']);
}
?>
<p>To check the status of an order, enter your email address or phone number and your order number:</p>

<form id='search' name="ordersearch" action="order_detail.php" method="get">
    <label for='email-phone'>Email/phone:</label> <input id='email-phone' name='email' type='text' required title='email address or phone number' placeholder='email address or phone number' autofocus>
    <label for='order-id'>Order #</label> <input id='order-id' name='id' type='text' required title='order number' placeholder='' pattern='[0-9]+'>
    <input type='submit' value='View Order' name="vieworder" class='small blue'>
</form>


<p style='margin-top: 48pt'>Or to receive a summary of your orders via email, enter your address below:</p>

<form action='' method='POST' name="requestmailform">
    <label for='email'>Email: </label><input id='email' name='email' type='email' required title='email address' placeholder='email address'>
    <input type='submit' value='Request Email' name="requestemail" class='small blue'>
</form>

<!--<script>
    var emailInput = document.getElementById('email-phone');
    var orderIdInput = document.getElementById('order-id');
    document.getElementById('search').addEventListener('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.location = "/orders/" + emailInput.value + "/" + orderIdInput.value;
    }, false);
</script>-->


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