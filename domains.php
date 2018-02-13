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
<div class="can-head"><div class="left-text">Domains</div><div class="right-text"><a href="<?php echo $_SESSION['uname'];?>"><?php echo $_SESSION['user_name'];?></a> . <a href="logout"><i class="fa fa-sign-out"></i></a></div></div>
<div class="can-body">
<div class="owndom">Your Domains :</div>
<div class="carosel">
<table class="domlist">
<thead>
<tr><th>#</th><th>Name</th><th>Status</th><th>Options</th></tr>
</thead>
<tbody>
<?php
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user = $_SESSION['uname'];
$sql = "SELECT * FROM domains where owner='$user'";
$result = $conn->query($sql);
$rowcount = 1;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$transmit_raw = array($_SESSION['uname'],$row["domain"]);
		$transmit_imp = implode(":",$transmit_raw);
		$transmit_hash = sha1($transmit_imp);
		$transmit_exe = array($transmit_imp,$transmit_hash);
		$transmit = implode(":",$transmit_exe);
	?>
	<tr>
	<td><?php echo $rowcount; ?></td>
	<td><a href="http://<?php echo $row["domain"];?>:8080" target="_blank"><?php echo $row["domain"];?></a></td><td><?php if($row["active"]==0){echo 'Not Activated';} else if($row["active"]==1){echo 'Activated';}?></td>
	<?php if($row["deletable"]==1){?>
	<td>
		<a href="/system/process.ftp.php?grant=<?php echo base64_encode($transmit);?>" target="_blank" style="color:#f1f442;"><i class="fa fa-folder"></i></a>
		<a href="/system/process.domain.php?action=degenerate&domain=<?php echo $row["domain"];?>" style="color:#f40;"><i class="fa fa-trash"></i></a>
	</td>
	<?php } else {?>
	<td>
		<a href="/system/process.ftp.php?grant=<?php echo base64_encode($transmit);?>" target="_blank" style="color:#f1f442;"><i class="fa fa-folder"></i></a>
		<a style="color:#657082;"><i class="fa fa-trash"></i></a>
	</td>
	<?php } ?>
	</tr>
	<?php
    $rowcount++;
	}
} else {
?>
    <tr><td colspan="4">You don't have any domain(s) on the Xwiz Network.</td></tr>
<?php
	}
$conn->close();
?>
</tbody>
</table>
</div>
<div class="newdom"><p>Register a New Domain on the Xwiz Network</p></div>
<br>
<p class="para-dom">Enter the subdomain :</p>
<div class="ndom">
<form method="post" action="/system/process.domain.php?action=generate">
<span></span>
<input type="text" name="domain" placeholder="Enter your address"/>
<select name="sub" class="subdom">
<option value="self">No Subdomain.</option>
<option>xwizapps.cf</option>
</select>
<button type="submit" class="sub"><i class="fa fa-check"></i></button>
</form>
</div>
</div>
<div class="can-foot"></div>
</div>
<?php
if(!empty($_GET['action'])){
?>
<div id="notif" class="notif_<?php echo $_GET['action'];?>">
<?php if($_GET['action']=="success") {
if(isset($get['active']) == 'false') {
?>
<p>Please check your registered email for activation.</p>
<?php
}
else {?>
<p>Action executed successfully.</p>
<?php
}
}
else if($_GET['action']=="failure") {
?>
<p>Action Execution Failed (code <?php echo $_GET['code'];?>)</p>
<?php
}
?>
<?php ?>
</div>
<?php }
?>
</body>
</html>
