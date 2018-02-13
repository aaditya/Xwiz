<?php
$dir = $_SERVER['DOCUMENT_ROOT'];
$path = '/system/config.db.php';
include_once $dir.$path;
function dashtheme($type) {
	$time = date('H', time() - date('Z'));
	if($time >= '0' && $time <= '2') {
		$theme = '0';
	}
	else if($time >= '3' && $time <= '5') {
		$theme = '1';
	}
	else if($time >= '6' && $time <= '8') {
		$theme = '2';
	}
	else if($time >= '9' && $time <= '11') {
		$theme = '3';
	}
	else if($time >= '12' && $time <= '14') {
		$theme = '4';
	}
	else if($time >= '15' && $time <= '17') {
		$theme = '5';
	}
	else if($time >= '18' && $time <= '20') {
		$theme = '6';
	}
	else if($time >= '21' && $time <= '23') {
		$theme = '7';
	}
	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$sql = "SELECT * FROM dash WHERE hour = $theme;";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        if($type == 'bg') {
		return $row['bg'];
		}
		else if($type == 'txt') {
		return $row['txt'];
		}
    }
} 
else {
    echo "#fff";
}
mysqli_close($link);
}
?>