<?php
$dir = $_SERVER['DOCUMENT_ROOT'];
$path = '/system/config.auth.php';
include_once $dir.$path;
?>
<a href="/"><i class="fa fa-home"></i> Home</a>
<a href="/settings"><i class="fa fa-user" aria-hidden="true"></i> Account Settings</a>
<a href="/domains"><i class="fa fa-book" aria-hidden="true"></i> Domains</a>
<a href="/services"><i class="fa fa-cogs"></i> Services</a>
<?php if(checkAdmin()) {?>
<a href="/admin"><i class="fa fa-code"></i> Developer Panel</a>
<?php }
/*<?php $firstname = $_SESSION['user_name'];$arr = explode(' ',trim($firstname));echo $arr[0];?>*/
?>