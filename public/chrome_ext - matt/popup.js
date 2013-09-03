chrome.tabs.executeScript(null, {file: "embed.js"});
console.log("hello from popup.js");
var timer;
chrome.extension.onMessage.addListener(function(request) {
	if (request.verb !== 'update' || !request.status) return;
	document.getElementById('status').innerText = request.status;
	clearTimeout(timer);
	if (request.close) timer = setTimeout(function() { window.close(); }, request.close * 1000);
});
chrome.extension.getBackgroundPage().buttonWasClicked(document);
