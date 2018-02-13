<?php 
require_once 'mailer/PHPMailerAutoload.php';
function mobile() {
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
if ($iphone || $android || $palmpre || $ipod || $berry == true) { return true; } else { return false; }
}
function redirect($string) {
header("Location: $string");
}
function draw($string) {
	echo $string;
}
function encrypt($string) {
	base64_encode($string);
}
function decrypt($string) {
	base64_decode($string);
}
function mailer($to,$subject,$message) {
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));
$mail->Host = 'smtp.zoho.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "webmaster@xwiz.xyz";
$mail->Password = "auzx254sd";
$mail->setFrom('webmaster@xwiz.xyz', 'Webmaster Xwiz');
$mail->addAddress($to);
$mail->Subject = $subject;
$mail->msgHTML($message);
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    return 1;
}
}
function extract_domain($domain)
{
	$domain = parse_url($domain)["host"];
    if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches))
    {
        return $matches['domain'];
    } else {
        return $domain;
    }
}
function checkstat($host) {
if($socket =@ fsockopen($host, 80, $errno, $errstr, 30)) {return true;fclose($socket);} 
else {return false;}
}
?>