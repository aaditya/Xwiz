<?php
$dir = $_SERVER['DOCUMENT_ROOT'];
$path = '/system/config.auth.php';
include $dir.$path;
$domain = $_POST['dom'];
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$sql = "SELECT * FROM domains WHERE domain = '$domain';";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo $row['active'];
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>