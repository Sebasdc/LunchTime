var timer;
// Roepen de generateMessage aan met een specifieke message en class.
function throwError(msg){
	generateMessage("Foutmelding: " + msg, 'msg_error');
}
function throwInfo(msg){
	generateMessage("Info: " + msg, 'msg_info');
}
function throwWarning(msg){
	generateMessage("Waarschuwing: " + msg,'msg_warning');
}

// Maakt een Message en roept de functie resetTimer aan.
function generateMessage(msg, Class){
	Class = (Class) ? Class : '';
	new Message(msg, Class);
	console.log(msg);
	resetTimer();
}

// Maakt een nieuwe message aan met de gegeven class.
function Message(msg, Class){
	$(".messages_bar").append("<div class='"+Class+"'>" + msg + "</div>");
}

// Verwijdert de laatste message en roept de functie messagesLeft aan.
function removeLastMessage(){
	var message = $(".messages_bar div:first-child");
	$(message).addClass('deactivated');
	setTimeout(function(){
		message.remove();
	}, 1000);
	messagesLeft();
}

// Roept de functie messagesLeft aan zodra de pagina is geladen.
$(document).ready(function(){
	messagesLeft();
});

// Zet een timeout op 2 seconden die de functie removeLastMessage aanroept.
function setTimer(){
	timer = setTimeout(function(){
		removeLastMessage();
	}, 5000);
}

// Vernieuwd de timeout.
function resetTimer(){
	clearTimeout(timer);
	setTimer();
}

// Checkt of er nog errors over zijn. Als dat zo is, dan triggert hij de functie setTimer.
function messagesLeft()
{
	if($(".messages_bar").children.length > 0){
		setTimer();
	}
}