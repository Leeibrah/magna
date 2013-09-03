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

var vitu;
if(!vitu) {
	vitu = true;
	window.addEventListener('message', function(e) {
		if(e.data.verb == "post") {
			$(document.body).append(
                '<form id="mycart" method="post" action="'+ e.data.target + '">' +
                    '<input type="hidden" name="bundle" value="">' +
                    '<input type="hidden" name="extension" value="firefox 0.9">' +
                '</form>'
            );
            $('form#mycart input:first-child').attr('value', JSON.stringify(e.data.bundle));
			setTimeout(function() { $('form#mycart').submit(); }, 500);
            window.console.log($('form#mycart input:first-child').val());
            window.console.log(JSON.stringify(e.data.bundle));
		}
	}, false);
}

var host = window.location.hostname.split('.').slice(-2).join('.');
if (host === "yahoo.net" && document.URL.substr(document.URL.indexOf(host) + 10, 18) === "yhst-7223899490465") host = "worldsoccershop.com";
if (host === "yahoo.net" && document.URL.substr(document.URL.indexOf(host) + 10, 18) === "yhst-3213199514187") host = "worldrugbyshop.com";

//alert("THE HOST: " + host); //[current status -- GREEN]
// sending cookie is now unnecessary
window.postMessage({'verb': "fetch", 'host': host, 'cookie': document.cookie}, '*');
