<?php
function checkstat($host) {
if($socket =@ fsockopen($host, 80, $errno, $errstr, 30)) {return true;fclose($socket);} 
else {return false;}
}
echo checkstat('google.com');
echo checkstat('hansa.xwiz.xyz');
?>
