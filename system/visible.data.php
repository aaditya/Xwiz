<?php 
include 'config.auth.php';
page_protect('default');
if(isset($_GET)&&!empty($_GET)) {
	$get = $_GET;
}
if($get['val']=='name') {
	$firstname = $_SESSION['user_name'];$arr = explode(' ',trim($firstname));echo $arr[0];
}
else if($get['val']=='id') {
	echo $_SESSION['user_id'];
}
?>