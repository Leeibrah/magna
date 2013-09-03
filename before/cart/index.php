<?php
session_start();
include("../config.php");
$mode = $_REQUEST['mode'];

$subtotalusdfld = $_REQUEST['subtotal-usd-fld'];
$subtotalkshfld = $_REQUEST['subtotal-ksh-fld'];
$customsusdfld = $_REQUEST['customs-usd-fld'];
$customskshfld = $_REQUEST['customs-ksh-fld'];
$shippingusdfld = $_REQUEST['shipping-usd-fld'];
$shippingkshfld = $_REQUEST['shipping-ksh-fld'];
$vatusdfld = $_REQUEST['vat-usd-fld'];
$vatkshfld = $_REQUEST['vat-ksh-fld'];
$totalusdfld = $_REQUEST['total-usd-fld'];
$totalkshfld = $_REQUEST['total-ksh-fld'];
if(isset($mode) && $mode=="del")
{
	$del  = "delete from cart where id='".$_REQUEST['id']."'";
	mysql_query($del);
}

if(isset($_POST['submit']))
{
		$updcartdetail = "update cart_total set 
		sub_total_usd='".$subtotalusdfld."',
		sub_total_ksh='".$subtotalkshfld."',
		custom_import_fee_usd='$customsusdfld',
		custom_import_fee_ksh='$customskshfld',
		shipping_usd='$shippingusdfld',
		shipping_ksh='$shippingkshfld',
		vat_usd='$vatusdfld',
		vat_ksh='$vatkshfld',
		total_usd='$totalusdfld',
		total_ksh='$totalkshfld'
		where session_id='".session_id()."'";
		mysql_query($updcartdetail);
		//echo "<script>document.location.href='http://localhost/vitumob/VituMob_code_and_other_files/checkout'<\/script>";
		echo "<script>document.location.href='http://www.vitumob.com/checkout/'</script>";
}

if(isset($_POST['updateqty']))
{
	if(is_array($_REQUEST['qty']))
	{
		foreach($_REQUEST['qty'] as $key=>$val)
		{
			$upd_produt = "UPDATE cart SET quantity='".$val."' WHERE id='".$key."'";
			mysql_query($upd_produt);
			
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>VituMob: kila kitu kila siku</title>
    <meta charset='utf-8'>
    <link rel='stylesheet' href="../static/vitumob.css">
    <link rel='chrome-webstore-item' href="https://chrome.google.com/webstore/detail/ndfakojkecjkdibnkcoljkdbkbkoloik">
    
</head>

<body>

<?php
include '../common_functions.php';

/*$bundle=array ("items" => array( array("id" => "SKU5086937", "id2" => "ci583333004134", "image" => "http://images.bestbuy.com/BestBuy_US/images/products/5086/5086937_rc.jpg", "link" => "http://www.bestbuy.com/site/Pioneer---5-1/4%26%2334%3B-Floor-Speaker-(Each)/5086937.p?skuId=5086937&productCategoryId=abcat0205003&id=1218610014331", "name" => "Amazon Kindle PowerFast for Accelerated Charging","model" => "Model: SP-FS52","quantity" => "1","price" => 19.99,"designer" =>"Monique Lhuillier","color"=>"Green","size"=>"4" ), array("id" => "SKU5720056", "id2" => "ci583333004108", "image" => "http://images.bestbuy.com/BestBuy_US/images/products/5720/5720056_sc.jpg", "link" => "http://www.bestbuy.com/site/LeapFrog---LeapPad2-Explorer-Tablet-with-4GB-Memory---Green/5720056.p?skuId=5720056&productCategoryId=pcmcat209000050008&id=1218688219600", "name" => "V-MODA Crossfade LP Over-Ear Noise-Isolating Metal Headphone (White Pearl)","model" => "Model: 32610","quantity" => "1","price" => 115.87,"package"=>"DTGPREM ( $7.00)","printondemand"=>"CONCACAF Gold Cup 2013 Champions V-Neck T-Shirt (Heather Red)","front.logo"=>"DTGCGC0374","custombacknumber"=>"78","custombackname"=>"Rado","size"=>"4" )),"host"=>"amazon.com");
*/


// unpack bundle from the extension:
$str_encoded = $_POST["bundle"];
$decoded_bundle = urldecode($str_encoded);
$bundle = json_decode($decoded_bundle, TRUE);
/*echo "<pre>";
 print_r($bundle);*/


?>

<?php include("../header.php")?>

<div id='header'><a href='http://www.vitumob.com/beta'><img id='logo' src='../images/logo.png'></a></div>

<div id='main' class=''>

<h1 class='cart'>Cart</h1>

<table id='cart' data-exchange-rate='<?php echo exchRate($RATE_ADJUST); ?>'>

  <!--  <thead>
        <tr>
            <td width='15%'></td>
            <td width='55%'></td>
            <td width='10%' class='price'>Price&nbsp;USD</td>
            <td width='10%' class='price'>Price&nbsp;KSh</td>
            <td width='10%'>Quantity</td>
        </tr>
    </thead>-->

<?php
$exchange_rate=exchRate($RATE_ADJUST);
	echo "<tbody data-merchant='".$bundle["host"]."'>";

	$merchants_string = file_get_contents("http://www.vitumob.com/static/merchants.json");
	$merchants_json = json_decode($merchants_string, true);

/* Debugging stuff (these statements work:)
	echo "<br><br>MERCHANTS JSON DECODED:<br>";
	print_r ($merchants_json);

echo "HOST1: ".$temp_host."<br>";
echo "<br>Print Cell Hut host: ";
echo $merchants_json[$temp_host]['host'];
echo "<br>Print Cell Hut name: ";
echo $merchants_json[$temp_host]['name'];
echo "<br>Print Cell Hut cart: ";
echo $merchants_json[$temp_host]['cart'];
echo "<br><br>Print item number: ";
echo $bundle["items"][0]["id"];
*/

$isfirst = true;  // first iteration through foreach loop returns 'Array' as hostname

foreach($bundle as $host_name) {
	if ($isfirst) {
		$isfirst = false;
		continue;
	}

/*     PRINT HOST NAME     */

	/*$temp_host=$bundle["host"];
	echo "<tr class='merchant'><th colspan='5'><a href='".$merchants_json[$temp_host]['cart']."'>".$merchants_json[$temp_host]['name']."</a></th></tr>";
*/

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



$price_usd=$bundle["items"][$i]["price"]*$bundle["items"][$i]["quantity"];
echo $price_kes=$price_usd*$exchange_rate;

$pricekes_1 = $bundle["items"][$i]["price"]*$exchange_rate;

echo "<td class='price'>$".$price_usd."</td>";
echo "<td class='price' >".number_format($price_kes,0)."</td>";
echo "<td class='quantity'><div><input type='text' value='".$bundle["items"][$i]["quantity"]."'><span class='delete'>delete</span></div></td>";
		if(!isset($mode) && !isset($_POST['updateqty']))
		{
				$sqlsel = "select * from cart where item_id='".$bundle["items"][$i]["id"]."' and session_id='".session_id()."' and status='0'";
				$resel = mysql_query($sqlsel);
				if(mysql_num_rows($resel)>0)
				{
					$upd = "update cart set 
					name='".addslashes($bundle["items"][$i]["name"])."',
					name2='".addslashes($bundle["items"][$i]["name2"])."',
					link='".addslashes($bundle["items"][$i]["link"])."',
					image='".addslashes($bundle["items"][$i]["image"])."',
					quantity='".$bundle["items"][$i]["quantity"]."',
					designer='".addslashes($bundle["items"][$i]["designer"])."',
					color='".addslashes($bundle["items"][$i]["color"])."',
					size='".$bundle["items"][$i]["size"]."',
					package='".addslashes($bundle["items"][$i]["package"])."',
					printondemand='".addslashes($bundle["items"][$i]["printondemand"])."',
					front_logo='".addslashes($bundle["items"][$i]["front.logo"])."',
					custombacknumber='".addslashes($bundle["items"][$i]["custombacknumber"])."',
					custombackname='".addslashes($bundle["items"][$i]["custombackname"])."',
					item_id='".$bundle["items"][$i]["id"]."',
					item_price_usd='".$bundle["items"][$i]["price"]."',
					item_price_ksh='".$price_kes."',host_name='".$bundle["host"]."',
					session_id='".session_id()."' where item_id='".$bundle["items"][$i]["id"]."' and session_id='".session_id()."'";
					mysql_query($upd);
				}
				else
				{
					$ins = "insert into cart set 
					name='".addslashes($bundle["items"][$i]["name"])."',
					name2='".addslashes($bundle["items"][$i]["name2"])."',
					link='".addslashes($bundle["items"][$i]["link"])."',
					image='".addslashes($bundle["items"][$i]["image"])."',
					quantity='".$bundle["items"][$i]["quantity"]."',
					designer='".$bundle["items"][$i]["designer"]."',
					color='".addslashes($bundle["items"][$i]["color"])."',
					size='".$bundle["items"][$i]["size"]."',
					package='".addslashes($bundle["items"][$i]["package"])."',
					printondemand='".addslashes($bundle["items"][$i]["printondemand"])."',
					front_logo='".addslashes($bundle["items"][$i]["front.logo"])."',
					custombacknumber='".$bundle["items"][$i]["custombacknumber"]."',
					custombackname='".addslashes($bundle["items"][$i]["custombackname"])."',
					item_id='".$bundle["items"][$i]["id"]."',
					item_price_usd='".$bundle["items"][$i]["price"]."',
					item_price_ksh='".$price_kes."',host_name='".$bundle["host"]."',
					session_id='".session_id()."'
					";
					mysql_query($ins);
				}
		}
   }
echo "</tr>";


}
$sqlsel1 = "select * from cart_total where session_id='".session_id()."'";
$resel1 = mysql_query($sqlsel1);
if(mysql_num_rows($resel1)<1)
{
	$sqlinscardtotal = "insert into cart_total set session_id='".session_id()."'";
	mysql_query($sqlinscardtotal);
}

?>
  <table id='cart' data-exchange-rate='<?php echo exchRate($RATE_ADJUST); ?>'>
<?php

$i=0;

$sqlord = "select link,host_name from cart where session_id='".session_id()."' and status='0' group by host_name order by host_name asc";
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
	<th colspan='5'><a href='<?php echo stripslashes($roword['link'])?>' style="color:#027FC2"><?php echo stripslashes($roword['host_name']);?></a></th>
 </tr>
	<?php

	$sql = "select * from cart where session_id='".session_id()."' and status='0' and host_name='".$roword["host_name"]."'";
 $re = mysql_query($sql) or die(mysql_error());
 	while($row = mysql_fetch_array($re))
	{
		$price_usd=$row['item_price_usd']*$row["quantity"];
		
		$sbtotal+=$price_usd;
		$price_ksh=$price_usd*$exchange_rate;
		
		$subtotal_ksh+=$price_ksh;


		
		
		$hostArr = array("bestbuy.com","cellhut.com","apple.com");

		if(in_array($row["host_name"],$hostArr) || (strpos(strtolower($row['name']),"phone") || strpos(strtolower($row['name']),"computer") || strpos(strtolower($row['name']),"printer") || strpos(strtolower($row['name']),"camera") || strpos(strtolower($row['name']),"electronic") || strpos(strtolower($row['name']),"camcorder") || strpos(strtolower($row['name']),"kindle")  || strpos(strtolower($row['name']),"ipad") || strpos(strtolower($row['name2']),"phone") || strpos(strtolower($row['name2']),"computer") || strpos(strtolower($row['name2']),"printer") || strpos(strtolower($row['name2']),"camera") || strpos(strtolower($row['name2']),"electronic") || strpos(strtolower($row['name2']),"camcorder") || strpos(strtolower($row['name2']),"kindle")  || strpos(strtolower($row['name2']),"ipad")))
		{
			$customrate = 2.25;
			
			$customamout = $price_usd * $customrate/100;
			if($customamout>12)
			{
				$customs += $price_usd * $customrate/100;	
				$vat = 0;	
			}
			else
			{
				$customs += 12;	
				$vat = 0;	
			}
		}
		else if($row["host_name"]=="autopartswarehouse.com")
		{
			$customrate = 10.25;
			$customs += $price_usd * $customrate/100;	
			$vat += $price_usd * 16/100;	
						
		}
		else
		{
			$customrate = 25.625;
		
			$customs += $price_usd * $customrate/100;	
			$vat += $price_usd * 16/100;	
		}
		$customrate_ksh = $customs*$exchange_rate;
		$vat_ksh = $vat*$exchange_rate;
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
 <td class='price'>$<?php echo number_format($price_usd, 2, '.', '')?></td>
 <td class='price' ><?php echo number_format($price_ksh)?></td>
 <td colspan="2" class='quantity'><div><input type="text" name="qty[<?php echo $row['id']?>]" value="<?php echo $row['quantity']?>"><br>
<a href="index.php?mode=del&id=<?php echo $row['id'];?>"><span class=''>Delete</span></a></div>
   </tbody></td>        
    <?php
		$i++;
	}
	
	$shipping = ($sbtotal + $customrate) * 0.12;
	if ($shipping) {
		$minShipping = 10 + (5 * $i);
		if ($shipping < $minShipping) $shipping = $minShipping;
	}
	$shipping_ksh = $shipping*$exchange_rate;
	
	$total = (($sbtotal + $customs + $shipping + $vat) * 100) / 100;
	$total_ksh = $total * $exchange_rate;
 }?>

 <tr>
	  <td colspan="5" class="label"><input type="submit" name="updateqty" value="Update Cart" class="blue button">&nbsp;</td>
    </tr> 


<input type="hidden" name="mode" value="<?php echo $mode?>">
  <input type="hidden" name="subtotal-usd-fld" id="subtotal-usd-fld" value="$<?php echo number_format($sbtotal, 2, '.', '');?>">
  <input type="hidden" name="subtotal-ksh-fld" id="subtotal-ksh-fld" value="<?php echo number_format($subtotal_ksh);?>">
  
  <input type="hidden" name="customs-usd-fld" id="customs-usd-fld" value="$<?php echo number_format($customs, 2, '.', '');?>">
  <input type="hidden" name="customs-ksh-fld" id="customs-ksh-fld" value="<?php echo number_format($customrate_ksh);?>">
    
    
   <input type="hidden" name="shipping-usd-fld" id="shipping-usd-fld" value="$<?php echo number_format($shipping, 2, '.', '');?>">
  <input type="hidden" name="shipping-ksh-fld" id="shipping-ksh-fld" value="<?php echo number_format($shipping_ksh);?>">
  
  <input type="hidden" name="vat-usd-fld" id="vat-usd-fld" value="$<?php echo number_format($vat, 2, '.', '');?>">
  <input type="hidden" name="vat-ksh-fld" id="vat-ksh-fld" value="<?php echo number_format($vat_ksh);?>">
  
  <input type="hidden" name="total-usd-fld" id="total-usd-fld" value="$<?php echo number_format($total, 2, '.', '');?>">
  <input type="hidden" name="total-ksh-fld" id="total-ksh-fld" value="<?php echo number_format($total_ksh);?>"> 
  <tfoot>
 
   <tr><td></td><td class='label'>Subtotal</td><td  class='price'>$<?php echo number_format($sbtotal, 2, '.', '');?></td><td  class='price'><?php echo number_format($subtotal_ksh);?></td><td></td></tr>
    <tr><td></td><td class='label'>Customs &amp; Import Fees</td><td class='price' id="customfee-usd">$<?php echo number_format($customs, 2, '.', '');?></td><td class='price' id="customfee-ksh"><?php echo number_format($customrate_ksh);?></td></tr>
    <tr><td></td><td class='label'>Shipping &amp; Handling</td><td class='price' id="shippingfee-usd">$<?php echo number_format($shipping, 2, '.', '');?></td><td class='price' id="shipping-ksh"><?php echo number_format($shipping_ksh);?></td></tr>
    <tr><td></td><td class='label'>VAT</td><td class='price' id="vatfee-usd">$<?php echo number_format($vat, 2, '.', '');?></td><td class='price' id="vat-ksh"><?php echo number_format($vat_ksh);?></td></tr>
    <tr><td></td><td class='label'>Total</td><td class='price' id="totalfee-usd">$<?php echo number_format($total, 2, '.', '');?></td><td class='price' id="total-ksh"><?php echo number_format($total_ksh);?></td></tr>
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
<?php }?>
</table>


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