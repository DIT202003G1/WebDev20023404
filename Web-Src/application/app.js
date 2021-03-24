function nevigateToID(id){
	document.location.href = `/application/view/?id=${id}`;
}

function nevigateToOptions(){
	document.location.href = `/application/options`;
}

function logout(){
	document.location.href = `/php-includes/logout.inc.php`;
}

function addBookmark(id, return_uri = "/application") {
	document.location.href = `/php-includes/appUtils/bookmarks.inc.php?action=add&id=${id}&return_url=${return_uri}`;
}

function removeBookmark(id, return_uri = "/application") {
	document.location.href = `/php-includes/appUtils/bookmarks.inc.php?action=remove&id=${id}&return_uri=${return_uri}`;
}