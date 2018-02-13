<?php
$dir = $_SERVER['DOCUMENT_ROOT'];
$path = '/system/config.auth.php';
include_once $dir.$path;
page_protect('default');
header('Content-type: application/javascript');
?>
var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();
var uname = "<?php echo $_SESSION['user_name'];?>";
var uid = "<?php echo $_SESSION['user_id'];?>";

function checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle) { 
	if(event.keyCode == 13 && event.shiftKey == 0) { //use clicks message send button	
		event.preventDefault();
		var myname = uid;
		var mymessage = $(chatboxtextarea).val();
		var to_user = chatboxtitle;
		mymessage = mymessage.replace(/^\s+|\s+$/g,"");
		mymessage = mymessage.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;");
		$(chatboxtextarea).val('');
		$(chatboxtextarea).focus();
		$(chatboxtextarea).css('height','44px');
		
		if(mymessage == ""){ //emtpy message?
			return;
		}
		
		//prepare json data
		var msg = {
		message: mymessage,
		alias: uname,
		from: myname,
		to: to_user
		};
		//convert and send data to server
		websocket.send(JSON.stringify(msg));
	}
	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$(chatboxtextarea).css('overflow','auto');
	}
}
function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		chatboxtitle = chatBoxes[x];

		if ($("#chatbox_"+chatboxtitle).css('display') != 'none') {
			if (align == 0) {
				$("#chatbox_"+chatboxtitle).css('right', '265px');
			} else {
				width = (align)*(225+7)+265;
				$("#chatbox_"+chatboxtitle).css('right', width+'px');
			}
			align++;
		}
	}
}
function chatWith(chatuser,chatid) {
	createChatBox(chatuser,chatid);
	$("#chatbox_"+chatid+" .chatboxtextarea").focus();
}
function createChatBox(chatboxtitle,chatid,minimizeChatBox) {
	if ($("#chatbox_"+chatid).length > 0) {
		if ($("#chatbox_"+chatid).css('display') == 'none') {
			$("#chatbox_"+chatid).css('display','block');
			restructureChatBoxes();
		}
		$("#chatbox_"+chatid+" .chatboxtextarea").focus();
		return;
	}
	var myname = uid;
	$(" <div />" ).attr("id","chatbox_"+chatboxtitle)
	.addClass("chatbox")
	.html('<div class="chatboxhead"><div class="chatboxtitle">'+chatid+'</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">-</a> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent" id="message_box_'+chatboxtitle+'_'+uid+'"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea></div>')
	.appendTo($( "body" ));
			   
	$("#chatbox_"+chatboxtitle).css('bottom', '0px');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if ($("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}

	if (chatBoxeslength == 0) {
		$("#chatbox_"+chatboxtitle).css('right', '265px');
	} 
	else {
		width = (chatBoxeslength)*(225+7)+265;
		$("#chatbox_"+chatboxtitle).css('right', width+'px');
	}
	
	chatBoxes.push(chatboxtitle);

	if (minimizeChatBox == 1) {
		minimizedChatBoxes = new Array();

		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) {
			if (minimizedChatBoxes[j] == chatboxtitle) {
				minimize = 1;
			}
		}

		if (minimize == 1) {
			$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
			$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
		}
	}

	chatboxFocus[chatboxtitle] = false;

	$("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){
		chatboxFocus[chatboxtitle] = false;
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(){
		chatboxFocus[chatboxtitle] = true;
		newMessages[chatboxtitle] = false;
		$('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	$("#chatbox_"+chatboxtitle).click(function() {
		if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
			$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

	$("#chatbox_"+chatboxtitle).show();
}
function closeChatBox(chatboxtitle) {
	$('#chatbox_'+chatboxtitle).css('display','none');
	restructureChatBoxes();
}

function toggleChatBoxGrowth(chatboxtitle) {
	if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') {  
		
		var minimizedChatBoxes = new Array();
		
		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}

		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxtitle) {
				newCookie += chatboxtitle+'|';
			}
		}

		newCookie = newCookie.slice(0, -1)


		$.cookie('chatbox_minimized', newCookie);
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
		$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
	} else {
		
		var newCookie = chatboxtitle;

		if ($.cookie('chatbox_minimized')) {
			newCookie += '|'+$.cookie('chatbox_minimized');
		}


		$.cookie('chatbox_minimized',newCookie);
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
	}
	
}
/*-----------------------------------------------------------------------------*/
$(document).ready(function(){
	//create a new WebSocket object.
	var wsUri = "ws://chat.xwiz.xyz:9000/demo/server.php"; 	
	websocket = new WebSocket(wsUri); 
	
	websocket.onopen = function(ev) { // connection is open 
		$('.sysmetbox').append("<div class=\"system_msg\">> Connected!</div>"); //notify user
	}
	
	//#### Message received from server?
	websocket.onmessage = function(ev) {
		var msg = JSON.parse(ev.data); //PHP sends Json data
		var type = msg.type; //message type
		var umsg = msg.message; //message text
		var fname = msg.from; //from name
		var tname = msg.to; // to user
		var time = msg.time;
		var alias = msg.alias;
		var myname = uid;
		
		if(type == 'usermsg') 
		{
			if(fname==null||umsg==null||tname==null) {
				
			}
			else {
			if (($('#chatbox'+'_'+fname).length <= 0)&&(fname != myname)||($('#chatbox'+'_'+fname).css('display') == 'none')) {
				createChatBox(fname,alias);
			}
				$('#message_box'+'_'+tname+'_'+fname).append("<div><span class=\"chatboxmessagecontent chatbox-to\">"+umsg+"</span></div>");
				$('#message_box'+'_'+fname+'_'+tname).append("<div><span class=\"chatboxmessagecontent chatbox-by\">"+umsg+"</span></div>");
				/*----------------------------------------------------*/
			}
				$('#message_box'+'_'+tname+'_'+fname).animate({ scrollTop: $('#message_box'+'_'+tname+'_'+fname)[0].scrollHeight}, 1000);
				$('#message_box'+'_'+fname+'_'+tname).animate({ scrollTop: $('#message_box'+'_'+fname+'_'+tname)[0].scrollHeight}, 1000);
		}
		if(type == 'system')
		{
			$('.sysmetbox').append("<div class=\"system_msg\">"+"> "+umsg+"</div>");
		}
		
		$('#message').val(''); //reset text
	};
	
	websocket.onerror	= function(ev){$('.sysmetbox').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");}; 
	websocket.onclose 	= function(ev){$('.sysmetbox').append("<div class=\"system_msg\">Connection Closed</div>");}; 
});
/*-----------------------------------------------------------------------------*/
/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
/*-----------------------------------------------------------------------------*/