<?php
//include auth.php file on all secure pages
include("auth.php")

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Home</title>
	<link rel="stylesheet" href="stylesheet4.css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
	  <a class="navbar-brand" href="#">Subway Stones Corner</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNavDropdown">
	    <ul class="navbar-nav">
	    	<li class="nav-item">
	        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          Enter Availability
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
	        	<?php 
					$date = date('Y-m-d', strtotime('next wednesday'));
					for ($i = 0; $i < 20; $i++) {
						echo "<a class=\"dropdown-item\" href=\"avail_enter.php?date=".$date."\">".$date."</a>";
						$date = date('Y-m-d', strtotime($date. ' + 7 days'));
					}
				?>
	        </div>
	      <li class="nav-item">
	        <a class="nav-link" href="avail_viewer.php">View Availability<span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item active">
	        <a class="nav-link" href="build_roster.php">View Roster<span class="sr-only">(current)</span></a>
	      </li>
	       	<?php
			if ($_SESSION['clearance'] == 'admin') {
				echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"emp_data.php\">Employee Preferences<span class=\"sr-only\">(current)</span></a></li>";
			}
			?>
	    </ul>
	  </div>
	</nav>	
	<div class="wrapper">
<?php
$date = date('Y-m-d', strtotime('next wednesday'));

include("connect.php");

$table = "<table style=\"width:100%\">";
$header1 = "<tr>
	 <th colspan=\"2\" rowspan=\"2\">Week Ending " . date('Y-m-d', strtotime($date. ' + 7 days')) . "</th>
	    <th colspan=\"2\">" . date('Y-m-d', strtotime($date. ' + 0 days')) . "</th>
	    <th colspan=\"2\">" . date('Y-m-d', strtotime($date. ' + 1 days')) . "</th>
	    <th colspan=\"2\">" . date('Y-m-d', strtotime($date. ' + 2 days')) . "</th>
	    <th colspan=\"2\">" . date('Y-m-d', strtotime($date. ' + 3 days')) . "</th>
	    <th colspan=\"2\">" . date('Y-m-d', strtotime($date. ' + 4 days')) . "</th>
	    <th colspan=\"2\">" . date('Y-m-d', strtotime($date. ' + 5 days')) . "</th>
	    <th colspan=\"2\">" . date('Y-m-d', strtotime($date. ' + 6 days')) . "</th>
	    <th colspan=\"2\"></th>
	  </tr>";
$header2 = "<tr>
	    <th colspan=\"2\">Wednesday</th>
	    <th colspan=\"2\">Thursday</th>
	    <th colspan=\"2\">Friday</th>
	    <th colspan=\"2\">Saturday</th>
	    <th colspan=\"2\">Sunday</th>
	    <th colspan=\"2\">Monday</th>
	    <th colspan=\"2\">Tuesday</th>
	    <th >Hours</th>
	  </tr>";
$employees = "";

$sql = "SELECT DISTINCT Name as eName FROM employee ORDER BY lastName ";
$query = mysqli_query($con, $sql);

while ($employee = mysqli_fetch_array($query)) {
	$hours = 0;
	$shift = array();
	for ($i = 0; $i < 7; $i++) {
		$shift[$i] = "<td> </td> <td> </td>"; 
	}
	$name = $employee['eName'];
	$sql = "SELECT * FROM shift WHERE date >= '".$date."' and date <= '".date('Y-m-d', strtotime($date. ' + 7 days'))."' and eName = '".$name."'";
	$query2 = mysqli_query($con, $sql);
	if (!$query2) {
		echo ("Error description: " . mysqli_error($con));
	}
	while ($work = mysqli_fetch_array($query2)) {
		for ($i = 0; $i < 7; $i++) {
			if ($work['date'] == date('Y-m-d', strtotime($date. ' + ' . $i . 'days'))) {
				$length = (($work['end'] - $work['start']) % 100 != 0) ? intdiv($work['end'] - $work['start'], 100) . ".50": intdiv($work['end'] - $work['start'], 100) . ".00";
				$hours += $length;
				$work['start'] = ($work['start'] % 100 != 0) ? intdiv($work['start'] , 100) % 12 . ":30" : intdiv($work['start'] , 100) % 12;
				$work['end'] = ($work['end'] % 100 != 0) ? intdiv($work['end'] , 100) % 12 . ":30" : intdiv($work['end'] , 100) % 12;
				if ($work['end'] == "0:30") {
					$work['end'] = "12:30";
				}
				if ($work['Type'] == "open") {
					$colour = "#f2f24d";
				} elseif ($work['Type'] == "close") {
					$colour = "#356df2";
				} elseif ($work['Type'] == "afternoon") {
					$colour = "#51a309";
				} else {
					$colour = "";
				}
				$shift[$i] = "<td align=\"center\" bgcolor=".$colour.">" . $work['start'] . "-" . $work['end'] . "</td><td align=\"center\"> " . $length . "</td>";
				break;
			} 
		}
	}
	$hours = ((int) $hours == $hours) ? $hours . ".00" : $hours . "0";

	$employees = $employees . "<tr>" . "<td>" . $name . "</td><td></td>" . $shift[0] . $shift[1] . $shift[2] . $shift[3] . $shift[4] . $shift[5] . $shift[6] . "<td align=\"right\">" . $hours . "</td></tr>";

}

$tableEnd = "</table>";

echo $table . $header1 . $header2 . $employees . $tableEnd;
?> 


	<div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
