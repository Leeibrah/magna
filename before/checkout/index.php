<?php 
session_start();
include("../config.php");
$sqlsel = "select * from cart_total where session_id='".session_id()."'";
$resel = mysql_query($sqlsel);
$rowtotal = mysql_fetch_array($resel);


$name = addslashes($_REQUEST['name']);
$email = addslashes($_REQUEST['email']);
$phone = $_REQUEST['phone'];
$city = addslashes($_REQUEST['city']);
$neighbourhood = addslashes($_REQUEST['neighbourhood']);
$payment_type = $_REQUEST['payment_type'];
$Ecom_Payment_Card_Number = $_REQUEST['Ecom_Payment_Card_Number'];
$Ecom_Payment_Card_ExpDate_Month = $_REQUEST['Ecom_Payment_Card_ExpDate_Month'];
$Ecom_Payment_Card_ExpDate_Year = $_REQUEST['Ecom_Payment_Card_ExpDate_Year'];

$expdate = $Ecom_Payment_Card_ExpDate_Month."/".$Ecom_Payment_Card_ExpDate_Year;

$namearr = explode(" ",$name);
$fname = $namearr[0];
$lname = $namearr[1];

if(isset($_POST['submitorder']))
{
	$insorder = "insert into orders set name='$name',email='$email',phone='$phone',city='$city',neighbourhood='$neighbourhood',payment_type='$payment_type',credit_number='$Ecom_Payment_Card_Number',expiry_date='$expdate',session_id='".session_id()."',ipAddress='".$_SERVER['REMOTE_ADDR']."'";
	
	mysql_query($insorder);
	$orderid = mysql_insert_id();
	$updcart = "update cart set order_id='$orderid' where session_id='".session_id()."' and order_id='0'";
	mysql_query($updcart);
	if($payment_type=="m-pesa")
	{
		echo "<script>document.location.href='http://www.vitumob.com/mpesa.php?orderid=".$orderid."'</script>";
		//echo "<script>document.location.href='http://localhost/vitumob/VituMob_code_and_other_files/mpesa.php?orderid=".$orderid."'<\/script>";
	}
	else
	{
		echo "<form name='creditformiveriform' action='https://backoffice.host.iveri.com/Lite/Transactions/New/Authorise.aspx' method='post'>
				 <input type='hidden' id='Lite_Order_Amount' name='Lite_Order_Amount' value='".str_replace("$","",$rowtotal['total_usd'])."'>
				 <input type='hidden' id='Lite_Order_Terminal' name='Lite_Order_Terminal' value='Web'>
				<input type='hidden' id='Lite_Order_AuthorisationCode' name='Lite_Order_AuthorisationCode' value=''>
				<input type='hidden' id='Lite_Order_BudgetPeriod' name='Lite_Order_BudgetPeriod' value='0'>
				<input type='hidden' id='Lite_Website_TextColor' name='Lite_Website_TextColor' value='#ffffff'>
				<input type='hidden' id='Lite_Website_BGColor' name='Lite_Website_BGColor' value='#86001B'>
				<input type='hidden' id='Lite_ConsumerOrderID_PreFix' name='Lite_ConsumerOrderID_PreFix' value='".$orderid."'>
				<input type='hidden' id='Lite_On_Error_Resume_Next' name='Lite_On_Error_Resume_Next' value='True'>
				<input type='hidden' id='Ecom_BillTo_Postal_Name_First' name='Ecom_BillTo_Postal_Name_First' value='".$fname."'>
				<input type='hidden' id='Ecom_BillTo_Postal_Name_Last' name='Ecom_BillTo_Postal_Name_Last' value='".$lname."'>
				<input type='hidden' id='Ecom_ShipTo_Online_Email' name='Ecom_ShipTo_Online_Email' value='".$email."'>
				<input type='hidden' id='Ecom_ShipTo_Telecom_Phone_Number' name='Ecom_ShipTo_Telecom_Phone_Number' value='".$phone."'>
				<input type='hidden' id='Ecom_ShipTo_Postal_City' name='Ecom_ShipTo_Postal_City' value='".$city."'>
				<input type='hidden' id='Ecom_Payment_Card_Type' name='Ecom_Payment_Card_Type' value=''>
				<input type='hidden' id='Ecom_Payment_Card_Number' name='Ecom_Payment_Card_Number' value='".$Ecom_Payment_Card_Number."'>
				<input type='hidden' id='Ecom_Payment_Card_ExpDate_Month' name='Ecom_Payment_Card_ExpDate_Month' value='".$Ecom_Payment_Card_ExpDate_Month."'>
				<input type='hidden' id='Ecom_Payment_Card_ExpDate_Year' name='Ecom_Payment_Card_ExpDate_Year' value='".$Ecom_Payment_Card_ExpDate_Year."'>";
				$i=1;
				$sqlproduct = "select * from cart where session_id='".session_id()."' and status='0'";
				$reproduct = mysql_query($sqlproduct);
				while($rowProduct = mysql_fetch_array($reproduct))
				{
					echo "<input type='hidden' id='Lite_Order_LineItems_Product_".$i."' name='Lite_Order_LineItems_Product_".$i."' value='".$rowProduct['name']."'>
					<input type='hidden' id='Lite_Order_LineItems_Quantity_".$i."' name='Lite_Order_LineItems_Quantity_".$i."' value='".$rowProduct['quantity']."'>
					<input type='hidden' id='Lite_Order_LineItems_Amount_".$i."' name='Lite_Order_LineItems_Amount_".$i."' value='".$rowProduct['item_price_usd']."'>";
				$i++;
				}
				
				
				
			echo "<input type='hidden' ID='Lite_Website_Successful_url' NAME='Lite_Website_Successful_url' VALUE='http://localhost/vitumob/VituMob_code_and_other_files/order_status.php?orderid=".$orderid."'>
			<input type='hidden' ID='Lite_Website_Fail_url' NAME='Lite_Website_Fail_url' VALUE='http://www.vitumob.com/fail.php'>
			<input type='hidden' ID='Lite_Website_TryLater_url' NAME='Lite_Website_TryLater_url' VALUE='http://www.vitumob.com/trylater.php'>
			<input type='hidden' ID='Lite_Website_Error_url' NAME='Lite_Website_Error_url' VALUE='http://www.vitumob.com/error.php'>
			</form>
			<script>document.creditformiveriform.submit()</script>
		";
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
<script language="javascript" src="../jquery.js"></script>
</head>

<body>

<div id='header'>
    <img id='logo' src='../images/logo.png'>
</div>



<?php include("../header.php")?>

<div id='main' class=''>


<h1>Checkout</h1>



<h2>Total: <?php echo $rowtotal['total_ksh']?> KSh</h2>

<form id='checkout' method='POST' name="checkout">

<input type='hidden' name='total' value='<?php echo $rowtotal['total_ksh']?>'>
<input type='hidden' name='currency' value='KES'>



<h3>Contact Information:</h3>

<div><label for='name'>Name:</label><input type='text' id='name' name='name' required title='FirstName Surname' placeholder='full name' pattern='[A-z]+ [A-z ]+' autofocus value=''></div>

<div><label for='email'>Email:</label><input type='email' id='email' name='email' required placeholder='email address' value=''></div>

<div><label for='phone'>Phone:</label><input type='tel' id='phone' name='phone' required title='07##-######' placeholder='mobile telephone number' pattern='07\d{2}-?\d{3}-?\d{3}' value=''></div>


<h3>Delivery Information:</h3>

<div>
    <label for='city'>City:</label>
    <select id='city' name='city' title='city'>
        <option value='Nairobi'>Nairobi</option>
    </select>
</div>
    
<div>
    <label for='neighbourhood'>Neighbourhood:</label>
    <select id='neighbourhood' name='neighbourhood' required title='neighbourhood'>
        <option value=''></option>
        
        <option value='Adams'>Adams</option>
        
        <option value='Allsops'>Allsops</option>
        
        <option value='Avenue Park'>Avenue Park</option>
        
        <option value='Bahati'>Bahati</option>
        
        <option value='Baraka'>Baraka</option>
        
        <option value='Bomas'>Bomas</option>
        
        <option value='Buruburu'>Buruburu</option>
        
        <option value='Clayworks'>Clayworks</option>
        
        <option value='Community'>Community</option>
        
        <option value='Dandora'>Dandora</option>
        
        <option value='Donholm'>Donholm</option>
        
        <option value='Eastleigh'>Eastleigh</option>
        
        <option value='Embakasi'>Embakasi</option>
        
        <option value='Fedha'>Fedha</option>
        
        <option value='Garden Estate'>Garden Estate</option>
        
        <option value='Gigiri'>Gigiri</option>
        
        <option value='Githurai'>Githurai</option>
        
        <option value='Greenfields'>Greenfields</option>
        
        <option value='Harambee'>Harambee</option>
        
        <option value='Hazina'>Hazina</option>
        
        <option value='Highrise'>Highrise</option>
        
        <option value='Hurlingham'>Hurlingham</option>
        
        <option value='Huruma'>Huruma</option>
        
        <option value='Junction'>Junction</option>
        
        <option value='Kahawa Sukari'>Kahawa Sukari</option>
        
        <option value='Kahawa wendani'>Kahawa wendani</option>
        
        <option value='Kahawa West'>Kahawa West</option>
        
        <option value='Kasarani'>Kasarani</option>
        
        <option value='Kileleshwa'>Kileleshwa</option>
        
        <option value='Kilimani'>Kilimani</option>
        
        <option value='Kimathi'>Kimathi</option>
        
        <option value='Kwangware'>Kwangware</option>
        
        <option value='Langata'>Langata</option>
        
        <option value='Lavington'>Lavington</option>
        
        <option value='Muthaiga'>Muthaiga</option>
        
        <option value='Nairobi West'>Nairobi West</option>
        
        <option value='Ngara'>Ngara</option>
        
        <option value='Ngong'>Ngong</option>
        
        <option value='Ngumo'>Ngumo</option>
        
        <option value='Pangani'>Pangani</option>
        
        <option value='Parklands'>Parklands</option>
        
        <option value='Roysambo'>Roysambo</option>
        
        <option value='Ruiru'>Ruiru</option>
        
        <option value='Runda'>Runda</option>
        
        <option value='Santo/ Hunters'>Santo/ Hunters</option>
        
        <option value='South B'>South B</option>
        
        <option value='South C'>South C</option>
        
        <option value='Spring Valley'>Spring Valley</option>
        
        <option value='Survey'>Survey</option>
        
        <option value='Taasia'>Taasia</option>
        
        <option value='Thome'>Thome</option>
        
        <option value='Umoja'>Umoja</option>
        
        <option value='Westlands'>Westlands</option>
        
        <option value='Zimmerman'>Zimmerman</option>
        
        <option value='other'>other</option>
    </select>
</div>

<h3>Payment Information:</h3>


<div style='text-align: center'>

    <label>
        <input type='radio' id='m-pesa' name='payment_type' value='m-pesa' required>
        <img src='../images/m-pesa.jpg'>
    </label>


    <label>
        <input type='radio' id='credit-card' name='payment_type' value='credit card' required>
        <img src='../images/visa.png'>
        <img src='../images/mastercard.jpg'>
    </label>
</div>

<div id='cc-info' style='visibility: hidden'>
    <div>
        <label for='cc-num'>Number:</label>
        <input id='cc-num' name='Ecom_Payment_Card_Number' type='text' required title='credit card number' placeholder='credit card number' pattern='[0-9]{13,16}' disabled value=''>
    </div>
    <div>
        <label for='cc-exp-month'>Expires:</label>
        <select id='cc-exp-month' name='Ecom_Payment_Card_ExpDate_Month' required title='expiration month' disabled>
            <option value=''>month</option>
            <option value='01'>1</option>
            <option value='02'>2</option>
            <option value='03'>3</option>
            <option value='04'>4</option>
            <option value='05'>5</option>
            <option value='06'>6</option>
            <option value='07'>7</option>
            <option value='08'>8</option>
            <option value='09'>9</option>
            <option value='10'>10</option>
            <option value='11'>11</option>
            <option value='12'>12</option>
        </select>
        <select id='cc-exp-year' name='Ecom_Payment_Card_ExpDate_Year' required title='expiration year' disabled>
            <option value=''>year</option>
            <option value='2013'>2013</option>
            <option value='2014'>2014</option>
            <option value='2015'>2015</option>
            <option value='2016'>2016</option>
            <option value='2017'>2017</option>
            <option value='2018'>2018</option>
        </select>
    </div>
</div>

<div class='button-wrapper'><input type='submit' name="submitorder" class='blue' value='Submit Order'></div>


<input type="hidden" name="Lite_Merchant_ApplicationID" value="7ad6b430-0b38-4602-884d-f3e2f1310467">
<input type="hidden" id="iveri-lite-name-first" name="Ecom_BillTo_Postal_Name_First" value="First">
<input type="hidden" id="iveri-lite-name-last" name="Ecom_BillTo_Postal_Name_Last" value="Last">
<input type="hidden" id="iveri-lite-phone" name="Ecom_BillTo_Telecom_Phone_Number">
<input type="hidden" id="iveri-lite-email" name="Ecom_BillTo_Online_Email">
<input type="hidden" name="Lite_Order_Amount" value="664900">
<input type="hidden" name="Lite_Order_Terminal" value="Web">
<input type="hidden" name="Lite_ConsumerOrderID_PreFix" value="Vitu">
<input type="hidden" name="Lite_On_Error_Resume_Next" value="True">
<input type="hidden" name="Lite_Order_LineItems_Product_1" value="Subtotal">
<input type="hidden" name="Lite_Order_LineItems_Quantity_1" value="1">
<input type="hidden" name="Lite_Order_LineItems_Amount_1" value="664900">
<input type="hidden" name="Ecom_Payment_Card_Protocols" value="iVeri">
<input type="hidden" name="Lite_Version " value="2.0">
<input type="hidden" name="Ecom_ConsumerOrderID" value="AUTOGENERATE">
<input type="hidden" name="Ecom_TransactionComplete" value="False">
<input type="hidden" name="Lite_Website_Successful_url" value="https://www.vitumob.com/iverilite/success">
<input type="hidden" name="Lite_Website_Fail_url" value="https://www.vitumob.com/iverilite/failure">
<input type="hidden" name="Lite_Website_TryLater_url" value="https://www.vitumob.com/iverilite/trylater">
<input type="hidden" name="Lite_Website_Error_url" value="https://www.vitumob.com/iverilite/error">

</form>


<script>
var form = document.getElementById('checkout');
var ccInfo = document.getElementById('cc-info');
var ccNum = document.getElementById('cc-num');
var ccExpMonth = document.getElementById('cc-exp-month');
var ccExpYear = document.getElementById('cc-exp-year');


document.getElementById('m-pesa').addEventListener('click', function() {
	
   // form.setAttribute('action', "https://www.vitumob.com/checkout");
    ccInfo.style.visibility='hidden';
    ccNum.setAttribute('disabled');
    ccExpMonth.setAttribute('disabled');
    ccExpYear.setAttribute('disabled');
}, false);
document.getElementById('credit-card').addEventListener('click', function() {
   // form.setAttribute('action', "https://backoffice.host.iveri.com/Lite/Transactions/New/Authorise.aspx");
    ccNum.removeAttribute('disabled');
    ccExpMonth.removeAttribute('disabled');
    ccExpYear.removeAttribute('disabled');
    ccInfo.style.visibility='visible';
}, false);
form.addEventListener('submit', function() {
    var fullName = document.getElementById('name').value.trim();
    var firstSpaceIndex = fullName.indexOf(" ");
    if (firstSpaceIndex != -1) {
        document.getElementById('iveri-lite-name-first').value = fullName.substring(0, firstSpaceIndex);
        document.getElementById('iveri-lite-name-last').value = fullName.substring(firstSpaceIndex+1).trim();
    }
    document.getElementById('iveri-lite-phone').value = document.getElementById('phone').value;
    document.getElementById('iveri-lite-email').value = document.getElementById('email').value;
}, false);

</script>




</div>

<div id='footer'>
<hr>

<p style='margin-top: 36pt; color: dimgray'>Click any site below to shop</p>

  <a href='http://www.amazon.com/' title='electronics, apparel, computers, books, & DVDs'><img src='/images/merchant_logos/amazon.png'></a>
  <a href='http://store.apple.com/' title='iPad, iPhone, MacBook, iMac & Mac mini'><img src='/images/merchant_logos/apple.png'></a>
  <a href='http://www.cellhut.com/' title='unlocked cell phones: Motorola, Nokia, Sony Ericsson'><img src='/images/merchant_logos/cellhut.jpg'></a>
  <a href='http://www.macys.com/' title='fashion clothing & accessories'><img src='/images/merchant_logos/macys.gif'></a>
  <a href='http://www.bestbuy.com/' title='consumer electronics'><img src='/images/merchant_logos/bestbuy.png'></a>
  <a href='http://www.autopartswarehouse.com/' title='car parts & accessories'><img src='/images/merchant_logos/autopartswarehouse.png'></a>
  <a href='http://www.fragrancenet.com/' title='perfume, cologne & discount fragrances'><img src='/images/merchant_logos/fragrancenet.gif'></a>
  <a href='http://www.victoriassecret.com/' title='lingerie, women&#39;s clothing & accessories'><img src='/images/merchant_logos/victoriassectret.gif'></a>
  <a href='http://www.neimanmarcus.com/' title='designers Eileen Fisher, Tory Burch, Gucci, Christian Louboutin & more'><img src='/images/merchant_logos/neimanmarcus.png'></a>
  <a href='http://www.worldsoccershop.com/' title='official soccer jerseys, shirts, cleats, shoes, balls & gear'><img src='/images/merchant_logos/worldsoccershop.jpg'></a>
  <a href='http://www.worldrugbyshop.com/' title='rugby jerseys, rugby shirts, rugby boots, balls & equipment'><img src='/images/merchant_logos/worldrugbyshop.jpg'></a>
  <a href='http://www.armaniexchange.com/home.do' title='youthful fashion label created by Italian designer Giorgio Armani'><img src='/images/merchant_logos/ax.jpg'></a>
  <a href='http://www.bathandbodyworks.com/home/index.jsp' title='body care, home fragrance, beauty & gifts'><img src='/images/merchant_logos/bbw.png'></a>
  <a href='http://www.motherhood.com/' title='maternity clothes'><img src='/images/merchant_logos/motherhood.gif'></a>
  <a href='http://www.barneys.com/' title='luxury designer handbags, shoes & clothing'><img src='/images/merchant_logos/barneys.jpg'></a>
  <a href='http://www.gap.com/' title='clothes for women, men, maternity, baby, & kids'><img src='/images/merchant_logos/gap.gif'></a>
  <a href='http://oldnavy.gap.com/' title='clothes for women, men, kids & baby'><img src='/images/merchant_logos/oldnavy.gif'></a>
  <a href='http://bananarepublic.gap.com/' title='apparel, handbags, shoes & accessories for women and men'><img src='/images/merchant_logos/bananarepublic.gif'></a>
  <a href='http://www.drugstore.com/' title='prescription drugs, health & beauty products'><img src='/images/merchant_logos/drugstore.gif'></a>
  <a href='http://www.beauty.com/' title='bareMinerals, Origins, Urban Decay, NARS & more beauty products'><img src='/images/merchant_logos/beauty.gif'></a>
  <a href='http://www.sephora.com/' title='makeup, fragrance & skincare'><img src='/images/merchant_logos/sephora.gif'></a>
  <a href='http://www.davidsbridal.com/Browse_Buy-Online' title='wedding dresses & prom dresses'><img src='/images/merchant_logos/davids_bridal.gif'></a>
  <a href='http://www.familychristian.com/' title='America&#39;s leading Christian book store'><img src='/images/merchant_logos/familychristian.png'></a>
  <a href='http://www.toysrus.com/shop/index.jsp' title='toys, games, & more'><img src='/images/merchant_logos/toysrus.gif'></a>



</div>



<div id='bottom-bar'>
    <span>&copy;2013 VituMob</span>
    <span><a href='http://www.vitumob.com/faq'>FAQ</a></span>
    <span><a href='http://www.vitumob.com/privacy'>privacy</a></span>
    <span><a href='http://www.vitumob.com/returns'>returns</a></span>
</div>

</body>

</html>