@extends('layouts.scaffold')

{{-- Web site Title --}}
@section('title')
@parent
:: Your Cart
@stop


@section('css')
<!-- <link rel="stylesheet" href="{{ asset('assets/styles/css/error.css')}} "> -->
@stop


@section('main')

<div id='main' class=''>



		<?php
		//important that figures on on this page are not cached, otherwise onunload we lose dynamically stored stuff
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
		header('Pragma: no-cache'); // HTTP 1.0.
		header('Expires: 0'); // Proxies.


		$exchange_rate= Functions::exchRate(); //? $RATE_ADJUST
		$price_q_all = 0;
		$customs_q_all = 0;
		$shipping_q_all = 0;
		$vat_q_all = 0;
		$total_all = 0;
		$i=0;

		$input = Input::all();
		// var_dump($input);

		$order =  DB::table('orders')->where('id', $id)->first();
	
		if(isset($order)){ 

		$items =  DB::table('items')
		->where('order_id', $id)
		->where('quantity', '>', 0)->get();
		
		
		// $items =  DB::table('items')->where('session_id', session_id())->where('status', 'cart')->get();
		// $items =  DB::table('items')->where('ip_address', $_SERVER['REMOTE_ADDR'])->where('quantity', '>', 0)->get();

		// var_dump($items); 
		// if(isset($items['0'])){ 
		?>

	<h1>Order #{{ $order->id }}</h1>
	<h2>Status: {{ $order->order_status }} <span style="float:right">Destination: {{ $order->city }}, {{ $order->neighbourhood }}</span></h2>
	<table id="order-status">
	    <tbody><tr>
	        <td><img src="{{ asset('images/plane.png')}}"></td>
	        <td><img src="{{ asset('images/arrow_orange.png')}}"></td>
	        <td class="not-yet"><img src="{{ asset('images/kenya-dim.png')}}"></td>
	        <td class="not-yet"><img src="{{ asset('images/arrow_orange-dim3.png')}}"></td>
	        <td class="not-yet"><img src="{{ asset('images/home-dim2.png')}}"></td>
	    </tr>
	</tbody></table>

		<table id='cart' data-exchange-rate='{{ $exchange_rate }}'>

			<tbody>

				<tr>
					<td width='15%'>Items</td>
					<td width='55%'>&nbsp;</td>
					<td width='10%' class='price price-usd'>USD</td>
					<td width='10%' class='price price-ksh'>x{{ number_format((float)$exchange_rate, 2, '.', ',') }} KSh</td>
					<td width='10%'>Quantity</td>
				</tr>

				<?php
				$uniquemerchants = array();
				foreach($items as $item){
					$i++;
					if ( !in_array($item->merchant_id, $uniquemerchants) ) {
		        $uniquemerchants[] = $item->merchant_id; //add all ids into an array
			};//ends if
		};//ends foreach

		foreach($uniquemerchants as $unique_merchant_id){
			$merchant = DB::table('merchants')->where('id', $unique_merchant_id)->first();

			?>
			<tr>
				<th class='merchant' colspan='5'><a href='{{ $merchant->url }}' style="color:#027FC2">
					<?php
					echo $domain = Functions::getDomain($merchant->url);
					?>
				</a></th>
			</tr>
			<?php
			foreach($items as $item){
				if ( $item->merchant_id == $unique_merchant_id ) {

					$price = $item->price_usd;

					$hostArr = array("www.bestbuy.com","www.cellhut.com","www.apple.com");

					if(in_array($domain,$hostArr) 
						|| (strpos(strtolower($item->name),"phone")
						|| strpos(strtolower($item->name),"computer")
						|| strpos(strtolower($item->name),"printer")
						|| strpos(strtolower($item->name),"camera")
						|| strpos(strtolower($item->name),"electronic")
						|| strpos(strtolower($item->name),"camcorder")
						|| strpos(strtolower($item->name),"kindle") 
						|| strpos(strtolower($item->name),"ipad")
				 // || strpos(strtolower($item->name2),"phone")
				 // || strpos(strtolower($item->name2),"computer")
				 // || strpos(strtolower($item->name2),"printer")
				 // || strpos(strtolower($item->name2),"camera")
				 // || strpos(strtolower($item->name2),"electronic")
				 // || strpos(strtolower($item->name2),"camcorder")
				 // || strpos(strtolower($item->name2),"kindle") 
				 // || strpos(strtolower($item->name2),"ipad")
						))
					{
						$customrate = 2.25;

						$customamout = $price * $customrate/100;
						if($customamout>12)
						{
							$customs = $price * $customrate/100;	
							$vat = 0;	
						}
						else
						{
							$customs = 12;	
							$vat = 0;	
						}
					}
					else if($domain=="www.autopartswarehouse.com")
					{
						$customrate = 10.25;
						$customs = $price * $customrate/100;	
						$vat = $price * 16/100;	

					}
					else
					{
						$customrate = 25.625;

						$customs = $price * $customrate/100;	
						$vat = $price * 16/100;	
					}


				$shipping = ( + $customrate) * 0.12;

				$minShipping = 10 + (5 * $i);//? $i
				$shipping =  ($shipping < $minShipping) ? $minShipping : $shipping;

				$total = 		$price + $customs + $shipping + $vat;


				$price_q = 		$price * $item->quantity;
				$customs_q = 	$customs * $item->quantity;
				$shipping_q = 	$shipping * $item->quantity;
				$vat_q = 		$vat * $item->quantity;
				$total_x = 		$total * $item->quantity;


				$price_q_all +=		$price_q; //has to bappen before casting into number formats
				$customs_q_all += 	$customs_q;
				$shipping_q_all +=	$shipping_q;
				$vat_q_all += 		$vat_q;
				$total_all += 		$total_x;


				$itemspecs = array(
				'designer' => $item->designer !=null ? 'Designer: '.$item->designer : null,
				'color' => $item->color != null && $item->color != 'No Color' && $item->color != 'None' ? 'Color: '.$item->color : '',
				'size' => $item->size !=0 ? 'Size: '.$item->size : null,
				'package' => $item->package !=null ? 'Package: '.$item->package : null,
				'print_on_demand' => $item->print_on_demand !=null ? 'Print On Demand: '.$item->print_on_demand : null,
				// 'front_logo' => $item->front_logo !=null ? ': '.$item->front_logo : null,
				'custom_back_number' => $item->custom_back_number !=null ? 'Custom Back Num: '.$item->custom_back_number : null,
				'custom_back_name' => $item->custom_back_name !=null ? 'Custom Back Name: '.$item->custom_back_name : null
				);
				$itemspecs = array_filter($itemspecs);

				?>
				<tr class='item'  data-index='{{ $i }}' data-item-id='{{ $item->item_id }}' data-id='{{ $item->id }}' 
				data-merchant-id='{{ $merchant->id }}' data-merchant-url='{{ $merchant->url }}' 
				data-quantity='{{ $item->quantity }}'  data-price-usd='{{ $price }}' data-customs='{{ $customs }}' 
				data-shipping='{{ $shipping }}' data-vat='{{ $vat }}' data-total='{{ $total }}'>

					<td class='image' rowspan="2"><img src='{{ $item->image }}'></td>
					<td class='name'><span><a href='{{ $item->link }}'>{{ $item->name }}</a></span></td>
					<td class='price price-usd'>${{ number_format((float)$price_q, 2, '.', ',') }}</td>
					<td class='price price-ksh' >{{ number_format($price_q*$exchange_rate); }}</td>
					<td class='quantity'>{{ $item->quantity }}</td>
					<td class='new-price' style="display:none">{{ $price_q }}</td>
					<td class='new-customs' style="display:none">{{ $customs_q }}</td>
					<td class='new-shipping' style="display:none">{{ $shipping_q }}</td>
					<td class='new-vat' style="display:none">{{ $vat_q }}</td>
					<td class='new-total' style="display:none">{{ $total_x }}</td>
				</tr>
				<tr>
					<td class='itemspecs'>{{ implode(", ", $itemspecs) }}</td>
				</tr>

				<?php
			};//ends if ( $item->merchant_id == $unique_merchant_id )
			};//ends foreach($items as $item)
		};//ends foreach($uniquemerchants as $unique_merchant_id)
		$price_q_all_ksh = number_format($price_q_all*$exchange_rate);
		$customs_q_all_ksh = number_format($customs_q_all*$exchange_rate);
		$shipping_q_all_ksh = number_format($shipping_q_all*$exchange_rate);
		$vat_q_all_ksh = number_format($vat_q_all*$exchange_rate); 
		$total_all_ksh = number_format($total_all*$exchange_rate);

		$price_q_all = number_format((float)$price_q_all, 2, '.', ',');
		$customs_q_all = number_format((float)$customs_q_all, 2, '.', ',');
		$shipping_q_all = number_format((float)$shipping_q_all, 2, '.', ',');
		$vat_q_all = number_format((float)$vat_q_all, 2, '.', ',');
		$total_all = number_format((float)$total_all, 2, '.', ',');

		?>
			<!-- <tr>
				<td colspan="5"><input type="submit" name="updateqty" value="Update Cart" class="blue button"></td>
			</tr>  -->
		</tbody>


		<tfoot>

			<tr>
				<td>&nbsp;</td>
				<td class="lbl">Subtotal</td>
				<td class="price" id="sub-total-usd">${{ $price_q_all }}</td>
				<td class="price price-ksh" id="sub-total-ksh">{{ $price_q_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="lbl">Customs &amp; Import Fees</td>
				<td class="price" id="customs-usd">${{ $customs_q_all }}</td>
				<td class="price price-ksh" id="customs-ksh">{{ $customs_q_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="lbl">Shipping &amp; Handling</td>
				<td class="price" id="shipping-usd">${{ $shipping_q_all }}</td>
				<td class="price price-ksh" id="shipping-ksh">{{ $shipping_q_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="lbl">VAT</td>
				<td class="price" id="vat-usd">${{ $vat_q_all }}</td>
				<td class="price price-ksh" id="vat-ksh">{{ $vat_q_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="lbl">TotalLorem ipsum Veniam tempor ullamco sunt.</td>
				<td class="price" id="total-usd">${{ $total_all }}</td>
				<td class="price price-ksh" id="total-ksh">{{ $total_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
	
		</tfoot>

	</table>

<?php
if((Auth::user()->id == $order->user_id) || User::adminCheck()){
?>

<b><u>Special Notes for the order</u></b>
<p>{{ ($order->notes == null) ? 'none' : $order->notes; }}</p>

<td><a href="{{ Functions::host() }}/orders/{{ $order->id }}/edit" class="btn btn-info">Edit</a></td>
<?php
}
?>

<?php
} //ends if(isset($order)){ 
else{
	echo '<h4>Order not found.</h4>';
}
?>

</div>
@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->


@stop

