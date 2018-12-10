<?php
//include auth.php file on all secure pages
include("auth.php");
if ($_SESSION['clearance'] != "admin") {
	header("location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>
	<link rel="stylesheet" href="stylesheet3.css" />
</head>
<body>
<div class="form">
	<div class="column">
	    <div class="row"><div class="heading">Name</div></div>
	    <div class="row"><div class="heading">Hours Wanted</div></div>
	    <div class="row"><div class="heading">Can Open?</div></div>
	    <div class="row"><div class="heading">Can Close?</div></div>
	    <div class="row"><div class="heading">Partners</div></div>
	 </div> 
	<?php
		$host = 'localhost:3308';
		$user = 'root';
		$pass = '';
		$db = 'subwayroster';

		$con = mysqli_connect($host, $user, $pass, $db);
		if (!$con) {
			echo("Error description: " . mysqli_error($con));
		}
		$openclose = array('no', 'yes');

		$sql = "SELECT * FROM employee";
		$query = mysqli_query($con, $sql);
		while ($emp = mysqli_fetch_array($query)) {
			$begin = "<div class=\"column\"><form class=\"input-form\" action=\"process_emp_data.php\" method=\"post\">";
			$name = "<div class=\"row\">" . $emp['Name'] . "</div>";
			$options = "";
			for ($i = 0; $i < 30; $i++) {
				$options = $options . "<option value = \"" . $i ."\">" . $i . "</option>";
			}
			$hoursWanted = "<div class=\"row\"> <select name=\"hoursWanted\"> <option value=\"current\">"  . $emp['hoursWanted'] . $options ."</select></div>";
			$canOpen = "<div class=\"row\"> <select name=\"canOpen\">
					<option value=\"keep\">" . $openclose[$emp['canOpen']] ."</option>
					<option value=\"change\">" . $openclose[($emp['canOpen'] + 1) % 2] . "</option></select> </div>";
				$canClose = "<div class=\"row\"> <select name=\"canClose\">
					<option value=\"keep\">" . $openclose[$emp['canClose']] ."</option>
					<option value=\"change\">" . $openclose[($emp['canClose'] + 1) % 2] . "</option></select> </div>";
			$partners = "";
			$end = "</form></div>";

			echo $begin . $name . $hoursWanted . $canOpen . $canClose . $partners . $end;

		}




	?>
	<p>This is secure area.</p>
	<a href="logout.php">Logout</a>
</div>
</body>
</html>
