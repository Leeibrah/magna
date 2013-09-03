<?php

class Functions extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	public static function host()
	{
		// echo $_SERVER['SERVER_NAME'];
		// echo "http://localhost:8000/beta";
		echo "http://www.vitumob.com/beta";

	}
	public static function root()
	{
		// echo $_SERVER['SERVER_NAME'];
		// echo "http://localhost:8000";
		echo "http://www.vitumob.com";

	}


	public static function exchRate()
	{
		/* function exchRate() returns the Kenya Shilling exchange rate plus an adjustment parameter. */
		$to_add=3;		//$RATE_ADJUST / number to add to exchange rate
		
		// return 90.0;
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
}