function nevigateToInbox(id, index){
	location.href = `/application/inbox?id=${id}&index=${index}`;
}

function newMessage(id, index){
	location.href = `/application/inbox/new.php?id=${id}`;
}