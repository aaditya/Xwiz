<?php 
include 'config.auth.php';
page_protect('default');
$action = $_GET['action'];
function filename_safe($name) { 
    $except = array('\\', '/', ':', '*', '?', '"', '<', '>', '|'); 
    return str_replace($except, '', $name); 
}
function recurseRmdir($dir) {
  $files = array_diff(scandir($dir), array('.','..'));
  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
}
if($action=='generate') {
if($_POST['sub']=='self') {
	$domain = $_POST['domain'];
}
else {
	$domain = $_POST['domain'].".".$_POST['sub'];
}
$folder = $domain;
$path = 'E:/Public/Virtual';
$user = $_SESSION['uname'];
$structure = $path.'/'.filename_safe($folder).'/public';
if(!is_dir($structure)) {
	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if (mysqli_connect_errno()) {echo "Failed to connect to MySQL: " . mysqli_connect_error();}
	mysqli_query($link,"INSERT INTO `xwiz`.`domains` (`domain`, `owner`) VALUES ('$folder', '$user');");
	mysqli_close($link);
	mkdir($structure, null, true);
	header('Location: /domains?action=success&active=false');
	exit;
}
else {
	header('Location: /domains?action=failure');
	exit;
}
}
else if($action=='degenerate') {
$folder = $_GET['domain'];
$path = 'E:/Public/Virtual';
$user = $_SESSION['uname'];
$structure = $path.'/'.filename_safe($folder);
recurseRmdir($structure);
	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if (mysqli_connect_errno()) {echo "Failed to connect to MySQL: " . mysqli_connect_error();}
	mysqli_query($link,"DELETE FROM `xwiz`.`domains` WHERE domain = '$folder' and owner = '$user';");
	mysqli_close($link);
	header('Location: /domains');
	exit;
}
?> 