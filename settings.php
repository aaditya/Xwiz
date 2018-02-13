<?php
/********************** settings.php**************************
This updates user settings and password
************************************************************/
include 'system/config.auth.php';
page_protect('default');
$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$err = array();
$msg = array();

if(isset($_POST['doUpdate']) == 'Update')
{


$rs_pwd = mysqli_query($link,"select pwd from users where id='$_SESSION[user_id]'");
list($old) = mysqli_fetch_row($rs_pwd);
$old_salt = substr($old,0,9);

//check for old password in md5 format
	if($old === PwdHash($_POST['pwd_old'],$old_salt))
	{
	$newsha1 = PwdHash($_POST['pwd_new']);
	mysqli_query($link,"update users set pwd='$newsha1' where id='$_SESSION[user_id]'");
	$msg[] = "Your new password is updated";
	//header("Location: settings.php?msg=Your new password is updated");
	} else
	{
	 $err[] = "Your old password is invalid";
	 //header("Location: settings.php?msg=Your old password is invalid");
	}

}

if(isset($_POST['doSave']) == 'Save')
{
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


mysqli_query($link,"UPDATE users SET
			`full_name` = '$data[name]',
			`address` = '$data[address]',
			`tel` = '$data[tel]',
			`fax` = '$data[fax]',
			`country` = '$data[country]',
			`website` = '$data[web]'
			 WHERE id='$_SESSION[user_id]'
			") or die(mysqli_error($link));

//header("Location: settings.php?msg=Profile Sucessfully saved");
$msg[] = "Profile Sucessfully saved";
 }

$rs_settings = mysqli_query($link,"select * from users where id='$_SESSION[user_id]'");
?>
<html>
<head>
<title>Account | Xwiz</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="/library/css/style.xui-flash.css" />
<link rel="stylesheet" type="text/css" href="/library/css/style.fonts.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="/library/fnt/Awesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="library/css/style.jordan.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/library/js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#myform").validate();
	 $("#pform").validate();
  });
  </script>
</head>
<body>
<div id="header">
<div class="head-title">Xwiz</div>
</div>
<div id="leftbar">
<?php include 'dynamic/dyn.nav.php'; ?>
</div>
<div id="canvas">
<div class="can-head"><div class="left-text">My Account</div><div class="right-text"><a href="<?php echo $_SESSION['uname'];?>"><?php echo $_SESSION['user_name'];?></a> . <a href="logout"><i class="fa fa-sign-out"></i></a></div></div>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr>
    <td width="732" valign="top">
      <p>
        <?php
	if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* Error - $e <br>";
	    }
	  echo "</div>";
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"msg\">" . $msg[0] . "</div>";

	   }
	  ?>
      </p>
	  <?php while ($row_settings = mysqli_fetch_array($rs_settings)) {?>
      <form action="settings.php" method="post" name="myform" id="myform">
        <table width="90%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr>
            <td colspan="2"> Your Name <input name="name" type="text" id="name"  class="required" value="<? echo $row_settings['full_name']; ?>" size="50">
              </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>User Name</td>
            <td><input name="user_name" type="text" id="web2" value="<? echo $row_settings['user_name']; ?>" disabled></td>
          </tr>
          <tr>
            <td>Email</td>
            <td><input name="user_email" type="text" id="web3"  value="<? echo $row_settings['user_email']; ?>" disabled></td>
          </tr>
        </table>
        <p align="center">
          <input name="doSave" type="submit" id="doSave" value="Save">
        </p>
      </form>
	  <?php } ?>
      <h3 class="titlehdr">Change Password</h3>
      <p>If you want to change your password, please input your old and new password
        to make changes.</p>
      <form name="pform" id="pform" method="post" action="">
        <table width="80%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr>
            <td width="31%">Old Password</td>
            <td width="69%"><input name="pwd_old" type="password" class="required password"  id="pwd_old"></td>
          </tr>
          <tr>
            <td>New Password</td>
            <td><input name="pwd_new" type="password" id="pwd_new" class="required password"  ></td>
          </tr>
        </table>
        <p align="center">
          <input name="doUpdate" type="submit" id="doUpdate" value="Update">
        </p>
        <p>&nbsp; </p>
      </form>
      <p>&nbsp; </p>
      <p>&nbsp;</p>

      <p align="right">&nbsp; </p></td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</div>
<?php
if(!empty($_GET['action'])){
?>
<div id="notif" class="notif_<?php echo $_GET['action'];?>">
<?php if($_GET['action']=="success") {
?>
<p>Action Executed Successfully !</p>
<?php
}
else if($_GET['action']=="failure") {
?>
<p>Action Execution Failed (code <?php echo $_GET['code'];?>)</p>
<?php
}
?>
</div>
<?php }
?>
</body>
</html>
