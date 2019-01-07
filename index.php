<?php
//include auth.php file on all secure pages
include("auth.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Home</title>
	<link rel="stylesheet" href="stylesheet5.css">
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
	    	<li class="nav-item active">
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
	      <li class="nav-item">
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
	<div class="d-flex justify-content-center">
		<div class="title-box">
			Welcome <?php echo $_SESSION['firstName']; ?>!
		</div>
	</div>
	<a id="avail_link" href="avail_enter.php">
		<div class="left-box">
			<?php
			include("connect.php");
			$date = date('Y-m-d', strtotime(date('Y-m-d', strtotime('next wednesday')). ''));
			$date7 = date('Y-m-d', strtotime($date. ' + 7 days'));
			$sql = "SELECT * FROM availability WHERE date >= '".$date."' AND date <= '".$date7."' AND eName = '".$_SESSION['username']."' ";
			$query = mysqli_query($con, $sql);
			if (!$query || mysqli_num_rows($query) < 7) {
				echo "<input id=\"avail_note\" type=\"hidden\" value=\"".$date."\">";
			} else {
				while ($query && mysqli_num_rows($query) >= 7) {
					$date = date('Y-m-d', strtotime($date. ' + 7 days'));
					$date7 = date('Y-m-d', strtotime($date. ' + 7 days'));
					$sql = "SELECT * FROM availability WHERE date >= '".$date."' AND date <= '".$date7."' AND eName = '".$_SESSION['username']."' ";
					$query = mysqli_query($con, $sql);
				}
				echo "<input id=\"avail_note\" type=\"hidden\" value=\"true,".$date."\">";
			}

			?>
			<script>
			var entered = false;
			var avail_status = document.getElementById("avail_note").value.split(",");
			var due_date = avail_status[0];
			var text = "Your availability is overdude! Note that unless you input your availability it will be assumed that you are not available for the week beginning: " + due_date;
			if (avail_status[0] == "true") {
				var entered = true;
				due_date = avail_status[1];
				document.getElementById('avail_link').href = "avail_enter.php?date=" + due_date; 
				text = "<div><span> Availability for the week beginning</span> : <span>";
			}
			function startTime() {
			  var date = new Date(due_date);
			  date.setDate(date.getDate() - 7);
			  var today = new Date();
			  var due = new Date(due_date);
			  var distance = date - today;
			  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			  var m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			  var s = Math.floor((distance % (1000 * 60)) / 1000);
			  m = checkTime(m);
			  s = checkTime(s);
			   
			  document.getElementById('txt').innerHTML = text + due.toDateString() + "</span></div><div><span> Due in</span> : <span>" + days + "d " + hours + "h " + m + "m " + s + "s</span></div> <div><span> On</span> : <span>" + date.toDateString() + "</span></div>";
			  if (!entered) {
			  	document.getElementById('txt').innerHTML = text;
			  }
			  var t = setTimeout(startTime, 500);
			}
			function checkTime(i) {
			  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
			  return i;
			}
			</script>
			</head>

			<body onload="startTime()">

			<div id="txt"></div>
		</div>
	</a>
	<div class="left-box">
		<?php
			include("connect.php");
			$date = date('Y-m-d', strtotime(date('Y-m-d', strtotime('next wednesday')). ''));
			$date7 = date('Y-m-d', strtotime($date. ' + 7 days'));
			$sql = "SELECT * FROM employee ORDER BY Name";
			$query = mysqli_query($con, $sql);
			$count = 0;
			while ($emp = mysqli_fetch_array($query)) {
				$count++;
				$sql = "SELECT * FROM availability WHERE date >= '".$date."' AND date <= '".$date7."' AND eName = '".$emp['Name']."' ";
				$query2 = mysqli_query($con, $sql);
				if (!$query2 || mysqli_num_rows($query2) < 7) {
					if ($count == mysqli_num_rows($query)) {
						echo " and " . $emp['firstName'] . " " . $emp['lastName'];
					} else if ($count == mysqli_num_rows($query) - 1) {
						echo $emp['firstName'] . " " . $emp['lastName'];
					}
					else {
						echo $emp['firstName'] . " " . $emp['lastName'] . ", ";
					}
				}
			}
			echo " still need to enter their availability for the upcoming week."
			?>
	</div>
	<a href="logout.php">
		<div class="bottom-box">
			LOGOUT
		</div>
	</a>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>