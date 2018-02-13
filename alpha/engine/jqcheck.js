function cjq() {
if (typeof jQuery == 'undefined') {
   var script = document.createElement('script');
   script.type = "text/javascript";
   script.src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js";
   document.getElementsByTagName('head')[0].appendChild(script);
}
}
window.onload="cjq()";