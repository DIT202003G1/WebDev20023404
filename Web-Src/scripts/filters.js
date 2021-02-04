const filters = {
	"inclusive":(val, filterVal)=>{
		const lVal = val.toLowerCase().trim();
		const lfVal = filterVal.toLowerCase().trim();
		return lVal.includes(lfVal);
	},
	"exclusive":(val, filterVal)=>{
		const lVal = val.toLowerCase().trim();
		const lfVal = filterVal.toLowerCase().trim();
		if (!lfVal){
			return true;
		}
		return !lVal.includes(lfVal);
	}
}
