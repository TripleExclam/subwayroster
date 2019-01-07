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

	$userName = mysqli_escape_string($con, $_POST["username"]); 
	$psw = mysqli_escape_string($con, $_POST["password"]);

	$statement = mysqli_prepare($con, "SELECT * FROM accounts WHERE userName = ?");

	mysqli_stmt_bind_param($statement, "s", $userName);
	mysqli_stmt_execute($statement);
	$result = $statement->get_result();
	$row = $result->fetch_assoc();
	if($row == null || $result->num_rows == 1) {
		if(password_verify($psw, $row['pHash'])) {
			session_start();
			$_SESSION['username'] = $row['firstName'] . "" . $row['lastName'];
			$_SESSION['firstName'] = $row['firstName'];
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

	mysqli_stmt_close($statement);
	

?>

</body>
</html>