<?php 
include 'system/config.auth.php';
verify_session();
$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$err = array();
			
if(isset($_POST['doRegister']) == 'Register') 
{ 
/******************* Filtering/Sanitizing Input *****************************
This code filters harmful script code and escapes data of all POST data
from the user submitted form.
*****************************************************************/
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}

/********************* RECAPTCHA CHECK *******************************
This code checks and validates recaptcha
****************************************************************/
if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
          $err[] = "ERROR - Invalid Captcha.";
          exit;
        }
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$privatekey&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		 if($response.'success'==false)
        {
          header("Location: /register.php");
        }
/************************ SERVER SIDE VALIDATION **************************************/
/********** This validation is useful if javascript is disabled in the browswer ***/

if(empty($data['full_name']) || strlen($data['full_name']) < 4)
{
$err[] = "ERROR - Invalid name. Please enter atleast 3 or more characters for your name";
//header("Location: register.php?msg=$err");
//exit();
}

// Validate User Name
if (!isUserID($data['user_name'])) {
$err[] = "ERROR - Invalid user name. It can contain alphabet, number and underscore.";
//header("Location: register.php?msg=$err");
//exit();
}

// Validate Email
if(!isEmail($data['usr_email'])) {
$err[] = "ERROR - Invalid email address.";
//header("Location: register.php?msg=$err");
//exit();
}
// Check User Passwords
if (!checkPwd($data['pwd'],$data['pwd2'])) {
$err[] = "ERROR - Invalid Password or mismatch. Enter 5 chars or more";
//header("Location: register.php?msg=$err");
//exit();
}
	  
$user_ip = $_SERVER['REMOTE_ADDR'];

// stores sha1 of password
$sha1pass = PwdHash($data['pwd']);

// Automatically collects the hostname or domain  like example.com) 
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

// Generates activation code simple 4 digit number
$activ_code = rand(1000,9999);

$usr_email = $data['usr_email'];
$user_name = $data['user_name'];

/************ USER EMAIL CHECK ************************************
This code does a second check on the server side if the email already exists. It 
queries the database and if it has any existing email it throws user email already exists
*******************************************************************/

$rs_duplicate = mysqli_query($link,"select count(*) as total from users where user_email='$usr_email' OR user_name='$user_name'") or die(mysqli_error($link));
list($total) = mysqli_fetch_row($rs_duplicate);

if ($total > 0)
{
$err[] = "ERROR - The username/email already exists. Please try again with different username and email.";
//header("Location: register.php?msg=$err");
//exit();
}
/***************************************************************************/

if(empty($err)) {

$sql_insert = "INSERT into `users`
  			(`full_name`,`user_email`,`pwd`,`date`,`users_ip`,`activation_code`,`user_name`
			)
		    VALUES
		    ('$data[full_name]','$usr_email','$sha1pass',now(),'$user_ip','$activ_code','$user_name'
			)
			";
			
mysqli_query($link,$sql_insert) or die("Insertion Failed:" . mysqli_error($link));
$user_id = mysqli_insert_id($link);  
$md5_id = md5($user_id);
mysqli_query($link,"update users set md5_id='$md5_id' where id='$user_id'");
//	echo "<h3>Thank You</h3> We received your submission.";

if($user_registration)  {
$a_link = "
*****ACTIVATION LINK*****<br>
http://$host$path/activate?user=$md5_id&activ_code=$activ_code
"; 
} else {
$a_link = 
"Your account is *PENDING APPROVAL* and will be soon activated the administrator.
";
}

$message = 
"Hello \n
Thank you for registering on Xwiz. <br>
Your Xwiz engine account can be used
with all the xwiz services and with
external services which use Xwiz Engine Framework.
<br>
Here are your credentials.
<br>
User ID: $user_name <br>
Email: $usr_email <br>
Password: <i>The one you chose at the time of registration.</i> <br>
<br>
$a_link <br>
<br>
Thank You and welcome to Xwiz.
<br><br>
Webmaster<br>
Xwiz<br>
______________________________________________________<Br>
THIS IS AN AUTOMATED RESPONSE. <br>
***DO NOT RESPOND TO THIS EMAIL****<br>
";
if(mailer($usr_email,'Xwiz Registration',$message)==1){
header("Location: /?notif=activ");
}
exit();
	 
	 } 
 }					 

?>
<html>
<head>
<title>Register | Xwiz</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script language="JavaScript" type="text/javascript" src="/library/js/jquery.validate.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
  <script>
  $(document).ready(function(){
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();
  });
  </script>

<link href="library/css/style.jordan.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/library/css/style.fonts.css" />
<link rel="stylesheet" href="/library/fnt/Awesome/css/font-awesome.min.css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td width="160" valign="top"><p>&nbsp;</p>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="732" valign="top"><p>
	<?php 
	 if (isset($_GET['done'])) { ?>
	  <h2>Thank you</h2> Your registration is now complete and you can <a href="login.php">login here</a>";
	 <?php exit();
	  }
	?></p>
      <h3 class="titlehdr"><a href="/" class="back"><i class="fa fa-arrow-circle-left fa-2x" style="padding-top:5px;"></i></a><p class="title"> Register</p></h3>  
	  
	 <?php	
	 if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* $e <br>";
	    }
	  echo "</div>";	
	   }
	 ?> 
	 
	  <br>
      <form action="register.php" method="post" name="regForm" id="regForm" >
        <table width="95%" border="0" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td colspan="2">Name<span class="required"><font color="#CC0000">*</font></span><br> 
              <input name="full_name" type="text" id="full_name" size="40" class="required"></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2"><h4><strong>Login Details</strong></h4></td>
          </tr>
          <tr> 
            <td>Username<span class="required"><font color="#CC0000">*</font></span></td>
            <td><input name="user_name" type="text" id="user_name" class="required username" minlength="5" > 
              <input name="btnAvailable" type="button" id="btnAvailable" 
			  onclick='$("#checkid").html("Please wait..."); $.get("checkuser.php",{ cmd: "check", user: $("#user_name").val() } ,function(data){  $("#checkid").html(data); });'
			  value="Check"> 
			    <span style="color:red; font: bold 12px verdana; " id="checkid" ></span> 
            </td>
          </tr>
          <tr> 
            <td>Your Email<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="usr_email" type="text" id="usr_email3" class="required email"> 
              <span class="example">** Valid email please..</span></td>
          </tr>
          <tr> 
            <td>Password<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd" type="password" class="required password" minlength="5" id="pwd"> 
              <span class="example">** 5 chars minimum..</span></td>
          </tr>
          <tr> 
            <td>Retype Password<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd2"  id="pwd2" class="required password" type="password" minlength="5" equalto="#pwd"></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td width="22%"><strong>Image Verification </strong></td>
            <td width="78%"> 
               <div class="g-recaptcha" data-sitekey="===<?php echo $publickey;?>==="></div>
            </td>
          </tr>
        </table>
        <p align="center">
          <input name="doRegister" type="submit" id="doRegister" value="Register">
        </p>
      </form>   
      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

</body>
</html>
