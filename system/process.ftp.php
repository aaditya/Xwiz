<?php 
include 'config.auth.php';
page_protect('default');
$grant = $_GET['grant'];

function validSign($signature){
	$unhash_sign = base64_decode($signature);
	$sign_exp = explode(":",$unhash_sign);
	$temp_sign = sha1(implode(":",array($sign_exp[0],$sign_exp[1])));
	if(($temp_sign == $sign_exp[2])&&($_SESSION['uname'] == $sign_exp[0])) {return true;}
	else {return false;}
}

function generateStamp($signature) {
	$unhash_sign = base64_decode($signature);
	$currHash = explode(":",$unhash_sign);
	$newPatch = implode(":",array($currHash[0],$currHash[1]));
	$newHash = sha1($newPatch);
	$transmit_new = array($newPatch,$newHash,time());
	$transmit = implode(":",$transmit_new);
	return base64_encode($transmit);
}

if(validSign($grant)) {
	$url = 'http://ftp.aaditya.cf:8000/?grant='.generateStamp($grant);
	header("Location: $url");
}
else {
	header('Location: /domains');
}
?> 