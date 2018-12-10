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
		echo("Error description: " . mysqli_error($con));
	}


	$name = $_POST["username"] . " " . $_POST["lastname"]; 

	$sql = "SELECT Name FROM employee WHERE Name = '".$name."'";
	$query = mysqli_query($con, $sql);
	$sqlname = mysqli_fetch_array($query);

	if ($sqlname == $name) {
		echo "That name is already in use. <br>";
	}

	$psw1 = $_POST["pwd1"];
	$psw2 = $_POST["pwd2"];

	if ($psw1 != $psw2) {
		echo "passwords did not match.<br>";
	}

	if (strlen($psw1) > 8 && 1 === preg_match('~[0-9]~', $psw1)) {

		$password_hash = password_hash($psw1, PASSWORD_DEFAULT);
		$user = "user";
		$sql = "INSERT INTO employee (Name, age, password, level, canOpen, canClose) VALUES ('".$name."', 18, '".$password_hash."', '".$user."', true, true)";
		$query = mysqli_query($con, $sql);
		if ($query) {
			header("Location: login.php");
			exit();
		} else {
			echo("Error description: " . mysqli_error($con));
		}
	} else {
		echo "Please enter a password with nine or more characters and at least one number.<br>";
	}
?>

</body>
</html>