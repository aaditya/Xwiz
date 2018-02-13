<?php
$dir = $_SERVER['DOCUMENT_ROOT'];
$path = '/system/config.auth.php';
include_once $dir.$path;
$status = page_protect('engine');
header('Content-type: application/javascript');
?>
/* Vanilla JS for Page Ready */
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
function append(type,element,code) {
	if(type == 'tag') {
	document.getElementByTagName(element).innerHTML = code;
	}
	else if(type == 'id') {
	document.getElementById(element).innerHTML = code;
	}
	else if(type == 'class') {
	document.getElementByClassName(element).innerHTML = code;
	}

}
docReady(function() {
<?php
function secure() {
  if ( isset($_SERVER['HTTPS']) ) {
        if ( 'on' == strtolower($_SERVER['HTTPS']) )
            return 'secure';
        if ( '1' == $_SERVER['HTTPS'] )
            return 'secure';
    } elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
        return 'secure';
    }
    return 'normal';
}
?>
var host = '<?php echo $_SERVER['HTTP_HOST'];?>';
var h_type = '<?php echo secure();?>';
var h;
if(h_type == 'secure') {h = 'https://';}
else if(h_type == 'normal') {h = 'http://';}
append('tag','head','<link rel="stylesheet" type="text/css" href="'+h+host+'/engine/engine.css" />');
append('tag','head','<link rel="stylesheet" type="text/css" href="'+h+host+'/library/css/style.fonts.css">');
append('tag','head','<script type="text/javascript" src="'+h+host+'/engine/engine.functions.js"></script>');
var ver = h+host+'/engine/verify';
var url = window.location.host;
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
var ref = window.location.href;
var eref = Base64.encode(ref);