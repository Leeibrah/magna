@extends('layouts.vitumob')

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

<h1 class='cart'>Cart</h1>
<form name="form1" id="cart-form" action="{{ Functions::root().'/orderz' }}" method="post">

	<?php
		$exchange_rate= Functions::exchRate(); //? $RATE_ADJUST
		$sub_total_all = 0;
		$customs_all = 0;
		$shipping_all = 0;
		$vat_all = 0;
		$total_all = 0;
		$i=0;
	?>
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
		    	$items =  DB::table('items')->where('ip_address', $_SERVER['REMOTE_ADDR'])->where('quantity', '>', 0)->get();
		    	// var_dump($items); 
		    ?>

			<?php
				$uniquemerchants = array();
				foreach($items as $item){
					$i++;
				    if ( !in_array($item->merchant_id, $uniquemerchants) ) {
				        $uniquemerchants[] = $item->merchant_id;
				        $merchant = DB::table('merchants')->where('id', $item->merchant_id)->first();

			?>
				<tr>
					<th class='merchant' colspan='5'><a href='{{ $merchant->url }}' style="color:#027FC2">
						<?php
							echo $domain = parse_url($merchant->url, PHP_URL_HOST);
						?>
					</a></th>
				</tr>
			<?php
				};//ends if

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

				$sub_total = floor($sub_total * 100) / 100; 
				$sub_total_ksh = floor($sub_total*$exchange_rate * 100) / 100;
				$customs = floor($customs * 100) / 100;
				$shipping = floor($shipping * 100) / 100;
				$vat = floor($vat * 100) / 100;
				$total = floor($total * 100) / 100; 

				$sub_total_all += floor($sub_total * 100) / 100;
				$customs_all += floor($customs * 100) / 100;
				$shipping_all += floor($shipping * 100) / 100;
				$vat_all += floor($vat * 100) / 100;
				$total_all += floor($total * 100) / 100;

				    
			?>
			<tr class='item'  data-index='{{ $i }}' data-item-id='{{ $item->item_id }}' data-id='{{ $item->id }}'
			data-quantity='{{ $item->quantity }}' data-customs='{{ $customs }}' data-vat='{{ $vat }}' data-shipping='{{ $shipping }}' 
			data-price-usd='{{ $item->price_usd }}' data-sub-total='{{ $sub_total }}' data-total='{{ $total }}'>
					<td class='image'><img src='{{ $item->image }}'></td>
					<td class='name'><span><a href='{{ $item->link }}'>{{ $item->name }}</a></span></td>
					<td class='price price-usd'>{{ $sub_total }}</td>
					<td class='price price-ksh' >{{ $sub_total_ksh }}</td>
					<td colspan="2" class='quantity'>
						<!-- <input type="text" name="qty[393]" value="1"><br> -->
						<select name="quantity" id="quantity">
							<option value="{{ $item->quantity }}" selected>{{ $item->quantity }}</option>
							@for($j=0; $j<=20; $j++)
						    	<option value="{{ $j }}">{{ $j }}</option>
						    @endfor
						</select>
						<!-- <a href="{{ Functions::host() }}/items/{{ $item->id }}/delete"><span class=''>Delete</span></a> -->
					</td> 
				</tr>


		<?php
			};//ends foreach
				$sub_total_all_ksh = floor($sub_total_all*$exchange_rate * 100) / 100;
				$customs_all_ksh = floor($customs_all*$exchange_rate * 100) / 100;
				$shipping_all_ksh = floor($shipping_all*$exchange_rate * 100) / 100;
				$vat_all_ksh = floor($vat_all*$exchange_rate * 100) / 100;
				$total_all_ksh = floor($total_all*$exchange_rate * 100) / 100;

		?>
			<!-- <tr>
				<td colspan="5"><input type="submit" name="updateqty" value="Update Cart" class="blue button"></td>
			</tr>  -->
		</tbody>

			<input type="hidden" name="mode" value=""/>
			<input type="hidden" name="sub-total-usd" class="price" id="sub-total-usd" value="{{ $sub_total_all }}"/>
			<input type="hidden" name="sub-total-ksh" class="price price-ksh" id="sub-total-ksh" value="{{ $sub_total_all_ksh }}"/>

			<input type="hidden" name="customs-usd" class="price" id="customs-usd" value="{{ $customs_all }}"/>
			<input type="hidden" name="customs-ksh" class="price price-ksh" id="customs-ksh" value="{{ $customs_all_ksh }}"/>


			<input type="hidden" name="shipping-usd" class="price" id="shipping-usd" value="{{ $shipping_all }}"/>
			<input type="hidden" name="shipping-ksh" class="price price-ksh" id="shipping-ksh" value="{{ $shipping_all_ksh }}"/>

			<input type="hidden" name="vat-usd" class="price" id="vat-usd" value="{{ $vat_all }}"/>
			<input type="hidden" name="vat-ksh" class="price price-ksh" id="vat-ksh" value="{{ $vat_all_ksh }}"/>

			<input type="hidden" name="total-usd" class="price" id="total-usd" value="{{ $total_all }}"/>
			<input type="hidden" name="total-ksh" class="price price-ksh" id="total-ksh" value="{{ $total_all_ksh }}"/> 

		<tfoot>

		   	<tr>
		   		<td>&nbsp;</td>
			   	<td class="lbl">Subtotal</td>
			   	<td class="price" id="sub-total-usd">{{ $sub_total }}</td>
			   	<td class="price price-ksh" id="sub-total-ksh">{{ $sub_total_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
		    <tr>
		    	<td>&nbsp;</td>
		    	<td class="lbl">Customs &amp; Import Fees</td>
		    	<td class="price" id="customs-usd">{{ $customs_all }}</td>
		    	<td class="price price-ksh" id="customs-ksh">{{ $customs_all_ksh }}</td>
		    	<td>&nbsp;</td>
		    </tr>
		    <tr>
		    	<td>&nbsp;</td>
		    	<td class="lbl">Shipping &amp; Handling</td>
		    	<td class="price" id="shipping-usd">{{ $shipping_all }}</td>
		    	<td class="price price-ksh" id="shipping-ksh">{{ $shipping_all_ksh }}</td>
		    	<td>&nbsp;</td>
		    </tr>
		    <tr>
		    	<td>&nbsp;</td>
		    	<td class="lbl">VAT</td>
		    	<td class="price" id="vat-usd">{{ $vat_all }}</td>
		    	<td class="price price-ksh" id="vat-ksh">{{ $vat_all_ksh }}</td>
		    	<td>&nbsp;</td>
		    </tr>
		    <tr>
		    	<td>&nbsp;</td>
		    	<td class="lbl">Total</td>
		    	<td class="price" id="total-usd">{{ $total_all }}</td>
		    	<td class="price price-ksh" id="total-ksh">{{ $total_all_ksh }}</td>
		    	<td>&nbsp;</td>
		    </tr>
		    <tr>
		    	<td colspan="5"><input type="submit" name="submit" value="Checkout" class="blue button" /></td>
			</tr>
		</tfoot>

	</table>
</form>

</div>
@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript">


		$('select#quantity').on('change', function(){

			// reading view for this product...

			itemx = $(this).parent('td').parent('tr');
			t_usd = itemx.children('td.price-usd')[0];
			t_ksh = itemx.children('td.price-ksh')[0];

			// quantity = parseInt($(this)['0'].value);//doesnt persist after changing and clicking away
			quantity = parseInt(itemx.data('quantity'));
			quantity_new = parseInt($(this)['0'].value);

			// // setting view
			// t_usd.innerText = (Math.round(sub_total_usd/quantity*quantity_new*100)/100).toFixed(2);

			// exchange_rate = $('table#cart').data('exchange-rate');
			// t_ksh.innerText = (Math.round(parseFloat(t_usd.innerText)*exchange_rate*100)/100).toFixed(2); 

			
			//reading data-tags...
			sub_x = itemx.data('sub-total');
			cus_x = itemx.data('customs');
			shi_x = itemx.data('shipping');
			vat_x = itemx.data('vat');
			tot_x = itemx.data('total');

			//calculating new values for the item...
			sub_x = parseFloat((Math.round(sub_x*quantity_new/quantity*100)/100).toFixed(2));
			cus_x = parseFloat((Math.round(cus_x*quantity_new/quantity*100)/100).toFixed(2));
			shi_x = parseFloat((Math.round(shi_x*quantity_new/quantity*100)/100).toFixed(2));
			vat_x = parseFloat((Math.round(vat_x*quantity_new/quantity*100)/100).toFixed(2));
			tot_x = parseFloat((Math.round(sub_x*quantity_new/quantity*100)/100).toFixed(2));

			//writting view
			t_usd.innerText = sub_x;
			exchange_rate = $('table#cart').data('exchange-rate');
			t_ksh.innerText = (Math.round(sub_x*exchange_rate*100)/100).toFixed(2); 

			//writting data-tags...
			itemx.attr('data-sub-total', sub_x);
			itemx.attr('data-customs', cus_x);
			itemx.attr('data-shipping', shi_x);
			itemx.attr('data-vat', vat_x);
			itemx.attr('data-total', tot_x);

			//calculations...

			sub = 0;
			cus = 0;
			shi = 0;
			vat = 0;
			tot = 0;

			$('tr.item').each(function(){
	        	sub += parseFloat($(this).attr('data-sub-total'));
	        	cus += parseFloat($(this).attr('data-customs'));
				shi += parseFloat($(this).attr('data-shipping'));
				vat += parseFloat($(this).attr('data-vat'));
				tot += parseFloat($(this).attr('data-total'));

	    	});
			console.log(sub_x);
			// console.log(cus_x);
			// console.log(shi_x);
			// console.log(vat_x);
			// console.log(tot_x);
			// console.log(sub);
			// console.log(cus);
			// console.log(shi);
			// console.log(vat);
			// console.log(tot);
			console.log(itemx.data('sub-total'));
			// console.log(itemx.data('customs'));
			// console.log(itemx.data('shipping'));
			// console.log(itemx.data('vat'));
			// console.log(itemx.data('total'));

			//writing view for all items...

			$('td#sub-total-usd')['0'].innerText = (Math.round(sub*100)/100).toFixed(2); 
			$('td#customs-usd')['0'].innerText = (Math.round(cus*100)/100).toFixed(2); 
			$('td#shipping-usd')['0'].innerText = (Math.round(shi*100)/100).toFixed(2); 
			$('td#vat-usd')['0'].innerText = (Math.round(vat*100)/100).toFixed(2); 
			$('td#total-usd')['0'].innerText = 'USD '+(Math.round(tot*100)/100).toFixed(2); 


			$('td#sub-total-ksh')['0'].innerText = (Math.round(sub*exchange_rate*100)/100).toFixed(2); 
			$('td#customs-ksh')['0'].innerText = (Math.round(cus*exchange_rate*100)/100).toFixed(2); 
			$('td#shipping-ksh')['0'].innerText = (Math.round(shi*exchange_rate*100)/100).toFixed(2); 
			$('td#vat-ksh')['0'].innerText = (Math.round(vat*exchange_rate*100)/100).toFixed(2); 
			$('td#total-ksh')['0'].innerText = 'KSh '+(Math.round(tot*exchange_rate*100)/100).toFixed(2); 

			//send to db...
			price_usd = parseFloat((Math.round(sub_x/quantity_new*100)/100).toFixed(2));

			changes = new Array();
			changes.push({'quantity': quantity_new, 'price_usd': price_usd, 'status': 'changing'});
			
			console.log(changes['0']);
			// $.post("items/"+itemx.data('id'), changes['0']);

			 $.ajax({  
                    type: "PUT",  
                    url: "items/"+itemx.data('id'),  
                    data: changes['0']
                });

			// var data = $('#cart-form').serializeArray();
			// data.push({name: 'city', value: 'Alabama'});
			// $.post("orders", data);
		});

    </script>
@stop

