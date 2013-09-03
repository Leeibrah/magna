<?php

class Functions extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public static function root()
	{
		// echo $_SERVER['SERVER_NAME'];
		// echo "http://localhost:8000";
		// echo "http://localhost/vml4/public";
		 echo "http://www.vitumob.com";
		// echo "http://vm.thedevs.org";

	}
	public static function host()
	{
		echo Functions::root()."/beta";
	}
	public static function getDomain($url) 
	{
	  $pieces = parse_url($url);
	  $domain = isset($pieces['host']) ? $pieces['host'] : '';
	  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
	    return $regs['domain'];
	  }
	  return false;
	}

	public static function exchRate()
	{
		/* function exchRate() returns the Kenya Shilling exchange rate plus an adjustment parameter. */
		$to_add=3;	//$RATE_ADJUST // number to add to exchange rate
		
		return 87.65650;
		$from = 'USD';
		$to = 'KES';
		$url = 'http://finance.yahoo.com/d/quotes.csv?f=l1d1t1&s=USDKES=X';
		$handle = fopen($url, 'r');
		

		if ($handle) {
			$result = fgetcsv($handle);
			fclose($handle);
			$vm_rate=$result[0]+$to_add;
			// echo "RATE ADJUSTMENT: ".$to_add."<br>";
			// echo "RATE: ".$vm_rate;

			return $vm_rate;
		};

		
	}

	
	public function getPrice($price,$quantity,$exchange)
	{
		/* function getPrice() receives a price, quantity and exchange rate as parameters. If there is no exchange rate, the function returns price*quantity. If there is an exchange rate, the function returns price*quantity*exchange. */

		if ($exchange) {
			$output_price=$price*$quantity*$exchange;
		}
		else {
			$output_price=$price*$quantity;
		}

		return $output_price;
	}

	public static function editButton($ownerid, $context, $itemid)
	{
		if(!Auth::user()){
			echo "";
		}
		elseif(Auth::user()->id != $ownerid){
			echo "";
		}
		else{
			return link_to_route($context.'.edit', 'Edit', array($itemid), array('class' => 'btn btn-info'));
			//link_to_route('bookshelf.edit', 'Edit', array($bookshelf->id), array('class' => 'btn btn-info'));
		}
		
	}
	public static function deleteButton($ownerid, $context, $itemid)
	{
		if(!Auth::user()){
			echo "";
		}
		elseif(Auth::user()->id != $ownerid){
			echo "";
		}
		else{
			echo Form::open(array('method' => 'DELETE', 'route' => array($context.'.destroy', $itemid)));
			echo Form::submit('Delete', array('class' => 'btn btn-danger'));
			echo Form::close();
			//link_to_route('bookshelf.edit', 'Edit', array($bookshelf->id), array('class' => 'btn btn-info'));
			// {{ Form::open(array('method' => 'DELETE', 'route' => array('wishlist.destroy', $wishlist->id))) }}
            //	{{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
            //{{ Form::close() }}
		}
		
	}
	public static function getFloat($pString) {
	    if (strlen($pString) == 0) {
	            return false;
	    }
	    $pregResult = array();

	    $commaset = strpos($pString,',');
	    if ($commaset === false) {$commaset = -1;}

	    $pointset = strpos($pString,'.');
	    if ($pointset === false) {$pointset = -1;}

	    $pregResultA = array();
	    $pregResultB = array();

	    if ($pointset < $commaset) {
	        preg_match('#(([-]?[0-9]+(\.[0-9])?)+(,[0-9]+)?)#', $pString, $pregResultA);
	    }
	    preg_match('#(([-]?[0-9]+(,[0-9])?)+(\.[0-9]+)?)#', $pString, $pregResultB);
	    if ((isset($pregResultA[0]) && (!isset($pregResultB[0]) 
	            || strstr($pregResultA[0],$pregResultB[0]) == 0 
	            || !$pointset))) {
	        $numberString = $pregResultA[0];
	        $numberString = str_replace('.','',$numberString);
	        $numberString = str_replace(',','.',$numberString);
	    }
	    elseif (isset($pregResultB[0]) && (!isset($pregResultA[0]) 
	            || strstr($pregResultB[0],$pregResultA[0]) == 0 
	            || !$commaset)) {
	        $numberString = $pregResultB[0];
	        $numberString = str_replace(',','',$numberString);
	    }
	    else {
	        return false;
	    }
	    $result = (float)$numberString;
	    return $result;
	}
	public static function locations()
	{
		$locations = DB::table('locations')->get();
		$locations_array = array();
		// $locations_array[] = '';
		foreach($locations as $location):
			$locations_array[$location->neighbourhood] = $location->neighbourhood;
		endforeach;

		return $locations_array;
	}
}