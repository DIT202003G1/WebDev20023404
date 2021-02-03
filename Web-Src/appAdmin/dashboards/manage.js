tabs = ["Details", "Emails", "Addresses", "PhoneNum"];
function switchTab(name){
	tabs.forEach((i,j)=>{
		if (i === name){
			_id(`tabsel_${i}`).classList.add("selected");
			_show(`tab_${i}`);
		}else{
			_id(`tabsel_${i}`).classList.remove("selected");
			_hide(`tab_${i}`);
		}
	});
}
function init(){
	switchTab("Details");
}