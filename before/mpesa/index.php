<?php
session_start();
include("../config.php");

 /* MPESA IPN Sample Please do not use this code for production as it does not address security. Copyright (c) 2011 */ 

  
   /* This below is a sample of how this script will be called by M-PESA https://yourip/yourscript.php?id=2970&orig=MPESA&dest=254700733153&tstamp=2011-07-06 22:48:56.0&text=BM46ST941 Confirmed.on 6/7/11 at 10:49 PM Ksh8,723.00 received from RONALD NDALO 254722291067.Account Number 5FML59-01 New Utility balance is Ksh6,375,223.00&customer_id=2&user=123&pass=123&routemethod_id=2&routemethod_name=HTTP&mpesa_code=BM46ST941&mpesa_acc=5FML59-01&mpesa_msisdn=254722291067&mpesa_trx_date=6/7/11&mpesa_trx_time=10:49 PM&mpesa_amt=8723.0&mpesa_sender=RONALD NDALO */ 
   
   
?>
<title>VituMob: M-Pesa Payment Notification</title>
<?php


$id = $_REQUEST['id']; 
$moneyfromnumber = $_REQUEST['mpesa_msisdn'];
$moneyfromname = $_REQUEST['mpesa_sender'];
$amount = $_REQUEST['mpesa_amt'];


if(!empty($id))
{
	$upddateorder = "update orders set tx_id='$id',tx_sendernumber='$moneyfromnumber',tx_sendername='$moneyfromname',amount='$amount' where id='$id'";
	if(mysql_query($upddateorder))
	{
		$myFile = $id."_mpesalog.txt"; 
		$fh = fopen($myFile, 'a') or die("can't open file");
		fwrite($fh, "=============================\n"); 
		foreach ($_REQUEST as $var => $value)
		{ 
			fwrite($fh, "$var = $value\n"); 
		} 
		fwrite($fh, $fmessage); 
		fclose($fh);
		
		echo "OK|Thank you for your payment";
	}
	else
	{
		echo "There is some problem with your transation.";
	}
}
else
{
	echo "Order number is not found.";
}	



  ?>