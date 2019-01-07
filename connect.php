<?php
$host = 'localhost:3308';
$user = 'basicuser';
$pass = 'OesOgzKFMpzzVf2D';
$db = 'subwayroster';

$con = mysqli_connect($host, $user, $pass, $db);
if (!$con) {
	echo "unable to connect";
	echo("Error description: " . mysqli_error($con));
}
?>