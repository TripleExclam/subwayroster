<?php
	//include auth.php file on all secure pages
	include("auth.php");

	$host = 'localhost:3308';
	$user = 'root';
	$pass = '';
	$db = 'subwayroster';

	$con = mysqli_connect($host, $user, $pass, $db);
	if (!$con) {
		echo "unable to connect";
		echo("Error description: " . mysqli_error($con));
	}

	$sql = "SELECT level FROM employee WHERE Name = '".$_SESSION['username']."' ";

	$query = mysqli_query($con, $sql);
	$level = mysqli_fetch_array($query);

	if ($level[0] == "admin") {
		header("Location: avail_viewer.php");
		exit();

	} else {

	}




?>




















