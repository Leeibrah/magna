
var serverUrl = "http://www.vitumob.com/";
var merchants = {};

var parser = document.createElement('iframe');
parser.src = chrome.extension.getURL('parse.html');
document.body.appendChild(parser);

var xhr = new XMLHttpRequest();
xhr.open("GET", serverUrl + "static/merchants.json", true);
xhr.onreadystatechange = function() {
	if (xhr.readyState == 4) {
		merchants = JSON.parse(xhr.responseText);
		for (host in merchants)
			parser.contentWindow.postMessage({ 'verb': "set", 'host': host, 'parser': window.atob(merchants[host].parser) }, '*');
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

var status;

buttonWasClicked = function(popup) {
	chrome.tabs.getSelected(null, function(tab) {
		var host = getHost(tab.url);
		if (host in merchants) {
			popup.body.innerHTML = "<img src='logo.png'><p>Loading order from " + host + ".</p><p id='status'>refreshing cart items...</p>";
			
			var xhr = new XMLHttpRequest();
			if (host === 'neimanmarcus.com')
				xhr.open("POST", merchants[host].cart, true);
			else
				xhr.open("GET", merchants[host].cart, true);
			xhr.withCredentials = true;
			xhr.onreadystatechange = function() { if (xhr.readyState == 4) {
//                window.console.log(xhr.responseText);
				chrome.extension.sendMessage(null, { 'verb': "update", 'status': "parsing order..." });
				parser.contentWindow.postMessage({ 'verb': "parse", 'tab': tab, 'host': host, 'html': xhr.responseText }, '*');
			} };
			if (host === 'neimanmarcus.com') {
				xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
				// the part after '$b64$' is a base64 encoded json string
				xhr.send("data=$b64$eyJTaG93Q2FydFBhZ2VSZXEiOnsiY2F0YWxvZ1F1aWNrT3JkZXIiOiIiLCJzaG93QWxsU0ZMIjoiIn19&timestamp=" + Date.now());
			} else {
				xhr.send(null);
			}
		} else {
			status = null;
		}
	});
};

window.addEventListener('message', function(event) {
	if (event.data.verb === 'post') {
		var bundle = event.data.bundle;
//		bundle['merchant'] = merchants[bundle.host].name;
		if (bundle.items.length) {
			chrome.extension.sendMessage(null, { 'verb': "update", 'status': "loading shopping cart...", 'close': 2 });
			chrome.tabs.sendMessage(event.data.tab.id, { 'verb': "post", 'bundle': bundle, 'target': serverUrl + "cart" });
		} else
			chrome.extension.sendMessage(null, { 'verb': "update", 'status': "There are no items in your shopping cart.", 'close': 3 });
	} else if (event.data.verb === 'error') {
		chrome.extension.sendMessage(null, { 'verb': "update", 'status': "An error occurred reading your shopping cart.", 'close': 3 });
		var xhr = new XMLHttpRequest();
		xhr.open("GET", serverUrl + "error/" + encodeURIComponent(event.data.error), true);
		xhr.withCredentials = true;
		xhr.send();
	}
});
