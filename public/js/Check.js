$(document).ready(function(){
	$(".shoppinglist tr").click(function(){
		checkItem($(this).data("id"), this);
	});
});

// Check an item.
function checkItem(item_id, row)
{
	// Toggle van te voren alvast de class zodat de user instant feedback krijgt.
	$(row).toggleClass('active');
	$.get(document.URL + '/item/' + item_id + '/check').done(function(response){
		response = response.split('||');
		if(response[0] == "Success"){
			if(response[1]) // Het item is aangevinkt!
				$(row).addClass("active");
			else
				$(row).removeClass("active");
		}
		else{
			throwError(response);
		}
	});
}