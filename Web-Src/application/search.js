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
			if (!("misc" in ast)){
				ast["misc"] = [];
			}
			ast["misc"].push(args[i].toLowerCase());
		}
	}
	return ast;
}