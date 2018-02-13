<?php 
$dir = $_SERVER['DOCUMENT_ROOT'];
$path = '/system/config.auth.php';
include $dir.$path;
session_start();
$loco = $_GET['token'];
if($loco == "") {redirect("/");}
else {redirect(base64_decode($loco));}
?>