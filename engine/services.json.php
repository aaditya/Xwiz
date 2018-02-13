<?php
$dir = $_SERVER['DOCUMENT_ROOT'];
$path = '/system/config.auth.php';
include_once $dir.$path;
$status = page_protect('default');
header('Content-type: application/json');
$url = $_GET['dom'];
$domain = /*extract_domain($url)*/$url;
$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query = "SELECT * FROM domains where domain = '$domain';";
$result = mysqli_query($link,$query);
if (mysqli_num_rows($result) > 0) {
while($row=mysqli_fetch_array($result)) { 
?>
{
		"domain": "<?php echo $domain;?>",
		"status": "<?php echo $row['active'];?>",
		"secure":"<?php echo $row['secure'];?>", 
		"redirect":"<?php echo $row['redirect'];?>", 
		"hide":"<?php echo $row['hide'];?>",
		"transition":"<?php echo $row['trans'];?>",
		"hosted":"<?php echo $row['host'];?>"
}
<?php
}
}
else {
	?>
{
		"username": "<?php echo $_SESSION['user_name'];?>",
		"userid": "<?php echo $_SESSION['user_id'];?>",
		"domain": "<?php echo $domain;?>",
		"status": "-1"
}
<?php
}
mysqli_close($link);
?>