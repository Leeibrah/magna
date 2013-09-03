<?php echo "AAAAAAAAAAAAAAAAAAAA";?>
<!DOCTYPE HTML>
<html>

<head>
    <title>VituMob: kila kitu kila siku</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
       <link rel='stylesheet' href="../static/vitumob.css">
<link rel="shortcut icon" href="../favicon.ico">
</head>

<body>

<div id='header'>
    <img id='logo' src='../images/logo.png'>
</div>


<?php
include '../common_functions.php';



// unpack bundle from the extension:
$str_encoded = $_POST["bundle"];
$decoded_bundle = urldecode($str_encoded);
$bundle = json_decode($decoded_bundle, TRUE);
// print_r($bundle);

?>

<div id='nav-bar'>

<span><a href='/orders'>orders</a></span>

<span><a href='/contact'>contact</a></span>

</div>

<div id='main' class=''>

<h1 class='cart'>Cart</h1>

<table id='cart' data-exchange-rate='<?php echo exchRate($RATE_ADJUST); ?>'>

    <thead>
        <tr>
            <td width='15%'></td>
            <td width='55%'></td>
            <td width='10%' class='price'>Price&nbsp;USD</td>
            <td width='10%' class='price'>Price&nbsp;KSh</td>
            <td width='10%'>Quantity</td>
        </tr>
    </thead>

<?php
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

echo "<pre>";
print_r($bundle);
echo "Hello";


foreach($bundle as $host_name) {
	if ($isfirst) {
		$isfirst = false;
		continue;
	}

/*     PRINT HOST NAME     */

	$temp_host=$bundle["host"];
	echo "<tr class='merchant'><th colspan='5'><a href='".$merchants_json[$temp_host]['cart']."'>".$merchants_json[$temp_host]['name']."</a></th></tr>";


	$max = sizeof($bundle["items"]);
	for ($i=0; $i<$max; $i++) {

/*     PRINT EACH PRODUCT     */
echo "<tr class='item' data-item-id='".$bundle["items"][$i]["id"];
echo "'data-quantity='".$bundle["items"][$i]["quantity"];
echo "' data-price-usd='".$bundle["items"][$i]["price"];
echo "' data-customs='0.25'>";

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

$exchange_rate=exchRate($RATE_ADJUST);

$price_usd=$bundle["items"][$i]["price"]*$bundle["items"][$i]["quantity"];
$price_kes=$price_usd*$exchange_rate;

echo "<td class='price'>$".$price_usd."</td>";
echo "<td class='price' >".number_format($price_kes,0)."</td>";
echo "<td class='quantity'><div><input type='text' value='".$bundle["items"][$i]["quantity"]."'><span class='delete'>delete</span></div></td>";

   }
echo "</tr>";


}


?>
        

    </tbody>



  <tfoot>
    <tr><td></td><td class='label'>Subtotal</td><td id='subtotal-usd' class='price'></td><td id='subtotal-ksh' class='price'></td><td></td></tr>
    <tr><td></td><td class='label'>Customs &amp; Import Fees</td><td id='customs-usd' class='price'></td><td id='customs-ksh' class='price'></td></tr>
    <tr><td></td><td class='label'>Shipping &amp; Handling</td><td id='shipping-usd' class='price'></td><td id='shipping-ksh' class='price'></td></tr>
    <tr><td></td><td class='label'>VAT</td><td id='vat-usd' class='price'></td><td id='vat-ksh' class='price'></td></tr>
    <tr><td></td><td class='label'>Total</td><td id='total-usd' class='price'></td><td id='total-ksh' class='price'></td></tr>
    <tr><td></td><td></td><td colspan='2'><a href='https://www.vitumob.com/checkout' class='blue button'>Checkout</a></td></tr>
  </tfoot>



</table>

<script src="../static/cart.js"></script>


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