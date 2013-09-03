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


	<form name="form1" id="cart-form" action="{{ Functions::root().'/order' }}" method="post">

		<?php
		$exchange_rate= Functions::exchRate(); //? $RATE_ADJUST
		$sub_total_all = 0;
		$customs_all = 0;
		$shipping_all = 0;
		$vat_all = 0;
		$total_all = 0;
		$i=0;

		$input = Input::all();
		// var_dump($input);

		$order =  DB::table('orders')->where('id', $id)->first();
	
		if(isset($order)){ 

		$items =  DB::table('items')
		->where('order_id', $id)
		->where('quantity', '>', 0)->get();

		?>

	<h1>Order #{{ $order->id }}</h1>
	<h2>Status: {{ $order->order_status }} <span style="float:right">Destination: {{ $order->neighbourhood }}, {{ $order->city }}</span></h2>
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
					<td width='10%' class='price price-ksh'>KSh</td>
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

					$hostArr = array("www.bestbuy.com","www.cellhut.com","www.apple.com");

					if(in_array($domain,$hostArr) || (
						strpos(strtolower($item->name),"phone")
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

						$customamout = $item->price_usd * $customrate/100;
						if($customamout>12)
						{
							$customs = $item->price_usd * $customrate/100;	
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
						$customs = $item->price_usd * $customrate/100;	
						$vat = $item->price_usd * 16/100;	

					}
					else
					{
						$customrate = 25.625;

						$customs = $item->price_usd * $customrate/100;	
						$vat = $item->price_usd * 16/100;	
					}

				$sub_total = $item->quantity* $item->price_usd;//def

				$shipping = ($sub_total + $customrate) * 0.12;

				if ($shipping) {
					$minShipping = 10 + (5 * $i);//? $i
					if ($shipping < $minShipping) $shipping = $minShipping;
				}

				$total = $sub_total + $customs + $shipping + $vat;//def
				// number_format((float)$number, 2, '.', '');


				$sub_total_all += $sub_total; //has to bappen before casting into number formats
				$customs_all += $customs;
				$shipping_all += $shipping;
				$vat_all += $vat;
				$total_all += $total;

				$sub_total_ksh = number_format($sub_total*$exchange_rate);// has to happen before sub_total is turned to string
				$sub_total = number_format((float)$sub_total, 2, '.', ','); 
				$customs = number_format((float)$customs, 2, '.', ',');
				$shipping = number_format((float)$shipping, 2, '.', ',');
				$vat = number_format((float)$vat, 2, '.', ',');
				$total = number_format((float)$total, 2, '.', ','); 



				$itemdata = array(
				'designer' => $item->designer !=null ? 'Designer: '.$item->designer : null,
				'color' => $item->color != null && $item->color != 'No Color' && $item->color != 'None' ? 'Color: '.$item->color : '',
				'size' => $item->size !=0 ? 'Size: '.$item->size : null,
				'package' => $item->package !=null ? 'Package: '.$item->package : null,
				'print_on_demand' => $item->print_on_demand !=null ? 'Print On Demand: '.$item->print_on_demand : null,
				// 'front_logo' => $item->front_logo !=null ? ': '.$item->front_logo : null,
				'custom_back_number' => $item->custom_back_number !=null ? 'Custom Back Num: '.$item->custom_back_number : null,
				'custom_back_name' => $item->custom_back_name !=null ? 'Custom Back Name: '.$item->custom_back_name : null
				);
				$itemdata = array_filter($itemdata);

				?>
				<tr class='item'  data-index='{{ $i }}' data-item-id='{{ $item->item_id }}' data-id='{{ $item->id }}' 
					data-merchantid='{{ $item->merchant_id }}' data-merchant-id='{{ $merchant->id }}' 
					data-merchant-url='{{ $merchant->url }}' data-quantity='{{ $item->quantity }}' data-customs='{{ $customs }}' 
					data-vat='{{ $vat }}' data-shipping='{{ $shipping }}' data-price-usd='{{ $item->price_usd }}' 
					data-sub-total='{{ $sub_total }}' data-total='{{ $total }}'>
					<td class='image' rowspan="2"><img src='{{ $item->image }}'></td>
					<td class='name'><span><a href='{{ $item->link }}'>{{ $item->name }}</a></span></td>
					<td class='price price-usd'>${{ $sub_total }}</td>
					<td class='price price-ksh' >{{ $sub_total_ksh }}</td>
					<td class='quantity'>{{ $item->quantity }}</td> 

				</tr>
				<tr>
					<td class='itemdata'>{{ implode(", ", $itemdata) }}</td>
				</tr>

				<?php
			};//ends if ( $item->merchant_id == $unique_merchant_id )
			};//ends foreach($items as $item)
		};//ends foreach($uniquemerchants as $unique_merchant_id)
		$sub_total_all_ksh = number_format($sub_total_all*$exchange_rate);
		$customs_all_ksh = number_format($customs_all*$exchange_rate);
		$shipping_all_ksh = number_format($shipping_all*$exchange_rate);
		$vat_all_ksh = number_format($vat_all*$exchange_rate); 
		$total_all_ksh = number_format($total_all*$exchange_rate);

		$sub_total_all = number_format((float)$sub_total_all, 2, '.', ',');
		$customs_all = number_format((float)$customs_all, 2, '.', ',');
		$shipping_all = number_format((float)$shipping_all, 2, '.', ',');
		$vat_all = number_format((float)$vat_all, 2, '.', ',');
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
				<td class="price" id="sub-total-usd">${{ $sub_total_all }}</td>
				<td class="price price-ksh" id="sub-total-ksh">{{ $sub_total_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="lbl">Customs &amp; Import Fees</td>
				<td class="price" id="customs-usd">${{ $customs_all }}</td>
				<td class="price price-ksh" id="customs-ksh">{{ $customs_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="lbl">Shipping &amp; Handling</td>
				<td class="price" id="shipping-usd">${{ $shipping_all }}</td>
				<td class="price price-ksh" id="shipping-ksh">{{ $shipping_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="lbl">VAT</td>
				<td class="price" id="vat-usd">${{ $vat_all }}</td>
				<td class="price price-ksh" id="vat-ksh">{{ $vat_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="lbl">Total</td>
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
} //ends if(is_array($items))
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

