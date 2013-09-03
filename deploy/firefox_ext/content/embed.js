
var vitu;

if (!vitu) {
	vitu = true;
	window.addEventListener('message', function(event) {

		if (event.data.verb === 'post') {

			var form = document.createElement('form');
			form.action= event.data.target;
			form.method='post';
//			form.style.display = "none";

			/*
			 * This is needed because some sites (which use the Prototype.js library) (such as davidsbridal.com)
			 * override Array.prototype.toJSON in a bad way.
			 * JSON.stringify will use an object's toJSON method, if it exists.
			 */
			Array.prototype.toJSON = undefined;

			var bundle = document.createElement('input');
			bundle.type='hidden';
			bundle.name='bundle';
			bundle.value = window.escape(JSON.stringify(event.data.bundle));
			form.appendChild(bundle);
			
			var extension = document.createElement('input');
			extension.type='hidden';
			extension.name='extension';
			extension.value = "firefox 0.9";
			form.appendChild(extension);
		
			document.body.appendChild(form);	// needed for Firefox
			form.submit();
		}
	}, false);
}

var host = window.location.hostname.split('.').slice(-2).join('.');
if (host === "yahoo.net" && document.URL.substr(document.URL.indexOf(host) + 10, 18) === "yhst-7223899490465") host = "worldsoccershop.com";
if (host === "yahoo.net" && document.URL.substr(document.URL.indexOf(host) + 10, 18) === "yhst-3213199514187") host = "worldrugbyshop.com";

// sending cookie is now unnecessary
window.postMessage({ 'verb': "fetch", 'host': host, 'cookie': document.cookie }, '*');
