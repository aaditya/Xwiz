<?php
include 'system/config.auth.php';
verify_session();
$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

$user = mysqli_real_escape_string($link,$get['user']);

if(isset($get['cmd']) && $get['cmd'] == 'check') {

if(!isUserID($user)) {
echo "Invalid User ID";
exit();
}

if(empty($user) && strlen($user) <=3) {
echo "Enter 5 chars or more";
exit();
}



$rs_duplicate = mysqli_query($link,"select count(*) as total from users where user_name='$user' ") or die(mysqli_error($link));
list($total) = mysqli_fetch_row($rs_duplicate);

	if ($total > 0)
	{
	echo "Not Available";
	} else {
	echo "Available";
	}
}

?>