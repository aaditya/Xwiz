<?php
include 'system/config.auth.php';
page_protect('index');
?>
<html>
<head>
<title>Home | Xwiz</title>
<link rel="stylesheet" type="text/css" href="/library/css/style.xui-flash.css" />
<link rel="stylesheet" type="text/css" href="/library/css/style.xui-home.css" />
<link rel="stylesheet" type="text/css" href="/library/css/style.fonts.css" type="text/css" />
<link type="text/css" rel="stylesheet" media="all" href="/library/css/style.wrapper.css" />
<link rel="stylesheet" type="text/css" href="/library/css/style.fonts.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="/library/fnt/Awesome/css/font-awesome.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
<div id="leftbar">
<?php include 'dynamic/dyn.nav.php'; ?>
</div>
<div id="canvas">
<div class="can-head"><div class="left-text">Home</div><div class="right-text"><a href="<?php echo $_SESSION['uname'];?>"><?php echo $_SESSION['user_name'];?></a> . <a href="logout"><i class="fa fa-sign-out"></i></a></div></div>
<div class="can-body">
<div class="wrap-body">
<a href="/tools/PhpMyAdmin"><p><i class="fa fa-database fa-2x"></i></p><p>Database</p></a>
<a href="http://engine.xwiz.xyz"><p><i class="fa fa-hashtag fa-2x"></i></p><p>Engine</p></a>
<a href="http://spectra.xwiz.xyz"><p><i class="fa fa-cloud fa-2x"></i></p><p>Spectra</p></a>
<a href="http://stage.xwiz.xyz"><p><i class="fa fa-code fa-2x"></i></p><p>Stage</p></a>
<a href="http://tools.xwiz.xyz"><p><i class="fa fa-wrench fa-2x"></i></p><p>Tools</p></a>
<br><br><div class="section-head"><p>Section</p></div><br>
<a href="http://bace.xwiz.xyz"><p><i class="fa fa-book fa-2x"></i></p><p>Bace</p></a>
<a href="http://engine.xwiz.xyz"><p><i class="fa fa-hashtag fa-2x"></i></p><p>Engine</p></a>
<a href="http://spectra.xwiz.xyz"><p><i class="fa fa-cloud fa-2x"></i></p><p>Spectra</p></a>
<a href="http://stage.xwiz.xyz"><p><i class="fa fa-code fa-2x"></i></p><p>Stage</p></a>
<a href="http://tools.xwiz.xyz"><p><i class="fa fa-wrench fa-2x"></i></p><p>Tools</p></a>
<br><br><div class="section-head"><p>Section</p></div><br>
<a href="http://bace.xwiz.xyz"><p><i class="fa fa-book fa-2x"></i></p><p>Bace</p></a>
<a href="http://engine.xwiz.xyz"><p><i class="fa fa-hashtag fa-2x"></i></p><p>Engine</p></a>
<a href="http://spectra.xwiz.xyz"><p><i class="fa fa-cloud fa-2x"></i></p><p>Spectra</p></a>
<a href="http://stage.xwiz.xyz"><p><i class="fa fa-code fa-2x"></i></p><p>Stage</p></a>
<a href="http://tools.xwiz.xyz"><p><i class="fa fa-wrench fa-2x"></i></p><p>Tools</p></a>
</div>

</div>
</div>
<?php
if(!empty($_GET['action'])){
?>
<div id="notif" class="notif_<?php echo $_GET['action'];?>">
<?php if($_GET['action']=="success") {
?>
<p>Action Executed Successfully !</p>
<?php
}
else if($_GET['action']=="failure") {
?>
<p>Action Execution Failed (code <?php echo $_GET['code'];?>)</p>
<?php
}
?>
</div>
<?php }
?>
</body>
</html>
