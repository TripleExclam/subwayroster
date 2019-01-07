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

	$userName =  mysqli_escape_string($con, $_POST['username']);
	$firstName = mysqli_escape_string($con, $_POST['firstname']);
	$lastName = mysqli_escape_string($con, $_POST['lastname']);
	$psw1 = mysqli_escape_string($con, $_POST["pwd1"]);
	$psw2 = mysqli_escape_string($con, $_POST["pwd2"]);
	$nameJoin = $firstName . $lastName;


	$statement = mysqli_prepare($con, "SELECT userName FROM accounts WHERE userName = ?");

	mysqli_stmt_bind_param($statement, "s", $userName);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $sqlname);
	mysqli_stmt_fetch($statement);

	if ($sqlname == $userName) {
		echo "That name is already in use.<br>
		<a href=\"login.php\"> return to login </a>";
		exit();
	}
	mysqli_stmt_close($statement);

	$statement = mysqli_prepare($con, "SELECT Name FROM employee");

	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $sqlname);
	$level = "pleb";
	while (mysqli_stmt_fetch($statement)) {
		if ($sqlname == $nameJoin) {
			$level = "user";
		}
	}
	mysqli_stmt_close($statement);

	
	if ($psw1 != $psw2) {
		echo "Passwords did not match.<br> <a href=\"login.php\"> return to login </a>";
		exit();
	}

	if (strlen($psw1) > 7 && 1 === preg_match('~[0-9]~', $psw1)) {

		$password_hash = password_hash($psw1, PASSWORD_DEFAULT);
		$statement = mysqli_prepare($con, "INSERT INTO accounts (firstName, lastName, userName, pHash, level) VALUES (?, ?, ?, ?, '".$level."')");

		mysqli_stmt_bind_param($statement, "ssss", $firstName, $lastName, $userName, $password_hash);
		mysqli_stmt_execute($statement);
		if($statement->affected_rows >= 0) {
			header("Location: login.php");
			exit();
		} else {
			echo("Error description: " . mysqli_error($con));
		}
		mysqli_stmt_close($statement);
		
	} else {
		echo "Please enter a password with eight or more characters and at least one number.<br> <a href=\"login.php\"> return to login </a>";
		exit();
	}
?>

</body>
</html>