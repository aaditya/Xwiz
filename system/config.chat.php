<?php
include 'config.auth.php';
page_protect('default');
header('Content-type: application/json');
?>
{
		"username": "<?php echo $_SESSION['user_name'];?>",
		"userid": "<?php echo $_SESSION['user_id'];?>"
}