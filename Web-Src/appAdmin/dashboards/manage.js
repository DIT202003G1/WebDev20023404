function nevigateToID(id){
	document.location.href=`/appAdmin/search/?id=${id}`;
}

const tabs = ["Details", "Emails", "Addresses", "PhoneNum"];

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

function filterChange(){
	const filterVal = _id("filterVal").value;
	const filterType = _id("filterType").value;
	filter(filterVal,filterType)
}

function filter(filterVal, filterType){
	allStudents.forEach((i,j)=>{
		var result;
		switch(filterType){
			case "inclusive":
				result = filters["inclusive"](i["student_id"],filterVal) || filters["inclusive"](i["first_name"] + " " + i["last_name"] ,filterVal) || filters["inclusive"](i["first_name"] + " " + i["middle_name"] + " " + i["last_name"] ,filterVal);
			break;
			case "exclusive":
				result = filters["exclusive"](i["student_id"],filterVal) && filters["exclusive"](i["first_name"] + " " + i["last_name"] ,filterVal) && filters["exclusive"](i["first_name"] + " " + i["middle_name"] + " " + i["last_name"] ,filterVal);
			break;
			case "courseinclusive":
				result = filters["inclusive"](i["course_id"],filterVal); 
			break;
			case "courseexclusive":
				result = filters["exclusive"](i["course_id"],filterVal); 
			break;
			case "intakeinclusive":
				result = filters["inclusive"](i["intake"],filterVal); 
			break;
			case "intakeexclusive":
				result = filters["exclusive"](i["intake"],filterVal); 
			break;
		}
		if (result){
			_show(`listitem_${i['student_id']}`);
		}
		else{
			_hide(`listitem_${i['student_id']}`);
		}
	})
}

function init(){
	switchTab("Details");
}