export const getBaseURL = () => {
	let url = unescape(window.location.href);
	if (url.includes("?")) {
		url = url.split("?")[0];
	}
	const activate = url.split("/");
	return activate[0] + "//" + activate[2] + "/" + activate[3] + "/";
};

export const API_ENDPOINT = getBaseURL() + "api/";
export const SOME_OTHER_GLOBAL = "valor";
