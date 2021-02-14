function parseSearch(raw){
	const args = raw.split(" ");
	var ast = {};
	for (let i in args){
		if (args[i].includes(":")){
			const argKeyVals = args[i].toLowerCase().split(":");
			if (!(argKeyVals[0] in ast)){
				ast[argKeyVals[0]] = [];
			}
			ast[argKeyVals[0]].push(argKeyVals[1]);
		}else{
			if (!("_misc" in ast)){
				ast["_misc"] = [];
			}
			ast["_misc"].push(args[i].toLowerCase());
		}
	}
	return ast;
}
function encodeSearch(ast){
	var urlEncodes = [];
	for (let i in ast){
		val = ast[i].join(",");
		urlEncodes.push(`${i}=${val}`);
	}
	return urlEncodes.join("&")
}
function registerKeyPressEvent(){
	_id("search").addEventListener("keydown",(e)=>{
		if (e.key === "Enter"){
			const parsed = parseSearch(e.target.value);
			const urlEncoded = encodeSearch(parsed);
			document.location.href = `/application/search?${urlEncoded}`;
		}
	})
}

