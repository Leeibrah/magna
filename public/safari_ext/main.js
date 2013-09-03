
// also change in home.js
var serverUrl = "http://www.vitumob.com/";
//var serverUrl = "http://localhost:8081/";
var merchants = {};

var xhr = new XMLHttpRequest();
xhr.open("GET", serverUrl + "merchants.json", true);
xhr.onreadystatechange = function() {
	if (xhr.readyState == 4) {
		merchants = window.JSON.parse(xhr.responseText);
		var p1, p2;
		for (host in merchants) {
			p1 = window.atob(merchants[host].parser);
			eval("p2 = " + p1 + ";");
			merchants[host].parser = p2;
		}
	}
};
xhr.send(null);

var getHost = function(url) {
	if (typeof(url) !== 'string') return null;
	var start = url.indexOf("//") + 2;
	var host = url.substring(start, url.indexOf('/', start)).split('.').slice(-2).join('.');
	if (host === "yahoo.net" && url.substr(url.indexOf(host) + 10, 18) === "yhst-7223899490465") host = "worldsoccershop.com";
    if (host === "yahoo.net" && url.substr(url.indexOf(host) + 10, 18) === "yhst-3213199514187") host = "worldrugbyshop.com";
	return host;
};

var statusTimer;

safari.application.addEventListener("popover", function(event) {
	var popover = event.target;
	if (popover.identifier !== 'vitu-popover') return;
	var host = getHost(safari.application.activeBrowserWindow.activeTab.url);
	var popoverBody = popover.contentWindow.document.body;
	if (host in merchants) {
		popoverBody.innerHTML = "<img src='logo.jpg'><p>Loading order from " + host + ".</p>";
		var status = popover.contentWindow.document.createElement('p');
		status.textContent = "refreshing cart items...";
		popoverBody.appendChild(status);
		
		var xhr = new XMLHttpRequest();
		if (host === 'neimanmarcus.com')
			xhr.open("POST", merchants[host].cart, true);
		else
			xhr.open("GET", merchants[host].cart, true);
		xhr.withCredentials = true;
		xhr.onreadystatechange = function() { if (xhr.readyState == 4) {
			try {
				status.textContent = "parsing order...";
//				window.console.log("response = " + xhr.responseText);
				var bundle = merchants[host].parser(xhr.responseText);
				window.console.log(JSON.stringify(bundle));
				if (bundle.items.length) {
					bundle['host'] = host;
//					bundle['merchant'] = merchants[host].name;
					status.textContent = "loading shopping cart...";
					statusTimer = setTimeout(function() { popover.hide(); }, 2000);
					safari.application.activeBrowserWindow.activeTab.page.dispatchMessage("post", { 'target': serverUrl + "cart", 'bundle': bundle });
				} else {
					status.textContent = "There are no items in your shopping cart.";
					statusTimer = setTimeout(function() { popover.hide(); }, 3000);
				}
			} catch(e) {
				status.textContent = "An error occurred reading your shopping cart.";
				statusTimer = setTimeout(function() { popover.hide(); }, 5000);
			}
		} };
		if (host === 'neimanmarcus.com') {
			xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
			// the part after '$b64$' is a base64 encoded json string
			xhr.send("data=$b64$eyJTaG93Q2FydFBhZ2VSZXEiOnsiY2F0YWxvZ1F1aWNrT3JkZXIiOiIiLCJzaG93QWxsU0ZMIjoiIn19&timestamp=" + Date.now());
		} else {
			xhr.send(null);
		}
	} else {
		popoverBody.innerHTML = "<img src='logo.jpg'>" + 
			"<p>Navigate to one of our supported websites and click this button again to purchase items in your shopping cart at that site.</p>";
		var p = popover.contentWindow.document.createElement('p');
		p.appendChild(popover.contentWindow.document.createTextNode("Or "));
		var l = popover.contentWindow.document.createElement('a');
		l.textContent = "click here to see items you've already selected";
		l.setAttribute('href', "#");
		l.addEventListener('click', function(e) {
			// should change this to load in the already open tab ???
			safari.application.activeBrowserWindow.openTab().url = "http://www.vitumob.com/cart";
			popover.hide();
			e.preventDefault();
		}, false);
		p.appendChild(l);
		p.appendChild(popover.contentWindow.document.createTextNode("."));
		popoverBody.appendChild(p);
	}
	clearTimeout(statusTimer);
}, true);
