<?php include("config.php");
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
    <link rel='stylesheet' href="static/vitumob.css">
    <link rel='chrome-webstore-item' href="https://chrome.google.com/webstore/detail/ndfakojkecjkdibnkcoljkdbkbkoloik">
    
</head>

<body>



<div id='nav-bar'>


<span><a href='/cart'>cart</a></span>



<span><a href='/orders'>orders</a></span>



<span><a href='/contact'>contact</a></span>


</div>

<div id='header'><a href='http://www.vitumob.com/beta'><img id='logo' src='images/logo.png'></a></div>

<div id='main' class=''>


<h1>Order #<?php echo $_REQUEST['orderid'];?></h1>

<h2>Status: <span>shipping</span></h2><table id='order-status'>
    <tr>
        <td><img src='images/plane.png'></td>
        <td><img src='images/arrow_orange.png'></td>
        <td class='not-yet'><img src='images/kenya.png'></td>
        <td class='not-yet'><img src='images/arrow_orange.png'></td>
        <td class='not-yet'><img src='images/home.png'></td>
    </tr>

</table>


<style>

    table.order { min-width: 80%; border-spacing: 0 }
    table.order > tbody > tr:first-child > th { border-top: thin solid gray; padding-top: 12pt }
    table.order > tfoot > tr:first-child > td { border-top: medium double gray; padding-top: 12pt }

</style>

<table class=order>

    <thead>
        <tr>
            <td>Cart</td>
            <td class='price'>&nbsp;KSh</td>
          <td class='quantity'>Quantity</td>
        </tr>
    </thead>
    
     <tr class='merchant'>
            <th colspan='3'>&nbsp;</th>
        </tr>
    
    <tbody>
       <?php $sql = "select * from orders inner join cart on orders.id=cart.order_id left join cart_total on cart.session_id=cart_total.session_id where orders.id='".$_REQUEST['orderid']."' and cart.status='1'";
	   $re = mysql_query($sql);
	   while($row = mysql_fetch_array($re))
	   {
	   	
	   ?>
       
        <tr class=''>
            <th colspan='3'><a href='<?php echo stripslashes($row["link"])?>' style="color:#027FC2"><?php echo stripslashes($row["host_name"]);?></a></th>
        </tr>
        
        <tr class='item'>
            <td><?php echo $row['name'];?></td>
            <td class='price'>
                
                   <?php echo $row['item_price_ksh'];?>
                
            </td>
            <td class='quantity'><?php echo $row['quantity'];?></td>
        </tr>
        
        
     <?php
	 $subtotal = $row['sub_total_ksh'];
	 $customtotal = $row['custom_import_fee_ksh'];
	 $shippingtotal = $row['shipping_ksh'];
	 $vattotal = $row['vat_ksh'];
	 $total = $row['total_ksh'];
	 
     }
	 ?>   
    </tbody>
    

    <tfoot>
        <tr>
            <td class='label'>Subtotal</td>
            <td id='subtotal' class='price'>
                
                    <?php echo $subtotal;?>
                
            </td>
            <td></td>
        </tr>
        <tr>
            <td class='label'>Customs &amp; Import Fees</td>
            <td id='customs' class='price'>
                
                     <?php echo $customtotal;?>
                
            </td>
        </tr>
        <tr>
            <td class='label'>Shipping &amp; Handling</td>
            <td id='shipping' class='price'>
                
                     <?php echo $shippingtotal;?>
                
            </td>
        </tr>
        <tr>
            <td class='label'>VAT</td>
            <td id='vat' class='price'>
                
                     <?php echo $vattotal;?>
                
            </td>
        </tr>
        <tr>
            <td class='label'>Total</td>
            <td id='total' class='price'>
                
                    <?php echo $total;?>
                
            </td>
        </tr>
    </tfoot>

</table>


</div>

<div id='footer'>
<hr>

<p style='margin-top: 36pt; color: dimgray'>Click any site below to shop</p>

  <a href='http://www.amazon.com/' title='electronics, apparel, computers, books, & DVDs'><img src='images/merchant_logos/amazon.png'></a>
  <a href='http://store.apple.com/' title='iPad, iPhone, MacBook, iMac & Mac mini'><img src='images/merchant_logos/apple.png'></a>
  <a href='http://www.cellhut.com/' title='unlocked cell phones: Motorola, Nokia, Sony Ericsson'><img src='images/merchant_logos/cellhut.jpg'></a>
  <a href='http://www.macys.com/' title='fashion clothing & accessories'><img src='images/merchant_logos/macys.gif'></a>
  <a href='http://www.bestbuy.com/' title='consumer electronics'><img src='images/merchant_logos/bestbuy.png'></a>
  <a href='http://www.autopartswarehouse.com/' title='car parts & accessories'><img src='images/merchant_logos/autopartswarehouse.png'></a>
  <a href='http://www.fragrancenet.com/' title='perfume, cologne & discount fragrances'><img src='images/merchant_logos/fragrancenet.gif'></a>
  <a href='http://www.victoriassecret.com/' title='lingerie, women&#39;s clothing & accessories'><img src='images/merchant_logos/victoriassectret.gif'></a>
  <a href='http://www.neimanmarcus.com/' title='designers Eileen Fisher, Tory Burch, Gucci, Christian Louboutin & more'><img src='images/merchant_logos/neimanmarcus.png'></a>
  <a href='http://www.worldsoccershop.com/' title='official soccer jerseys, shirts, cleats, shoes, balls & gear'><img src='images/merchant_logos/worldsoccershop.jpg'></a>
  <a href='http://www.worldrugbyshop.com/' title='rugby jerseys, rugby shirts, rugby boots, balls & equipment'><img src='images/merchant_logos/worldrugbyshop.jpg'></a>
  <a href='http://www.armaniexchange.com/home.do' title='youthful fashion label created by Italian designer Giorgio Armani'><img src='images/merchant_logos/ax.jpg'></a>
  <a href='http://www.bathandbodyworks.com/home/index.jsp' title='body care, home fragrance, beauty & gifts'><img src='images/merchant_logos/bbw.png'></a>
  <a href='http://www.motherhood.com/' title='maternity clothes'><img src='images/merchant_logos/motherhood.gif'></a>
  <a href='http://www.barneys.com/' title='luxury designer handbags, shoes & clothing'><img src='images/merchant_logos/barneys.jpg'></a>
  <a href='http://www.gap.com/' title='clothes for women, men, maternity, baby, & kids'><img src='images/merchant_logos/gap.gif'></a>
  <a href='http://oldnavy.gap.com/' title='clothes for women, men, kids & baby'><img src='images/merchant_logos/oldnavy.gif'></a>
  <a href='http://bananarepublic.gap.com/' title='apparel, handbags, shoes & accessories for women and men'><img src='images/merchant_logos/bananarepublic.gif'></a>
  <a href='http://www.drugstore.com/' title='prescription drugs, health & beauty products'><img src='images/merchant_logos/drugstore.gif'></a>
  <a href='http://www.beauty.com/' title='bareMinerals, Origins, Urban Decay, NARS & more beauty products'><img src='images/merchant_logos/beauty.gif'></a>
  <a href='http://www.sephora.com/' title='makeup, fragrance & skincare'><img src='images/merchant_logos/sephora.gif'></a>
  <a href='http://www.davidsbridal.com/Browse_Buy-Online' title='wedding dresses & prom dresses'><img src='images/merchant_logos/davids_bridal.gif'></a>
  <a href='http://www.familychristian.com/' title='America&#39;s leading Christian book store'><img src='images/merchant_logos/familychristian.png'></a>
  <a href='http://www.toysrus.com/shop/index.jsp' title='toys, games, & more'><img src='images/merchant_logos/toysrus.gif'></a>



</div>



<div id='bottom-bar'>
    <span>&copy;2013 VituMob</span>
    <span><a href='http://www.vitumob.com/faq'>FAQ</a></span>
    <span><a href='http://www.vitumob.com/privacy'>privacy</a></span>
    <span><a href='http://www.vitumob.com/returns'>returns</a></span>
</div>

</body>

</html>