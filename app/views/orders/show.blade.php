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
		var_dump($input);

		$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : Auth::user()->email; 
		$phone = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : 'unset'; 
		$id =  isset($_REQUEST['id']) ? $_REQUEST['id'] : 'unset';

		$user =  DB::table('users')
			->where('email', $email)
			->orWhere('phone', $phone)
			// ->orWhere('phone', $_REQUEST['phone'])
			->first();
		// var_dump($id);

		$order =  DB::table('orders')->where('id', $id)->first();
		if(isset($order)):

		$items =  DB::table('items')
		->where('order_id', $order->id)
		->where('quantity', '>', 0)->get();
		var_dump($items); 
		if(isset($items['0'])){ 
		?>

	<h1>Order #{{ $order->id }}</h1>
	<h2>Status: <span>{{ $order->order_status }}</span></h2>
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
					// var_dump($item->merchant_id);
					$i++;
					if ( !in_array($item->merchant_id, $uniquemerchants) ) {
		       		$uniquemerchants[] = $item->merchant_id; //add all ids into an array
		       		// var_dump($item->merchant_id);
			};//ends if
		};//ends foreach



		foreach($uniquemerchants as $unique_merchant_id){
			var_dump($unique_merchant_id);
			$merchant = DB::table('merchants')->where('id', $unique_merchant_id)->first();
			// var_dump($merchant->name);
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

				
				$sub_total_ksh = number_format($sub_total*$exchange_rate);// has to happen before sub_total is turned to string
				$sub_total = number_format((float)$sub_total, 2, '.', ','); 
				$customs = number_format((float)$customs, 2, '.', ',');
				$shipping = number_format((float)$shipping, 2, '.', ',');
				$vat = number_format((float)$vat, 2, '.', ',');
				$total = number_format((float)$total, 2, '.', ','); 

				$sub_total_all += $sub_total;
				$customs_all += $customs;
				$shipping_all += $shipping;
				$vat_all += $vat;
				$total_all += $total;

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
					<td class='quantity'>
						<!-- <input type="text" name="qty[393]" value="1"><br> -->
						<select name="quantity" id="quantity">
							<option value="{{ $item->quantity }}" selected>{{ $item->quantity }}</option>
							@for($j=0; $j<=20; $j++)
							<option value="{{ $j }}">{{ $j }}</option>
							@endfor
						</select>
						<!-- <a href="" class="delete"><span >delete</span></a> -->
					</td> 
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
			<tr>
				<td colspan="5"><input type="submit" name="submit" value="Checkout" class="blue button" /></td>
			</tr>
		</tfoot>

	</table>
	<?php
	} //ends if(isset($items['0']))
	else{
		echo '<h4>There are no items in that order.</h4>';
	}
	else:
		echo '<h4>That order does not exist. Please <a href="./check">check your form</a></h4>';
	endif;
	?>
</form>

</div>
@include('partials.merchants')

@include('partials.footer')

@stop



@section('js')      <!-- goes under body -->

<script type="text/javascript">

	// if(event.keyCode==13) {
	// 	if ( $(this).val() == 0 ) {
	// 		if(confirm('Setting the Qty to zero will remove this item. Click OK to continue.')) {
	// 			recalculate(document.formbasket, 'qty29510680');
	// 		} else {
	// 			return false;
	// 		}
	// 	} else { 
	// 		recalculate(document.formbasket, 'qty29510680');
	// 	}
	// } else { 
	// 	Is_Numeric('qty29510680');
	// }


		//moneymaker
		function addCommas(nStr) {
			nStr += '';
			var x = nStr.split('.');
			var x1 = x[0];
			var x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}
		$('select#quantity').on('change', function(){

		// reading view for this product...

		itemx = $(this).parent('td').parent('tr');
		t_usd = itemx.children('td.price-usd')[0];
		t_ksh = itemx.children('td.price-ksh')[0];

		// quantity = parseInt($(this)['0'].value);//doesnt persist after changing and clicking away
		quantity = parseInt(itemx.data('quantity'));
		quantity_new = parseInt($(this)['0'].value);
		if(quantity_new ==0){
			$(this).parent('td').append('<a href="" class="delete"><span >delete</span></a>');
			
		}else{
			$(this).parent('td').children('a').remove();
		}
		del= $(this).parent('td').children('a');

		// // setting view
		// t_usd.textContent = (Math.round(sub_total_usd/quantity*quantity_new*100)/100).toFixed(2);

		// exchange_rate = $('table#cart').data('exchange-rate');
		// t_ksh.textContent = (Math.round(parseFloat(t_usd.textContent)*exchange_rate*100)/100).toFixed(2); 

		
		//reading data-tags...
		sub_x = parseFloat((itemx.data('sub-total')).toString().replace(',', ''));
		cus_x = parseFloat((itemx.data('customs')).toString().replace(',', ''));
		shi_x = parseFloat((itemx.data('shipping')).toString().replace(',', ''));
		vat_x = parseFloat((itemx.data('vat')).toString().replace(',', ''));
		tot_x = parseFloat((itemx.data('total')).toString().replace(',', ''));


		//calculating new values for the item...
		sub_x = (Math.round(sub_x*quantity_new/quantity*100)/100).toFixed(2);
		cus_x = (Math.round(cus_x*quantity_new/quantity*100)/100).toFixed(2);
		shi_x = (Math.round(shi_x*quantity_new/quantity*100)/100).toFixed(2);
		vat_x = (Math.round(vat_x*quantity_new/quantity*100)/100).toFixed(2);
		tot_x = (Math.round(sub_x*quantity_new/quantity*100)/100).toFixed(2);

		//writting view
		t_usd.textContent = '$'+addCommas(sub_x);
		exchange_rate = $('table#cart').data('exchange-rate');
		t_ksh.textContent = addCommas(Math.round(sub_x*exchange_rate)); 

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
		// console.log(sub_x);
		// console.log(cus_x);
		// console.log(shi_x);
		// console.log(vat_x);
		// console.log(tot_x);
		// console.log(sub);
		// console.log(cus);
		// console.log(shi);
		// console.log(vat);
		// console.log(tot);
		// console.log(itemx.data('sub-total'));
		// console.log(itemx.data('customs'));
		// console.log(itemx.data('shipping'));
		// console.log(itemx.data('vat'));
		// console.log(itemx.data('total'));

		//writing view for totals...

		$('td#sub-total-usd')['0'].textContent = '$'+addCommas((Math.round(sub*100)/100).toFixed(2)); 
		$('td#customs-usd')['0'].textContent = '$'+addCommas((Math.round(cus*100)/100).toFixed(2)); 
		$('td#shipping-usd')['0'].textContent = '$'+addCommas((Math.round(shi*100)/100).toFixed(2)); 
		$('td#vat-usd')['0'].textContent = '$'+addCommas((Math.round(vat*100)/100).toFixed(2)); 
		$('td#total-usd')['0'].textContent = '$'+addCommas((Math.round(tot*100)/100).toFixed(2)); 


		$('td#sub-total-ksh')['0'].textContent = addCommas(Math.round(sub*exchange_rate)); 
		$('td#customs-ksh')['0'].textContent = addCommas(Math.round(cus*exchange_rate)); 
		$('td#shipping-ksh')['0'].textContent = addCommas(Math.round(shi*exchange_rate)); 
		$('td#vat-ksh')['0'].textContent = addCommas(Math.round(vat*exchange_rate)); 
		$('td#total-ksh')['0'].textContent = addCommas(Math.round(tot*exchange_rate)); 

		//send to db...
		price_usd = parseFloat((Math.round(sub_x/quantity_new*100)/100).toFixed(2));

		changes = new Array();
		changes.push({'quantity': quantity_new, 'price_usd': price_usd, 'status': 'changing'});
		
		// console.log(changes['0']);
		// $.post("items/"+itemx.data('id'), changes['0']);

		$.ajax({  
			type: "PUT",  
			url: "items/"+itemx.data('id'),  
			data: changes['0']
		});

		// var data = $('#cart-form').serializeArray();
		// data.push({name: 'city', value: 'Alabama'});
		// $.post("order", data);

		del.on('click', function(evnt) {
		evnt.preventDefault();
		var title = "Confirm";
		var message = "Are you sure you want to delete?";
		var btn = $(this);
		var itemid = btn.parent('td').parent('tr').data("id");
		console.log(btn);


		if (!jQuery('#dataConfirmModal').length) {
			jQuery('body').append('<div id="dataConfirmModal" \
				class="modal fade" role="dialog" aria-labelledby="dataConfirmLabel" \
				aria-hidden="true"><div class="modal-header"> \
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">× \
				</button><h3 id="dataConfirmLabel">'+title+'</h3></div><div class="modal-body"> \
				'+message+'</div><div class="modal-footer"><button class="btn btn-success" \
				data-dismiss="modal" aria-hidden="true">No</button><a class="btn btn-danger"  \
				data-dismiss="modal" id="dataConfirmOK">Yes</a></div> \
				</div>');
		} 

		jQuery('#dataConfirmModal').find('.modal-body').text(message);
		jQuery('a#dataConfirmOK').on('click', function(){
	            td = btn.parent('td');
	            btn.remove();
	            td.append('<span>deleting...</span>');
	            td.parent('tr').slideToggle("2000");
	            // $.ajax({
	            // 	url: '{{ Functions::root() }}'+'/items/'+itemid,
	            // 	type: 'DELETE',
	            // 	success: function(result) {
	            // 		td.parent('tr').slideToggle("2000");
	            // 	}

	            // });
	        });
		jQuery('#dataConfirmModal').modal({show:true});

	});
	});


</script>
@stop

