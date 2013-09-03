var vitu = {};

vitu.exchangeRate = parseFloat(document.getElementById('cart').getAttribute('data-exchange-rate'));

vitu.toUSDString = function(usd) { return "$" + usd.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","); };
vitu.toKShString = function(usd) { return Math.round(usd * vitu.exchangeRate).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); };

vitu.changeQuantity = function(input) {
	var quantity = parseInt(input.value);
	if (isNaN(quantity) || quantity < 0) quantity = 0;
	input.value = quantity;
	input.setAttribute('value', quantity);
	var tr = input.parentNode.parentNode.parentNode;
	tr.setAttribute('data-quantity', quantity);

    var merchantHost = tr.parentNode.getAttribute('data-merchant');
	var itemId = tr.getAttribute('data-item-id');
	var request = new XMLHttpRequest();
	request.open('PUT', "/items?merchant=" + merchantHost + "&item=" + itemId, true);
	request.send(quantity);
	
	vitu.updateTotals();
};

vitu.fadeAwayElement = function(ele) {
	var fadeEnd = function() { ele.parentNode.removeChild(ele); vitu.updateTotals(); };
	ele.addEventListener("transitionend", fadeEnd, false);
	ele.addEventListener("webkitTransitionEnd", fadeEnd, false);
	ele.style.opacity = 0;
};

vitu.deleteItem = function(link) {
	var tr = link.parentNode.parentNode.parentNode;
    var merchantHost = tr.parentNode.getAttribute('data-merchant');
	var itemId = tr.getAttribute('data-item-id');
	var request = new XMLHttpRequest();
	request.open('DELETE', "/items?merchant=" + merchantHost + "&item=" + itemId, true);
	request.send(null);
	vitu.fadeAwayElement(tr.parentNode.children.length == 2 ? tr.parentNode : tr);
};

vitu.updateTotals = function() {
    var itemRows = document.querySelectorAll("tr.item");
    if (!itemRows.length) {
        document.getElementById('main').innerHTML = "<div id='notice'><p>There are no items in your VituMob shopping cart.</p></div>";
    	return;
    }
	var subtotal = 0;
	var customs = 0;
	var electronics = 0;
	var vat = 0;
	Array.prototype.forEach.call(document.querySelectorAll("tr.item"), function(item) {
		var quantity = parseInt(item.getAttribute('data-quantity'));
		var price = parseFloat(item.getAttribute('data-price-usd'));
		var itemSubtotal = quantity * price
		subtotal += itemSubtotal;
		var customsRate = parseFloat(item.getAttribute('data-customs'));
		if (customsRate) {
			customs += itemSubtotal * customsRate * 1.025;	// to cover IDF
			vat += itemSubtotal * 0.16;
		} else
			electronics += itemSubtotal;
	});

	subtotal = Math.round(subtotal * 100) / 100
	document.getElementById('subtotal-usd').textContent = vitu.toUSDString(subtotal);
	document.getElementById('subtotal-ksh').textContent = vitu.toKShString(subtotal);
	
	document.getElementById('subtotal-usd-fld').value = vitu.toUSDString(subtotal);
	document.getElementById('subtotal-ksh-fld').value = vitu.toKShString(subtotal);

	if (electronics) {
		var electronicsImport = electronics * 0.0225;
		if (electronicsImport < 12) electronicsImport = 12;
		customs += electronicsImport;
	}
	
	customs = Math.round(customs * 100) / 100
	document.getElementById('customs-usd').textContent = vitu.toUSDString(customs);
	document.getElementById('customs-ksh').textContent = vitu.toKShString(customs);
	
	document.getElementById('customs-usd-fld').value = vitu.toUSDString(customs);
	document.getElementById('customs-ksh-fld').value = vitu.toKShString(customs);

	var shipping = (subtotal + customs) * 0.12;
	if (shipping) {
		var minShipping = 10 + (5 * document.querySelectorAll("tbody").length);
		if (shipping < minShipping) shipping = minShipping;
	}

	shipping = Math.round(shipping * 100) / 100
	document.getElementById('shipping-usd').textContent = vitu.toUSDString(shipping);
	document.getElementById('shipping-ksh').textContent = vitu.toKShString(shipping);
	
	document.getElementById('shipping-usd-fld').value = vitu.toUSDString(shipping);
	document.getElementById('shipping-ksh-fld').value = vitu.toKShString(shipping);

	vat = Math.round(vat * 100) / 100
	document.getElementById('vat-usd').textContent = vitu.toUSDString(vat);
	document.getElementById('vat-ksh').textContent = vitu.toKShString(vat);
	
	document.getElementById('vat-usd-fld').value = vitu.toUSDString(vat);
	document.getElementById('vat-ksh-fld').value = vitu.toKShString(vat);

	var total = Math.round((subtotal + customs + shipping + vat) * 100) / 100;
	document.getElementById('total-usd').textContent = vitu.toUSDString(total);
	document.getElementById('total-ksh').textContent = vitu.toKShString(total);
	
	document.getElementById('total-usd-fld').value = vitu.toUSDString(total);
	document.getElementById('total-ksh-fld').value = vitu.toKShString(total);
};

vitu.updateTotals();

// this is inefficient; rewrite functions so they take the event as their parameter, then no need to create anonymous functions
Array.prototype.forEach.call(document.getElementsByTagName('input'), function(input) { input.addEventListener('change', function() { vitu.changeQuantity(input) }, false) });
Array.prototype.forEach.call(document.getElementsByClassName('delete'), function(span) { span.addEventListener('click', function() { vitu.deleteItem(span) }, false) });