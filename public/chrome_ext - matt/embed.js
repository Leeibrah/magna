console.log("hello from embed.js outside addListener");
chrome.extension.onMessage.addListener(function(request) {
	console.log("hello from embed.js in addListener");
	if (request.verb !== 'post') return;

	var form = document.createElement('form');
	form.action= request.target;
	form.method='post';

	var bundle = document.createElement('input');
	bundle.type='hidden';
	bundle.name='bundle';
	bundle.value = window.escape(JSON.stringify(request.bundle));
	form.appendChild(bundle);

	var extension = document.createElement('input');
	extension.type='hidden';
	extension.name='extension';
	extension.value = "chrome 0.9";
	form.appendChild(extension);

	console.log(bundle.value);

	form.submit();
});
