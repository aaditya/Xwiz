<?php
$dir = $_SERVER['DOCUMENT_ROOT'];
$path = '/system/config.auth.php';
include_once $dir.$path;
if(isset($_GET)&&!empty($_GET)) {$get = $_GET;} else{$get='';}
$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$user_email = $get['u'];
$pass = $get['p'];
$serv = $get['s'];
if(isset($get['o'])&&(!empty($get['o']))){
$option = $get['o'];
}
else {
$option = '';
}
if (strpos($user_email,'@') === false) {$user_cond = "user_name='$user_email'";}
else {$user_cond = "user_email='$user_email'";}
$result = mysqli_query($link,"SELECT `id`,`pwd`,`full_name`,`user_name`,`approved`,`user_level`,`service`,`account`,`status` FROM users,services 
							WHERE $user_cond AND `banned` = '0' AND account = user_name AND service = '$serv';") or die (mysqli_error($link)); 
$num = mysqli_num_rows($result);
/* 
Error Code Guide 
0 => Invalid User
1 => All correct
2 => Wrong Password
3 => Service not assigned
4 => Xwiz Engine account not active
*/
    if ( $num > 0 ) { 
	list($id,$pwd,$full_name,$uname,$approved,$user_level,$service,$account,$status) = mysqli_fetch_row($result);
	if(!$approved) {echo '4';}
	if ($pwd === PwdHash($pass,substr($pwd,0,9))){		
		if(empty($err)){
			if($status == 1){
				if ( $option=='nam' ) {
					echo $full_name;
				}
				else if( $option=='lvl' ) {
					echo $user_level;
				}
				else if( $option=='' ) {
					echo '1';
				}
			}
			else {
				echo '3';
			}
			die();
		}
	}
	else{
		echo '2';
	}
	}
	else {
		echo'0';
	}		
?>