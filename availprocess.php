<?php
//include auth.php file on all secure pages
include("auth.php");
$_SESSION['roster'] = false;
session_write_close();
?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <meta name="description" content="The HTML5 Herald">
  <meta name="Matt Burtn" content="SitePoint">

  <link rel="stylesheet.css" href="css/styles.css?v=1.0">

</head>

<body>

<?php
	include("connect.php");
	$query = null;
	$sql = "";

	function addAvailability($date, $start, $end, $con) {
		$sql = "INSERT INTO availability(date, ename, start, end) VALUES ('".$date."', '".$_SESSION['username']."', '".$start."', '".$end."')";
		mysqli_query($con, 'SET foreign_key_checks = 1');
		$query = mysqli_query($con, $sql);
		if (!$query) {
			$sql = "UPDATE availability SET start='".$start."', end='".$end."' WHERE eName = '".$_SESSION['username']."' AND date='".$date."'";
			$query = mysqli_query($con, $sql);
			if (!$query) {
				// echo("Error description: " . mysqli_error($con));
				echo "Sorry, something went wrong.";
			}
		}
	}

	$suffix = array('Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'Monday', 'Tuesday');
	$date = $_SESSION['availability_date'];
	if (DateTime::createFromFormat('Y-m-d', $_POST['effective']) == FALSE) {
  		$_POST['effective'] = date('Y-m-d', strtotime($date. ' + 7 days'));
	}
	$i = 0;
	while ($_POST['effective'] > $date) {
		if ($_POST["".$suffix[$i % 7].'start'] == 0 || $_POST["".$suffix[$i % 7].'end'] == 0) {
			addAvailability($date, 0, 0, $con);
		} else {
			addAvailability($date, $_POST["".$suffix[$i % 7].'start'], $_POST["".$suffix[$i % 7].'end'], $con);
		}
		$date = date('Y-m-d', strtotime($date. ' + 1 days'));
		$i++;
	}
	$_SESSION['çomputeroster'] = false;
	header("Location: index.php");
	exit();

?>


</body>
</html>