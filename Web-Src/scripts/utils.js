function _id(id){
	return document.getElementById(id);
}
function _hide(id){
	_id(id).style.display = "none";
}
function _show(id){
	_id(id).style.display = "";
}
function _str(text){
	return document.createTextNode(text);
}
function _hasNode(node){
	return (!! node.childNodes);
}
function _getTxt(node){
	if (_hasNode(node)){
		return node.childNodes[0].wholeText;
	}
	return "";
}
function _setNode(node,newNode){
	if (_hasNode(node)){
		if (typeof(newNode) === "string"){
			node.replaceChild(_str(newNode),node.childNodes[0]);
		}
		else{
			node.replaceChild(newNode,node.childNodes[0]);
		}
		return;
	}
	if (typeof(newNode) === "string"){
		node.appendChild(_str(newNode));
	}
	else{
		node.appendChild(newNode);
	}
}
function _node(htmlString) {
	var div = document.createElement('div');
	div.innerHTML = htmlString.trim();
	return div.childNodes[0];
}