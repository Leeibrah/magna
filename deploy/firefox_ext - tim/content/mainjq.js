/**
 *
 *@Author - Timothy Mwirabua
 *@Twitter - TechyTimo
 *@Email - techytimo@gmail.com
 *
 * Date: 8/4/13
 * Time: 9:06 PM
 * Description: VituMob.com firefox extension script
 *
 * Copyright (C) 2013
 * @Version - 0.9.1
 */

$(window).on('load', function() { //insert plugin on the browser bar 
	$(this).off('load');
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
})

var vitu = {};
// change this above too, hostname = ""
vitu.serverUrl = "http://www.vitumob.com/";
vitu.merchants = {};

$.get(vitu.serverUrl + "static/merchants.json", function(json) {
	vitu.merchants = json;
	var p1, p2;
	for (host in vitu.merchants) {
		p1 = window.atob(vitu.merchants[host].parser); // decrypts 64bit string into a stringified function "function() {...}"
		eval("p2 = " + p1 + ";"); //evaluates the sting and finds out its a fn then assigns the function to p2
		vitu.merchants[host].parser = p2;
	}
}, "json")

vitu.getHost = function(uri) {
	var host = uri.host.split('.').slice(-2).join('.');
	if (host === "yahoo.net" && uri.spec.substr(uri.spec.indexOf(host) + 10, 18) === "yhst-7223899490465") host = "worldsoccershop.com";
	if (host === "yahoo.net" && uri.spec.substr(uri.spec.indexOf(host) + 10, 18) === "yhst-3213199514187") host = "worldrugbyshop.com";
	return host;
};

vitu.statusTimer = undefined;
vitu.updateStatus =  function(status, close) {
	if(!$('#vitu-status')) return;
	$('#vitu-status').text(status);
	clearTimeout(vitu.statusTimer);
	if (close) vitu.statusTimer = setTimeout(function() { document.getElementById('vitu-panel').hidePopup(); }, close * 1000);
}

vitu.onMessage = function(ev) {
	if (ev.data.verb === 'fetch') {
		var host =  ev.data.host;
		var target = vitu.merchants[host].cart;

        var protocol = host === "neimanmarcus.com" ? "post": "get";
        var dataTosend = host === 'neimanmarcus.com' ? {
            data: "$b64$eyJTaG93Q2FydFBhZ2VSZXEiOnsiY2F0YWxvZ1F1aWNrT3JkZXIiOiIiLCJzaG93QWxsU0ZMIjoiIn19",
            timestamp: Date.now()
        }: {};

        gBrowser.contentWindow.console.log(protocol, dataTosend);
        //Now use the prefered protocol to send data
        $[protocol](target, dataTosend, function(response) {
            vitu.updateStatus("parsing order...");
            var html = response;
            try {
                var bundle = vitu.merchants[host].parser(html);
                if (bundle.items.length) {
                    bundle['host'] = host;
                    vitu.updateStatus("loading shopping cart...", 2);
                    gBrowser.contentWindow.postMessage({
                        'verb': "post",
                        'target': vitu.serverUrl + "cart/",
                        'bundle': bundle
                    }, ev.origin);
                } else {
                    vitu.updateStatus("There are no items in your shopping cart.", 3);
                }
            } catch(er) {
                vitu.updateStatus("An error occurred reading your shopping cart.", 5);
                window.console.log("ERROR: " + er.message);
                gBrowser.contentWindow.console.log("ERROR: " + er.message);
            }
        }, "html");
	}
}

vitu.check = function() {
	var host = vitu.getHost(gBrowser.contentDocument.baseURIObject);
	var panel = $('#vitu-panel');
	panel.attr('align', 'start');
	panel.empty();
	if (host in vitu.merchants) {
		panel
            .append('<image src="chrome://vitumob/content/vitumob.jpg"/>')
            .append('<description>Loading order from ' + host + '.</description>')
            .append('<description id="vitu-status">refreshing cart items...</description>');
		clearTimeout(vitu.statusTimer);

        gBrowser.contentWindow.removeEventListener('message', vitu.onMessage, false);
        gBrowser.contentWindow.addEventListener('message', vitu.onMessage, true);

        //Load jQuery to the body to help embededJS
        var jq = gBrowser.contentDocument.createElement('script');
        jq.setAttribute('src', "chrome://vitumob/content/jquery-1.9.1.min.js");
        gBrowser.contentDocument.body.appendChild(jq);

        //Now load the embededJS
        var sc = gBrowser.contentDocument.createElement('script');
        sc.setAttribute('src', "chrome://vitumob/content/embedjq.js");
        gBrowser.contentDocument.body.appendChild(sc);
	} else {
		panel
            .append('<image src="chrome://vitumob/content/vitumob.jpg" />')
            .append('<description>Navigate to one of our supported websites and click this button again to purchase items in your shopping cart at that site.</description>')
            .append('<description id="vitu-link">Or click here to see items you\'ve already selected.</description>');
		// should change this to load in same tab
		$('#vitu-link').on('click', function() {
            document.getElementById('vitu-panel').hidePopup();
			gBrowser.selectedTab = gBrowser.addTab(vitu.serverUrl); 
		});
	}
}
