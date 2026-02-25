(function () {
	const url = unescape(window.location.href);
	const activate = url.split("/");
	window.baseURL = `${activate[0]}//${activate[2]}/${activate[3]}/`;
})();
