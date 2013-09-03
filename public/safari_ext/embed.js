if (window.top === window) {
//	window.console.log("adding event listener");
	safari.self.addEventListener("message", function(event) {
		if (event.name !== 'post') return;
//		window.console.log("received post message");
	
		var form = document.createElement('form');
		form.action = event.message.target;
		form.method = 'post';
	
		var bundle = document.createElement('input');
		bundle.type = 'hidden';
		bundle.name = 'bundle';
		Array.prototype.toJSON = undefined;
		bundle.value = window.escape(JSON.stringify(event.message.bundle));
		form.appendChild(bundle);
	
		var extension = document.createElement('input');
		extension.type='hidden';
		extension.name='extension';
		extension.value = "safari 0.9";
		form.appendChild(extension);
	
		form.submit();
	}, false);
}
//window.console.log(document.cookie);
