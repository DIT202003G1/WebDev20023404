
function init(){
	_hide("update-email-cancel");
	_hide("update-phone-cancel");
	_hide("update-address-cancel");
	_hide("update-email-submit");
	_hide("update-phone-submit");
	_hide("update-address-submit");
	_hide("update-email-add");
	_hide("update-phone-add");
	_hide("update-address-add");
}

function addRow(id){
	var index = 0;
	for(let i in _id(id).childNodes){ const node = _id(id).childNodes[i];
		if (node.nodeType === 1 && node.className !== "header"){
			index ++;
		}
	}
	switch (id){
		case "email":
			_id(id).innerHTML +=`
				<tr id="email_${index}">
					<td class="description"><input text="text" name="description_${index}"/></td>
					<td class="content"><input type="text" name="content_${index}"/></td>
					<td class="shown"><input type="checkbox" name="hidden_${index}"/></td>
				</tr>
			`;
		break;
		case "phone":
			_id(id).innerHTML +=`
				<tr id="phone_${index}">
					<td class="description"><input text="text" name="description_${index}"/></td>
					<td class="content"><input type="text" name="content_${index}"/></td>
					<td class="shown"><input type="checkbox" name="hidden_${index}"/></td>
				</tr>
			`;
		break;
		case "address":
			_id(id).innerHTML +=`
				<tr id="address_${index}">
					<td class="description"><input text="text" name="description_${index}"/></td>
					<td class="address"><input type="text" name="address_${index}"/></td>
					<td class="city"><input type="text" name="city_${index}"/></td>
					<td class="state"><input type="text" name="state_${index}"/></td>
					<td class="country"><input type="text" name="country_${index}"/></td>
					<td class="shown"><input type="checkbox" name="hidden_${index}"/></td>
				</tr>
			`;
		break;
	}
}

function rowToInput(id){
	var index = 0;
	for(let i in _id(id).childNodes){ const node = _id(id).childNodes[i];
		if (node.nodeType === 1 && node.className !== "header") {
			for(let j in node.childNodes){ const innerNode = node.childNodes[j];
				if (innerNode.nodeType === 1) {
					var name = innerNode.className;
					var value = _getTxt(innerNode);
					if (innerNode.className === "shown"){
						_setNode(innerNode, _node(`<input type="checkbox" name="hidden_${index}">`));
					}
					else if(innerNode.className === "hidden"){
						_setNode(innerNode, _node(`<input type="checkbox" name="hidden_${index}" checked>`));
					}
					else{
						_setNode(innerNode, _node(`<input type="text" name="${name}_${index}" value="${value}" />`));
					}
				}
			}
			index ++;
		}
	}
	_id(id).onchange = onKeyDown(id);
}

function showEmailUpdate(){
	_show("update-email-cancel");
	_show("update-email-submit");
	_show("update-email-add");
	_hide("update-email-show");
	rowToInput("email");
}

function showPhoneUpdate(){
	_show("update-phone-cancel");
	_show("update-phone-submit");
	_show("update-phone-add");
	_hide("update-phone-show");
	rowToInput("phone");
}

function showAddressUpdate(){
	_show("update-address-cancel");
	_show("update-address-submit");
	_show("update-address-add");
	_hide("update-address-show");
	rowToInput("address");
}

function reload(){
	location.reload();
}
