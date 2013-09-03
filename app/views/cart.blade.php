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

	<h1 class='cart'>Cart</h1>


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

		$items =  DB::table('items')->where('session_id', session_id())->where('status', 'cart')->get();
		// $items =  DB::table('items')->where('ip_address', $_SERVER['REMOTE_ADDR'])->where('quantity', '>', 0)->get();

		// var_dump($items); 
		if(isset($items['0'])){ 
		?>

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
				<td class="lbl">Totals</td>
				<td class="price" id="total-usd">${{ $total_all }}</td>
				<td class="price price-ksh" id="total-ksh">{{ $total_all_ksh }}</td>
				<td>&nbsp;</td>
			</tr>
	
		</tfoot>

	</table>

	<form name="form1" id="cart-form" action="{{ Functions::host().'/checkout' }}" method="post" style="text-align: center;">

		<input type="hidden" name="mode" value=""/>
		<input type="hidden" name="sub_total_usd" class="price" id="sub-total-usd" value="{{ $price_q_all }}"/>
		<input type="hidden" name="sub_total_ksh" class="price price-ksh" id="sub-total-ksh" value="{{ $price_q_all_ksh }}"/>

		<input type="hidden" name="customs_usd" class="price" id="customs-usd" value="{{ $customs_q_all }}"/>
		<input type="hidden" name="customs_ksh" class="price price-ksh" id="customs-ksh" value="{{ $customs_q_all_ksh }}"/>


		<input type="hidden" name="shipping_usd" class="price" id="shipping-usd" value="{{ $shipping_q_all }}"/>
		<input type="hidden" name="shipping_ksh" class="price price-ksh" id="shipping-ksh" value="{{ $shipping_q_all_ksh }}"/>

		<input type="hidden" name="vat_usd" class="price" id="vat-usd" value="{{ $vat_q_all }}"/>
		<input type="hidden" name="vat_ksh" class="price price-ksh" id="vat-ksh" value="{{ $vat_q_all_ksh }}"/>

		<input type="hidden" name="total_usd" class="price" id="total-usd" value="{{ $total_all }}"/>
		<input type="hidden" name="total_ksh" class="price price-ksh" id="total-ksh" value="{{ $total_all_ksh }}"/> 

		<input type="submit" name="submit" value="Checkout" class="blue button" />
	</form>

	<?php
	} //ends if(is_array($items))
	else{
		echo '<h4>There are no items in your shopping cart</h4>'.session_id();
	}
	?>


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
		//hidden td -> true floats
		t_pri = itemx.children('td.new-price')[0];
		t_cus = itemx.children('td.new-customs')[0];
		t_shi = itemx.children('td.new-shipping')[0];
		t_vat = itemx.children('td.new-vat')[0];
		t_tot = itemx.children('td.new-total')[0];


		// quantity = parseInt($(this)['0'].value);//doesnt persist after changing and clicking away
		quantity = parseInt(itemx.data('quantity'));
		quantity_new = parseInt($(this)['0'].value);


		// // setting view
		// t_usd.textContent = (Math.round(sub_total_usd/quantity*quantity_new*100)/100).toFixed(2);

		// exchange_rate = $('table#cart').data('exchange-rate');
		// t_ksh.textContent = (Math.round(parseFloat(t_usd.textContent)*exchange_rate*100)/100).toFixed(2); 

		
		//reading data-tags...
		pri_x = parseFloat(itemx.attr('data-price-usd'));
		cus_x = parseFloat(itemx.attr('data-customs'));
		shi_x = parseFloat(itemx.attr('data-shipping'));
		vat_x = parseFloat(itemx.attr('data-vat'));
		tot_x = parseFloat(itemx.attr('data-total'));


		//calculating new values for the item...
		sub_x = pri_x*quantity_new;
		cus_x = cus_x*quantity_new;
		shi_x = shi_x*quantity_new;
		vat_x = vat_x*quantity_new;
		tot_x = tot_x*quantity_new;


		//writting view
		t_usd.textContent = '$'+addCommas(sub_x);
		exchange_rate = $('table#cart').data('exchange-rate');
		t_ksh.textContent = addCommas(Math.round(sub_x*exchange_rate)); 

		//writting hidden td
		t_pri.textContent = sub_x;
		t_cus.textContent = cus_x;
		t_shi.textContent = shi_x;
		t_vat.textContent = vat_x;
		t_tot.textContent = tot_x;


		//calculating for bottom figures

		sub = 0;
		cus = 0;
		shi = 0;
		vat = 0;
		tot = 0;

		$('tr.item').each(function(){
			sub += parseFloat($(this).children('td.new-price')['0'].textContent);
			cus += parseFloat($(this).children('td.new-customs')['0'].textContent);
			shi += parseFloat($(this).children('td.new-shipping')['0'].textContent);
			vat += parseFloat($(this).children('td.new-vat')['0'].textContent);
			tot += parseFloat($(this).children('td.new-total')['0'].textContent);
		});
		// console.log(sub);
		// console.log(cus);
		// console.log(shi);
		// console.log(vat);
		// console.log(tot);

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

		//write inputs for checkout form

		$('input#sub-total-usd')['0'].value = '$'+addCommas((Math.round(sub*100)/100).toFixed(2)); 
		$('input#customs-usd')['0'].value = '$'+addCommas((Math.round(cus*100)/100).toFixed(2)); 
		$('input#shipping-usd')['0'].value = '$'+addCommas((Math.round(shi*100)/100).toFixed(2)); 
		$('input#vat-usd')['0'].value = '$'+addCommas((Math.round(vat*100)/100).toFixed(2)); 
		$('input#total-usd')['0'].value = '$'+addCommas((Math.round(tot*100)/100).toFixed(2)); 

		$('input#sub-total-ksh')['0'].value = addCommas(Math.round(sub*exchange_rate)); 
		$('input#customs-ksh')['0'].value = addCommas(Math.round(cus*exchange_rate)); 
		$('input#shipping-ksh')['0'].value = addCommas(Math.round(shi*exchange_rate)); 
		$('input#vat-ksh')['0'].value = addCommas(Math.round(vat*exchange_rate)); 
		$('input#total-ksh')['0'].value = addCommas(Math.round(tot*exchange_rate)); 

		
		//send to db...
		
		// console.log(changes['0']);
		// $.post("items/"+itemx.data('id'), changes['0']);

		// var data = $('#cart-form').serializeArray();
		// data.push({name: 'city', value: 'Alabama'});
		// $.post("order", data, function() { this is the function tht will take place after success});

		quantitybox = $(this).parent('td');
		quantitybox.append('<span class="temp updating">updating...</span>');

		changes = new Array();
		if(quantity_new ==0){
			changes.push({'status': 'deleted'}); //retain the last prices in the table, not zeroes
			console.log(changes);
		}else{
			changes.push({'quantity': quantity_new, 'status':'cart'});
			console.log(changes);
		}

		resultsobject = '';
		$.ajax({  
			type: "PUT",  
			url: "{{ Functions::root() }}/items/"+itemx.data('id'),  
			data: changes['0'],
			dataType: "json",
			success: function(results) {
				// console.log(results);
				resultsobject = results;
				// quantitybox.children('span.updating').html(function() {
				// 	if(quantity_new ==0){
				// 		$(this).html("delete");
				// 	}
				// })
				quantitybox.children('.temp').remove();
				if(resultsobject['success']){
					if(quantity_new ==0){
						quantitybox.append('<a class="temp delete" href="{{ Functions::root() }}/cart">delete</a>');
					}
				}
        		
        	}
		});


		//incase quantity_new is zero, delete

		$('.delete').on('click', function(elem) {
			elem.preventDefault();
			var title = "Confirm";
			var message = "Are you sure you want to delete?";
			var itemid = itemx.data("id");


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
		            td = del.parent('td');
		            del.remove();
		            td.append('<span>deleting...</span>');
		            itemspecs = td.parent('tr').next();
		            td.parent('tr').slideToggle("2000");
		            itemspecs.slideToggle("2000");
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
