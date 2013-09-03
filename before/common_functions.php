<?php

$RATE_ADJUST=3;		//number to add to exchange rate



/* function exchRate() returns the Kenya Shilling exchange rate plus an adjustment parameter. */

function exchRate($to_add) {

$from = 'USD';
$to = 'KES';
$url = 'http://finance.yahoo.com/d/quotes.csv?f=l1d1t1&s=USDKES=X';
$handle = fopen($url, 'r');
 
if ($handle) {
    $result = fgetcsv($handle);
    fclose($handle);
}

$vm_rate=$result[0]+$to_add;
// echo "RATE ADJUSTMENT: ".$to_add."<br>";
// echo "RATE: ".$vm_rate;

return $vm_rate;
}

/* function getPrice() receives a price, quantity and exchange rate as parameters. If there is no exchange rate, the function returns price*quantity. If there is an exchange rate, the function returns price*quantity*exchange. */

function getPrice($price,$quantity,$exchange) {
	if ($exchange) {
		$output_price=$price*$quantity*$exchange;
	}
	else {
		$output_price=$price*$quantity;
	}

	return $output_price;
}

?>