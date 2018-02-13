<?php
include 'system/config.auth.php';
if(isset($_GET['token'])&&!empty($_GET['token'])) {
$refer = $_GET['token'];
}
else {
	$refer = base64_encode('/');
}
logout($refer);
?> 