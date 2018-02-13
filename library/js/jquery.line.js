$(document).ready(function() {
call();retreive();
$(".opt_panel").click(function(){
var engine = 1;
	if(engine == 1) {
		engine = 0;
		$( ".opt_panel i" ).removeClass( "fa-eye" ).addClass( "fa-eye-slash" );
		$('.opt_panel').prop('title', 'Chat Visibility Off');
		$.post("/system/config.line.php?action=dvis");
	}
	else if(engine == 0) {
		engine = 1;
		$( ".opt_panel i" ).removeClass( "fa-eye-slash" ).addClass( "fa-eye" );
		$('.opt_panel').prop('title', 'Chat Visibility On');
		$.post("/system/config.line.php?action=evis");
	}
});
});
setInterval("call()", 3000);
var engine = 1;
function call() 
{
if (engine == 1){ 
$.post("/system/config.line.php?action=call");
}
else if (engine == 0){
return false;
}
} 
setInterval("retreive()", 5000);
function retreive() 
{ 
$.post("/system/config.line.php?action=retreive", function(list) 
{ $(".online-listing").html(list); }); 
} 