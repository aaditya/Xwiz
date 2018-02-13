<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Oops !</title>
<meta charset="UTF-8">
<meta name="theme-color" content="#2eccfa">
<meta name="msapplication-navbutton-color" content="#2eccfa">
<meta name="apple-mobile-web-app-status-bar-style" content="#2eccfa">
<link rel="stylesheet" type="text/css" href="/library/css/style.fonts.css"/>
<link rel="stylesheet" type="text/css" href="/library/css/style.xui.css"/>
<style>
div p a {
	color:#2eccfa;
	text-decoration:none;
	transition:0.5s;
	-webkit-transition:0.5s;
	-moz-transition:0.5s;
}
div p a:hover {
	color:#2eaafa;
}
</style>
</head>
<body>
<div id="header">
<div class="panel">
<a href="about">About</a>
</div>
</div>
<div id="mid">
<div class="mid_title">404 !</div>
<div style="text-align:center;">
<p>Xwiz</p>
<p>The resource you were looking for has been teleported in a paralell dimension.</p>
<p>So unless you can travel in space and time , we recommend you to go <a href="/">Home</a></p>
</div>
</div>
<?php
if(!empty($_GET['notif'])){
?>
<div id="notif" class="notif">
<?php if($_GET['notif']=="activ") {
?>
<p>Account has been created. Please check your email for activation.</p>
<?php 
}
else if($_GET['notif']=="avated") {
?>
<p>Thank you. Your account has been activated. You May now login.</p>
<?php
}
else if($_GET['notif']=="failure") {
?>
<p>Action Execution Failed (code <?php echo $_GET['code'];?>)</p>
<?php
}
?>
</div>
<?php }
?>
<div id="footer"><div style="text-align:center;">SystemWorks Inc. © <?php echo date('Y');?></div></div>
</body>
</html>