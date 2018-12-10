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

	$name = $_POST["username"]; 
	$psw = $_POST["password"];
	$sql = "SELECT * FROM employee WHERE Name = '".$name."'";

	$password_hash = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($password_hash);

	if($row == null || mysqli_num_rows($password_hash) == 1) {
		if(password_verify($psw, $row['password'])) {
			session_start();
			$_SESSION['username'] = $name;
			$_SESSION['clearance'] = $row['level'];
			session_write_close();
            // Redirect user to index.php
	    	header("Location: index.php");
		} else {
			echo "Password and/or username is incorrect";
		}
		
	} else {
		echo "Password and/or username is incorrect..";
	}

?>

</body>
</html>