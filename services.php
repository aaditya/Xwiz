<?php
include 'system/config.auth.php';
page_protect('default');
if(isset($_GET)&&!empty($_GET)) {
$get = $_GET;
}
else {
$get = isset($_GET);
}
?>
<html>
<head>
<title>Domains | Xwiz</title>
<link rel="stylesheet" type="text/css" href="/library/css/style.xui-flash.css" />
<link rel="stylesheet" type="text/css" href="/library/css/style.xui-domain.css" />
<link rel="stylesheet" type="text/css" href="/library/css/style.fonts.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="/library/fnt/Awesome/css/font-awesome.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
<div id="header">
<div class="head-title">Xwiz</div>
</div>
<div id="leftbar">
<?php include 'dynamic/dyn.nav.php'; ?>
</div>
<div id="canvas">
<div class="can-head"><div class="left-text">Services</div><div class="right-text"><a href="<?php echo $_SESSION['uname'];?>"><?php echo $_SESSION['user_name'];?></a> . <a href="logout"><i class="fa fa-sign-out"></i></a></div></div>
<div class="can-body">
</div>
<div class="can-foot"></div>
</div>

</body>
</html>
