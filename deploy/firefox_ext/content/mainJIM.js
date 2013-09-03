
window.addEventListener('load', function l() {
	window.removeEventListener("load", l, false);
	var toolbar = document.getElementById("nav-bar");
	toolbar.insertItem("vitumob");
	toolbar.setAttribute("currentset", toolbar.currentSet);
	document.persist(toolbar.id, "currentset");
	var appcontent = document.getElementById("appcontent");
    if (appcontent) {
		appcontent.addEventListener("DOMContentLoaded", function(e) {
			var doc = e.originalTarget;
			if (doc.nodeName != "#document") return;
			if (doc.location.hostname != "www.vitumob.com" || doc.location.pathname != "/beta") return;
            doc.getElementById('main').removeChild(doc.getElementById('download'))
      }, true);
    }
}, false);

var vitu = {};

// change this above too, hostname = ""
vitu.serverUrl = "http://www.vitumob.com/";

vitu.merchants = {};

var xhr = new XMLHttpRequest();
xhr.open("GET", vitu.serverUrl + "static/merchants.json", true);
xhr.onreadystatechange = function() {
	if (xhr.readyState == 4) {
		vitu.merchants = JSON.parse(xhr.responseText);
		var p1, p2;
		for (host in vitu.merchants) {
			p1 = window.atob(vitu.merchants[host].parser);
			eval("p2 = " + p1 + ";");
			vitu.merchants[host].parser = p2;
		}
	}
};
xhr.send(null);

vitu.getHost = function(uri) {
	var host = uri.host.split('.').slice(-2).join('.');
	if (host === "yahoo.net" && uri.spec.substr(uri.spec.indexOf(host) + 10, 18) === "yhst-7223899490465") host = "worldsoccershop.com";
	if (host === "yahoo.net" && uri.spec.substr(uri.spec.indexOf(host) + 10, 18) === "yhst-3213199514187") host = "worldrugbyshop.com";
	return host;
};

vitu.statusTimer = undefined;

vitu.updateStatus = function(status, close) {
	var statusP = document.getElementById('vitu-status');
	if (!statusP) return;
	statusP.textContent = status;
	clearTimeout(vitu.statusTimer);
	if (close) vitu.statusTimer = setTimeout(function() { document.getElementById('vitu-panel').hidePopup(); }, close * 1000);
};

vitu.onMessage = function(event) {
	if (event.data.verb === 'fetch') {
		var host = event.data.host;
		var target = vitu.merchants[host].cart;

        // get cookie
        var ios = Components.classes["@mozilla.org/network/io-service;1"].getService(Components.interfaces.nsIIOService);
        var uri = ios.newURI(target, null, null);
        var cookieSvc = Components.classes["@mozilla.org/cookieService;1"].getService(Components.interfaces.nsICookieService);
        var cookie = cookieSvc.getCookieString(uri, null);

//		gBrowser.contentWindow.console.log("refreshing cart from " + target);
		var xhr = new XMLHttpRequest();
		if (host === 'neimanmarcus.com')
			xhr.open("POST", target, true);
		else
			xhr.open("GET", target, true);
		xhr.withCredentials = true;
		xhr.setRequestHeader('Cookie', cookie); // event.data.cookie
		xhr.onreadystatechange = function() { if (xhr.readyState == 4) {
			vitu.updateStatus("parsing order...");
			var html = xhr.responseText;
			try {
				var bundle = vitu.merchants[host].parser(html);
				if (bundle.items.length) {
					bundle['host'] = host;
					vitu.updateStatus("loading shopping cart...", 2);
					gBrowser.contentWindow.postMessage({ 'verb': "post", 'target': vitu.serverUrl + "cart", 'bundle': bundle }, event.origin);
				} else {
					vitu.updateStatus("There are no items in your shopping cart.", 3);
				}
			} catch(er) {
				vitu.updateStatus("An error occurred reading your shopping cart.", 5);
				window.console.log("ERROR: " + er.message);
				gBrowser.contentWindow.console.log("ERROR: " + er.message);
			}
		} };
		if (host === 'neimanmarcus.com') {
			xhr.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
			// the part after '$b64$' is a base64 encoded json string
			xhr.send("data=$b64$eyJTaG93Q2FydFBhZ2VSZXEiOnsiY2F0YWxvZ1F1aWNrT3JkZXIiOiIiLCJzaG93QWxsU0ZMIjoiIn19&timestamp=" + Date.now());
		} else {
			xhr.send(null);
		}
	}
};

vitu.check = function() {
	var host = vitu.getHost(gBrowser.contentDocument.baseURIObject);
	var panel = document.getElementById('vitu-panel');
	panel.setAttribute('align', 'start');
	for (var i=panel.childNodes.length; i>0; i-=1) panel.removeChild(panel.childNodes[i-1]);
	if (host in vitu.merchants) {
		var e1 = document.createElement('image');
		e1.setAttribute('src', "chrome://vitumob/content/vitumob.jpg");
		panel.appendChild(e1);
		var l = document.createElement('description');
		l.textContent = "Loading order from " + host + ".";
		panel.appendChild(l);
		var status = document.createElement('description');
		status.setAttribute('id', "vitu-status");
		status.textContent = "refreshing cart items...";
		panel.appendChild(status);
		clearTimeout(vitu.statusTimer);

		gBrowser.contentWindow.removeEventListener('message', vitu.onMessage, false);
		gBrowser.contentWindow.addEventListener('message', vitu.onMessage, false, true);	// this true is required: see https://developer.mozilla.org/en-US/docs/Code_snippets/Interaction_between_privileged_and_non-privileged_pages

		var sc = gBrowser.contentDocument.createElement('script');
		sc.setAttribute('src', "chrome://vitumob/content/embed.js");
		gBrowser.contentDocument.body.appendChild(sc);

	} else {
		var e1 = document.createElement('image');
		e1.setAttribute('src', "chrome://vitumob/content/vitumob.jpg");
		panel.appendChild(e1);
		var e2 = document.createElement('description');
		e2.textContent = "Navigate to one of our supported websites and click this button again to purchase items in your shopping cart at that site.";
		panel.appendChild(e2);
		var e3 = document.createElement('description');
		e3.textContent = "Or click here to see items you've already selected.";
		e3.setAttribute('id', "vitu-link");
		// should change this to load in same tab
		e3.addEventListener('click', function() { panel.hidePopup(); gBrowser.selectedTab = gBrowser.addTab(vitu.serverUrl); }, false);
		panel.appendChild(e3);
	}
};
