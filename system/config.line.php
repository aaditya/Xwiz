<?php
include_once 'config.auth.php';
page_protect('default');
if ($_GET['action'] == "call") { call(); } 
if ($_GET['action'] == "retreive") { retreive(); } 
if ($_GET['action'] == "dvis") { status_d(); } 
if ($_GET['action'] == "evis") { status_e(); } 
if ($_GET['action'] == "rvis") { status_r(); } 
function call() {
$time = time('s');
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {  printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }
$query = "UPDATE users SET timestamp = ".$time." WHERE id = ".$_SESSION['user_id']."";
mysqli_query($link, $query);
}
function retreive() {
$time = time('s');
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$actual = $time - 5;
$session = $_SESSION['user_id'];
$query = "SELECT * FROM `users` WHERE timestamp > $actual and id != $session and cvis = 1";
$users = mysqli_query($link,$query) or die(mysqli_error());
while($row=mysqli_fetch_array($users))
{
?>
<a href="javascript:void(0)" onclick="javascript:chatWith('<?php echo $row['id']; ?>','<?php echo $row['full_name']; ?>')"><?php echo $row['full_name']; ?></a>
<?php
} 
}
function status_e() {
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {  printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }
$query = "UPDATE users SET cvis = 1 WHERE id = ".$_SESSION['user_id']."";
mysqli_query($link, $query);
}
function status_d() {
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {  printf("Connect failed: %s\n", mysqli_connect_error()); exit(); }
$query = "UPDATE users SET cvis = 0 WHERE id = ".$_SESSION['user_id']."";
mysqli_query($link, $query);
}
function status_r() {
$out;
$session = $_SESSION['user_id'];
$users = mysqli_query("SELECT * FROM `users` WHERE id = $session") or die(mysqli_error());
while($row=mysqli_fetch_array($users))
{
	$out = $row['cvis'];
}
echo $out; 
}
?>