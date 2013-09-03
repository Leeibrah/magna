<?php
session_start();

if(empty($_SESSION['AdminID']))
{
	echo "<script>document.location.href='login.php'</script>";
}
include("../../config.php");
$mode = $_REQUEST['mode'];
$viewid = $_REQUEST['viewid'];
$col = $_REQUEST['col'];
$idtype = $_REQUEST['idtype'];
if(isset($mode) && !empty($mode))
{
	if($idtype=="cart")
	{
		$updstatus = "update cart set $col=now() where id='".$_REQUEST['cartid']."'";
	}
	else
	{
		$updstatus = "update cart set $col=now() where order_id='".$_REQUEST['cartid']."'";
	}	
	mysql_query($updstatus);
	echo "<script>document.location.href='index.php?viewid=$viewid'</script>";
}

if(isset($_POST['submit']))
{
	$uddcart = "update cart set notes='".addslashes($_REQUEST['notes'])."' where order_id='$viewid'";
	mysql_query($uddcart);
	echo "<script>document.location.href='index.php?viewid=$viewid'</script>";
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
       <link rel='stylesheet' href="../vitumob.css">
<link rel="shortcut icon" href="../favicon.ico">
<script language="javascript" src="../jquery.js"></script>
<script>
function changestatus(cartid,mode,col,idtype)
{
	location.href='index.php?viewid=<?php echo $_REQUEST['viewid']?>&cartid='+cartid+'&col='+col+'&idtype='+idtype+'&mode='+mode;
}
</script>

<script src="jquery-1.4.4.min.js" type="text/javascript"></script>

	<script src="jquery.printPage.js" type="text/javascript"></script>

<!--<script>

var jq = jQuery.noConflict();

jq(document).ready(function() {



		// Print specific area

		

		jq("#sprint").printPage();

		//$('#divOpera').jqprint({ operaSupport: true });





  });



	</script>-->


</head>

<body>

<?php
 if(empty($_REQUEST['viewid']))
 {
?>
<?php if(!empty($_SESSION['AdminID'])){
echo "<div align='right' style='float: right; margin:10px 200px 0 0; width: 100px;'><a href='logout.php'>Logout</a></div>";
}

?>
<div id='header'>
    <img id='logo' src="../../images/logo.png">
</div>


<?php }?>
<div id='main' class='' style="margin-left:10px; margin-top:20px;">
<form id='checkout' method='POST' name="checkout">
 
 <?php
 if(empty($_REQUEST['viewid']))
 {
 ?>
  <table width="890" border="0" bgcolor="#FFFFFF" cellpadding="1" cellspacing="1" style="width:100px; border:1px solid #999999">
  <tr>
    <td width="29" align="center" bgcolor="#FFFFFF">#</td>
    <td width="61" align="center" bgcolor="#FFFFFF">Placed</td>
    <td width="50" align="center" bgcolor="#FFFFFF">Total KSh</td>
    <td width="78" align="center" bgcolor="#FFFFFF">Payment Received</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="75" align="center" bgcolor="#FFFFFF">Shipped fromUS</td>
    <td width="66" align="center" bgcolor="#FFFFFF">Arrived KE</td>
    <td width="175" align="center" bgcolor="#FFFFFF">Delivered</td>
  </tr>
 
  <?php 
  $i=0;

 $sql = "select orders.*,orders.id as orderid, cart_total.*,cart.* from orders inner join cart on orders.id=cart.order_id left join cart_total on cart.session_id=cart_total.session_id group by order_id order by orders.id desc";
  $re = mysql_query($sql);
  while($roworder = mysql_fetch_array($re))
  {
  	if($i%2==0)
		$bgcolor = "#CCCCCC";
	else
		$bgcolor = "#F2F2F2"	;
  	$sqlcart = "select *,count(cart.id) as totitems,sum(quantity) as totqty,sum(cart.item_price_usd) as totpriceusd from cart inner join cart_total on cart.session_id=cart_total.session_id where order_id='".$roworder['orderid']."' group by host_name";
	$recart = mysql_query($sqlcart);
	
  ?>
   
	<tr>
    <td align="center" valign="top" bgcolor="<?php echo $bgcolor?>"><a href="index.php?viewid=<?php echo $roworder['orderid']?>" style="text-decoration:underline"><?php echo $roworder['orderid']?></a>&nbsp;</td>
    <td align="center" valign="top" bgcolor="<?php echo $bgcolor?>"><?php echo date('m/d/Y',strtotime($roworder['order_date']))?>&nbsp;</td>
    <td align="center" valign="top" bgcolor="<?php echo $bgcolor?>"><?php echo $roworder['total_ksh']?>&nbsp;</td>
    <td align="center" valign="top" bgcolor="<?php echo $bgcolor?>"><?php
    if($roworder['payment_received']!="0000-00-00 00:00:00")
	{
		echo date('m/d/Y',strtotime($roworder['payment_received']));
	}
	?>&nbsp;</td>
    <td colspan="5" align="center" valign="top" bgcolor="<?php echo $bgcolor?>">
    <table border="0" width="100%" bgcolor="#FFFFFF" cellpadding="1" cellspacing="1">
    
    	<tr>
        <td width="76" align="center" bgcolor="#FFFFFF">Merchant</td>
    <td width="49" align="center" bgcolor="#FFFFFF">Items</td>
    <td width="46" align="center" bgcolor="#FFFFFF">USD</td>
    <td width="70" align="center" bgcolor="#FFFFFF">Ordered</td>
    <td width="78" align="center" bgcolor="#FFFFFF">Received</td>
        </tr>
        <?php
		//$totpriceusd=0;
		$j=0;
        while($row = mysql_fetch_array($recart))
		{
			
			//$totpriceusd = str_replace("$","",$row['sub_total_usd']);
			$totpriceusd = $row['item_price_usd']*$row['quantity'];
			$totpriceusd1 = $row['totpriceusd']*$row['quantity'];
			if($j>0)
				$calcprice = $totpriceusd;
			else
				$calcprice = $totpriceusd1;
			
			
			
			$shipped =  $row['shipped'];
			$arrived =  $row['arrived'];
			$delivered =  $row['delivered'];
			$notes =  stripslashes($row['notes']);
		?>
        
       
        <tr>
        	<td width="76" bgcolor="<?php echo $bgcolor?>"><?php echo $row['host_name']?></td>
            <td width="49" bgcolor="<?php echo $bgcolor?>"><?php echo $row['totitems']?>(<?php echo $row['totqty']?>)</td>
            <td bgcolor="<?php echo $bgcolor?>">$<?php echo $calcprice;?></td>
            <td bgcolor="<?php echo $bgcolor?>"><?php if($row['ordered']!="0000-00-00 00:00:00"){echo $row['ordered'];}?></td>
            <td bgcolor="<?php echo $bgcolor?>"><?php if($row['received']!="0000-00-00 00:00:00"){echo $row['received'];}?></td>
        </tr>
    	<?php 
			$j++;
			}?>
    </table>     
    </td>
    <td align="center" valign="top" bgcolor="<?php echo $bgcolor?>"><?php if($shipped!="0000-00-00 00:00:00"){ echo $shipped;}?>&nbsp;</td>
    <td align="center" valign="top" bgcolor="<?php echo $bgcolor?>"><?php if($arrived!="0000-00-00 00:00:00") { echo $arrived;}?>&nbsp;</td>
    <td align="center" valign="top" bgcolor="<?php echo $bgcolor?>"><?php if($delivered!="0000-00-00 00:00:00"){ echo $delivered;}?>&nbsp;</td>
  </tr>

<?php
  	$i++;
	}
	?>
</table>
<?php 
	}
	else
	{
?>
<?php 
  $sql = "select orders.*,orders.id as orderid,orders.name as uname, cart_total.*,cart.*,count(cart.id) as totitems,sum(cart.quantity) as totquantity from orders inner join cart on orders.id=cart.order_id left join cart_total on cart.session_id=cart_total.session_id where orders.id='".$_REQUEST['viewid']."'";
  $re = mysql_query($sql);
  $row = mysql_fetch_array($re)
  ?>
 <div style="float:right; position:absolute; margin:52px 0 0 530px;"> 
 
 <a href="receipt.php?orderid=<?php echo $_REQUEST['viewid'];?>" id="sprint" style="text-decoration:none;" target="_blank"> <input type="button" name="printbtn" value="Print Receipt"> </a>
  </div>
 <a href="index.php">&larr;Back</a>
  <div class="PrintArea p1">
<table width="890" border="0" bgcolor="#FFFFFF" cellpadding="1" cellspacing="1" >
  <tr>
    <td align="center" bgcolor="#FFFFFF" style="font-size:19px; font-weight:bold;">Order #<?php echo $_REQUEST['viewid']?>&nbsp;
         &nbsp;</td>
    </tr>
  <tr>
    <td align="left" bgcolor="#FFFFFF">
    

Placed:&nbsp;<?php echo date('m/d/Y',strtotime($row['order_date']))?><br>
Total:&nbsp;<?php echo $row['total_ksh']?> KSh<br>
Payment Type:&nbsp;<?php echo $row['payment_type']?><br>
Payment Received:&nbsp;<?php 
	if($row['payment_received']!="0000-00-00 00:00:00")
	{
		echo date('m/d/Y',strtotime($row['payment_received']));
	}	
		?><br>  <br>
        
 <div style="font-size:18px;">Customer Information</div>
 Name:&nbsp;<?php echo stripslashes($row['uname']);?><br>
Email:&nbsp;<?php echo stripslashes($row['email'])?><br>
Phone:&nbsp;<?php echo stripslashes($row['phone'])?><br>
City:&nbsp;<?php echo stripslashes($row['city'])?><br>
Neighbourhood:&nbsp;<?php echo stripslashes($row['neighbourhood'])?><br>          </td>
    </tr>
    
    <tr>
    	<td>
        <div style="font-size:18px;">Items</div><br>

        	<table width="100%" style="border:3px solid #999999">

    <thead>
        <tr>
            <td></td>
            <td class='price'>Price&nbsp;</td>
            <td class='quantity'>Quantity</td>
            <td class='quantity'>Ordered</td>
            <td class='quantity'>Received</td>
        </tr>
    </thead>
    
    
    
    <tbody>
       <?php 
  $sql = "select *,cart.id as cartid from orders inner join cart on orders.id=cart.order_id left join cart_total on cart.session_id=cart_total.session_id where orders.id='".$_REQUEST['viewid']."' order by cartid desc";
	   $re = mysql_query($sql);
	   while($row = mysql_fetch_array($re))
	   {
	   ?>
       
        <tr class='merchant'>
            <th colspan='5'><?php echo $row['host_name'];?></th>
        </tr>
        
        <tr class='item'>
            <td valign="top" style="font-size:12px;"><strong></strong> <?php echo $row['name'];?>
          <span style="font-size:12px;">  
             <?php
 if(!empty($row['name2']))
 {
 	echo "<br>".stripslashes($row['name2']);
 }
 if(!empty($row['color']))
 {
 	echo "<br><strong>Color : </strong>".stripslashes($row['color']);
 }
 if(!empty($row['size']))
 {
 	if(empty($row['color']))
	{
		echo "<br>"	;
	}
	if(!empty($row['color']))
	{
		echo ",&nbsp;"	;
	}
	
 	echo "<strong>Size : </strong>".stripslashes($row['size']);
 }
 if(!empty($row['designer']))
 {
 	echo "<br><strong>Designer : </strong>".stripslashes($row['designer']);
 }
 
 if(!empty($row['package']))
 {
 	echo "<br><strong>Package : </strong>".stripslashes($row['package']);
 }
 if(!empty($row['printondemand']))
 {
 	echo "<br><strong>Print on demand : </strong>".stripslashes($row['printondemand']);
 }
 if(!empty($row['front_logo']))
 {
 	echo "<br><strong>Front Logo : </strong>".stripslashes($row['front_logo']);
 }
 if(!empty($row['custombacknumber']))
 {
 	echo "<br><strong>Custom Back Number :</strong> ".stripslashes($row['custombacknumber']);
 }
 if(!empty($row['custombackname']))
 {
 	echo "<br><strong>Custom Back Name :</strong> ".stripslashes($row['custombackname']);
 }
 ?>
 </span>
            
            
            </td>
            <td valign="top" class='price'>
                
                   <?php echo $row['item_price_usd']*$row['quantity'];?>            </td>
            <td valign="top" class='quantity'><?php echo $row['quantity'];?></td>
            <td valign="top" class='quantity'>
            <?php if($row['ordered']=="0000-00-00 00:00:00"){?>
            <input type="button" name="ordered" value="Mark ordered" onClick="changestatus('<?php echo $row['cartid']?>','markorder','ordered','cart')">
			<?php }
			else
			{
				echo $row['ordered'];
			}?>&nbsp;</td>
            <td valign="top" class='quantity'>
             <?php if($row['received']=="0000-00-00 00:00:00"){?>
            <input type="button" name="received" value="Mark received" onClick="changestatus('<?php echo $row['cartid']?>','markorder','received','cart')">
            <?php }
			else
			{
				echo $row['received'];
			}?>
            &nbsp;</td>
        </tr>
         <?php
		$shipped =  $row['shipped'];
		$arrived =  $row['arrived'];
		$delivered =  $row['delivered'];
		$notes =  stripslashes($row['notes']);
     }
	 ?>  
    </tbody>
    

    <tfoot>
        <tr>
            <td colspan="5" valign="top" class='label'>&nbsp;</td>
          </tr>
    </tfoot>
</table>        </td>
    </tr>
    <tr>
    <td>Shipped from US:
    <?php if($shipped=="0000-00-00 00:00:00"){?>
    <input type="button" name="shippedfromus" value="Mark Shipped" onClick="changestatus('<?php echo $viewid?>','shipped','shipped','order')">
    <?php }else{
		echo $shipped;	
	}?>
    <br>
		Arrived KE:
         <?php if($arrived=="0000-00-00 00:00:00"){?>
        <input type="button" name="arrivedke" value="Mark arrived" onClick="changestatus('<?php echo $viewid?>','arrived','arrived','order')">
       	<?php }else{
		echo $arrived;	
	}?> 
        
        <br>
		Delivered to customer:
         <?php if($delivered=="0000-00-00 00:00:00"){?>
        <input type="button" name="delivered" value="Mark delivered" onClick="changestatus('<?php echo $viewid?>','delivered','delivered','order')">
       	<?php }else{
		echo $delivered;	
	}?> 
        	</td>
    </tr>
    <tr>
    	<td>
         <div style="font-size:18px;">Notes</div><br>
         <textarea name="notes" cols="60"><?php echo $notes;?></textarea>        </td>
    </tr>
    
     <tr>
    	<td>
         <input type="submit" name="submit" value="Submit">        </td>
    </tr>
</table>

</div>






<?php
	}
?>
</form>
<!--<script>
    $(document).ready(function(){
        $("#printbtn").click(function(){

            var mode = 'popup';
            var close = mode == "popup"

            var options = { mode : mode, popClose : close };

            $("div.PrintArea.p1").printArea( options );
        });

       
    });

    </script>-->



</div>

<div id='bottom-bar'>
    <span>&copy;2013 VituMob</span>
    <span><a href='http://www.vitumob.com/faq'>FAQ</a></span>
    <span><a href='http://www.vitumob.com/privacy'>privacy</a></span>
    <span><a href='http://www.vitumob.com/returns'>returns</a></span>
</div>

</body>

</html>