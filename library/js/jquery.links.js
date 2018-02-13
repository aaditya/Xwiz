$(document).ready(function() { 
	$("a").click(function(event) {
		var href = $(this).attr("href");
		if(typeof href === 'undefined'){}
		else{
		var key = ['logout'];
		if($.inArray(href, key) !== -1){}
		else {
		event.preventDefault();
		NProgress.start();
		window.history.pushState('obj','newtitle',''+href+'');
		/* Add Loader Code here */
		$("#canvas").html("").load(href);
		NProgress.done();
		}}});
});
function back() {
window.onhashchange = function() {
    if (window.innerDocClick) {
        window.innerDocClick = false;
    } else {
        if (window.location.hash != '#undefined') {
            goBack();
        } else {
            history.pushState("", document.title, window.location.pathname);
            location.reload();
        }
    }
}
}
function clink() {window.history.pushState('obj','newtitle',''+''+'/');}
function execute(event) {$.ajax({type: "POST",url: '/engine/exe.xs.php',data:{action: event},});location.reload();}
