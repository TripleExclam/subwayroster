<?php
include("auth.php");
$_SESSION['roster'] = false;
session_write_close();
if ($_SESSION['clearance'] != "admin") {
	header("location: index.php");
}
include("connect.php");

$query = null;
$sql = "";

function addAvailability($con, $emp, $canOpen, $canClose, $hoursWanted, $partners) {
	$sql = "UPDATE employee SET canOpen=".$canOpen.", canClose=".$canClose.", hoursWanted=".$hoursWanted." WHERE Name = '".$emp."'";
	$query = mysqli_query($con, $sql);
	if (!$query) {
		echo("Error description: " . mysqli_error($con));
		echo "Sorry, something went wrong.";
	}
	$sql = "DELETE FROM partners WHERE eName ='".$emp."'";
	$query = mysqli_query($con, $sql);
	if (!$query) {
		echo("Error description: " . mysqli_error($con));
		echo "Sorry, something went wrong.";
	}
	foreach ($partners as $partner) {
		$sql = "INSERT INTO partners(eName, partner) VALUES('".$emp."', '".$partner."')";
		$query = mysqli_query($con, $sql);
		if (!$query) {
			echo("Error description: " . mysqli_error($con));
			echo "Sorry, something went wrong.";
		}
	}
}

$sql = "SELECT * FROM employee";
$query = mysqli_query($con, $sql);

while ($emp = mysqli_fetch_array($query)) {
	$partners = array();
	for ($i = 0; $i < 30; $i++) {
		if (array_key_exists($i . $emp['Name'], $_POST)) {
			array_push($partners, $_POST[$i . $emp['Name']]);
		}
	}
	addAvailability($con, $_POST['name' . $emp['Name']], $_POST['canOpen' . $emp['Name']], $_POST['canClose' . $emp['Name']], $_POST['hoursWanted' . $emp['Name']], $partners);
}

header("location: emp_data.php");
//echo implode(" ", $_POST);

?>

