function nevigateToID(id){
	document.location.href = `/application/view/?id=${id}`;
}

function nevigateToOptions(){
	document.location.href = `/application/options`;
}

function logout(){
	document.location.href = `/php-includes/logout.inc.php`;
}

function addBookmark(id){
	document.location.href = `/php-includes/appUtils/bookmarks.inc.php?action=add&id=${id}`;
}

function removeBookmark(id){
	document.location.href = `/php-includes/appUtils/bookmarks.inc.php?action=remove&id=${id}`;
}