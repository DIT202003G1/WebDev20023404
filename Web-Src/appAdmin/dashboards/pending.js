const postAction = "/php-includes/adminUtils/pending-approve.inc.php";


function init(pendingApplications,showReject){
	if (showReject){
		showRejectedApplication(pendingApplications);
		_id("rejected").checked = true;
	}else{
		hideRejectedApplication(pendingApplications);
		_id("rejected").checked = false;
	}
}
function nevigateToID(id,regid,showReject){
	document.location.href = `/appAdmin/pending/?id=${id}&regid=${regid}` + (showReject ? "&showReject=true" : "");
}
function toggleRejectedApplication(pendingApplications){
	if(_id("rejected").checked){
		showRejectedApplication(pendingApplications);
	}else{
		hideRejectedApplication(pendingApplications);
	}
	var type = _id("filterType").value;
	if (type == "none"){
		type = "inclusive";
	}
	filter(_id("filterVal").value,type, pendingApplications);
}
function hideResult(id,regid){
	var id_name = `listitem_${id}_${regid}`;
	_hide(id_name);
}
function showResult(id,regid){
	var id_name = `listitem_${id}_${regid}`;
	_show(id_name,"block");
}
function hideRejectedApplication(applications){
	applications.forEach((i,j)=>{
		var id_name = `listitem_${i.student_id}_${i.reg_id}`;
		if (parseInt(i["pending"]) != 1){
			_hide(id_name);
		}
		_id(id_name).addEventListener("click",()=>{nevigateToID(i.student_id, i.reg_id, false)});
		_id("ad").action = postAction;
	});
}
function showRejectedApplication(applications){
	applications.forEach((i,j)=>{
		var id_name = `listitem_${i.student_id}_${i.reg_id}`;
		if (parseInt(i["pending"]) != 1){
			_show(id_name);
		}
		_id(id_name).addEventListener("click",()=>{nevigateToID(i.student_id, i.reg_id, true)});
		_id("ad").action = postAction + "?showReject=true";
	});
}

/// FILTER OPTIONS
function filterOnChange(pendingApplications){
	var type = _id("filterType").value;
	if (type == "none"){
		type = "inclusive";
	}
	filter(_id("filterVal").value,type, pendingApplications);
}
function filterTypeChange(pendingApplications){
	filterOnChange(pendingApplications);
}
var inclusive = (text, userObj)=>{
	return userObj["student_id"].toLowerCase().includes(text.toLowerCase()) || `${userObj["first_name"]} ${userObj["first_name"]}`.toLowerCase().includes(text.toLowerCase()) || `${userObj["first_name"]} ${userObj["middle_name"]} ${userObj["last_name"]}`.toLowerCase().includes(text.toLowerCase());
}
var exclusive = (text, userObj)=>{
	// return !(!userObj["student_id"].toLowerCase().includes(text.toLowerCase())) || (!`${userObj["first_name"]} ${userObj["first_name"]}`.toLowerCase().includes(text.toLowerCase())) || (!`${userObj["first_name"]} ${userObj["middle_name"]} ${userObj["last_name"]}`.toLowerCase().includes(text.toLowerCase()));
	if (!text){
		return true;
	}
	const case1 = userObj["student_id"].toLowerCase().includes(text.toLowerCase());
	const case2 = `${userObj["first_name"]} ${userObj["first_name"]}`.toLowerCase().includes(text.toLowerCase());
	const case3 = `${userObj["first_name"]} ${userObj["middle_name"]} ${userObj["first_name"]}`.toLowerCase().includes(text.toLowerCase());
	return ! (case1 || case2 || case3)
}
var courseinclusive = (text, userObj)=>{
	return userObj["course_id"].includes(text);
}
var courseexclusive = (text, userObj)=>{
	if (!text){
		return true;
	}
	return !userObj["course_id"].includes(text);
}
var intakeinclusive = (text, userObj)=>{
	return userObj["intake"].includes(text);
}
var intakeexclusive = (text, userObj)=>{
	if (!text){
		return true;
	}
	return !userObj["intake"].includes(text);
}

function filter(content,mode,applications){
	var processed = content.trim();
	var tests = {
		"inclusive":inclusive,
		"exclusive":exclusive,
		"courseinclusive":courseinclusive,
		"courseexclusive":courseexclusive,
		"intakeinclusive":intakeinclusive,
		"intakeexclusive":intakeexclusive,
	}
	applications.forEach((i,j)=>{
		var id_name = `listitem_${i.student_id}_${i.reg_id}`;
		if (tests[mode](processed,i)){
			_show(id_name);
		}else{
			_hide(id_name);
		}
		_id(id_name).addEventListener("click",()=>{nevigateToID(i.student_id, i.reg_id, true)});
	});
	if (!_id("rejected").checked) {
		hideRejectedApplication(pendingApplications);
	}
}