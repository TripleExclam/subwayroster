<?php
//include auth.php file on all secure pages
include("auth.php");
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
	$host = 'localhost:3308';
	$user = 'root';
	$pass = '';
	$db = 'subwayroster';

	$con = mysqli_connect($host, $user, $pass, $db);
	if (!$con) {
		echo "unable to connect";
		echo("Error description: " . mysqli_error($con));
	}
	$query = null;
	$sql = "";

	function addAvailability($date, $start, $end, $con) {
		$sql = "INSERT INTO availability(date, ename, start, end) VALUES ('".$date."', '".$_SESSION['username']."', '".$start."', '".$end."')";
		$query = mysqli_query($con, $sql);
		if (!$query) {
			$sql = "UPDATE availability SET start='".$start."', end='".$end."' WHERE eName = '".$_SESSION['username']."' AND date='".$date."'";
			$query = mysqli_query($con, $sql);
			if (!$query) {
				echo("Error description: " . mysqli_error($con));
				echo "Sorry, something went wrong.";
			}
		}
	}

	$suffix = array('wed', 'thur', 'fri', 'sat', 'sun', 'mon', 'tue');
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

	header("Location: index.php");
	exit();

?>


</body>
</html>