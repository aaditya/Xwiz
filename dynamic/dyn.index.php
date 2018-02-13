<?php include 'dyn.functions.php';?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Welcome to Xwiz</title>
<meta charset="UTF-8">
<meta name="theme-color" content="#2eccfa">
<meta name="msapplication-navbutton-color" content="#2eccfa">
<meta name="apple-mobile-web-app-status-bar-style" content="#2eccfa">
<link rel="stylesheet" type="text/css" href="/library/css/style.fonts.css"/>
<link rel="stylesheet" type="text/css" href="/library/css/style.xui.css"/>
<link rel="stylesheet" type="text/css" href="/library/fnt/Awesome/css/font-awesome.min.css" />
</head>
<body>
	<div id="particles"></div>
<div id="header">
<div class="panel">
<a href="#">About</a>
</div>
</div>
<div id="mid">
<div class="mid_title">Xwiz</div>
<form action="login.php" method="post" name="logForm" id="logForm" autocomplete="new-password">
	<div class="mid_body">
        <table style="border:none; padding:10px; border-spacing:10px; border-collapse: separate;" class="loginform">
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td style="width:28%;"><i class="fa fa-user-o fa-2x" aria-hidden="true"></i></td>
            <td style="width:72%;"><input name="usr_email" type="text" style="float:left;" class="required" id="txtbox" size="25" autocomplete="new-password" /></td>
          </tr>
          <tr>
            <td><i class="fa fa-key fa-2x" aria-hidden="true"></td>
            <td><input name="pwd" type="password" style="float:left;" class="required password" size="25" autocomplete="new-password" /></td>
		  </tr>
		  <tr>
			<td style="display:none;" colspan="2"><input type="hidden" name="token" value="Lw==" /></td>
          </tr>
          <tr>
            <td colspan="2"><div class="center">
                <input name="remember" type="checkbox" id="remember" value="1">Remember me</div></td>
          </tr>
          <tr>
            <td colspan="2"> <div class="center">
                <p>
                  <input name="doLogin" type="submit" id="doLogin3" value="Login">
                </p>
                <p><a href="forgot">Forgot Password</a> | <a href="register">Signup</a></p>
                </div></td>
          </tr>
        </table>
	</div>
		<div class="center"></div>
        <p class="center">&nbsp; </p>
      </form>

</div>
<div class="logos"></div>
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
<div id="footer"><div style="text-align:center;">Aaditya Chakravarty © <?php echo date('Y');?></div></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type='text/javascript' src='/library/js/jquery.particleground.js'></script>
<script type='text/javascript' src='/library/js/particleground.config.js'></script>
</body>
</html>
