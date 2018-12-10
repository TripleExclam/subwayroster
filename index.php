<?php
//include auth.php file on all secure pages
include("auth.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>
	<link rel="stylesheet" href="stylesheet.css" />
</head>
<body>
<div class="form">
	<p>Welcome <?php echo $_SESSION['username']; ?>!</p>

	<form class="input-form" action="avail_enter.php" method="post">
		<button>Enter Availability</button>
		<select name="week_available">
  			<option id="nextweek" value="next">Next Week </option>
  			<option id="nextweek1" value="next1">Next next Week</option>
  			<option id="nextweek2" value="next2">Next next next Week</option>
  			<option id="nextweek3" value="next3">Next next next next Week</option>
  			<script>
				function daysInMonth (month, year) {
				    return new Date(year, month, 0).getDate();
				}
  				var days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']
			    var d = new Date();
			    var year = d.getFullYear();
			    var change = 0;
			    var day = d.getDay();
			    if (day != 3) {
			    	if (day < 3) {
			    		change += 3 - day;
			    	} else {
				    	change += 10 - day;
				    }
			    }

			    var date = d.getDate() + change;
			    var month = d.getMonth() + 1;
			    var element = document.getElementById("nextweek");
			    element.innerHTML = "Week starting " + date + "/" + month + "." ;
			    element.setAttribute('value', year + "-" + month + "-" + date);
			    // The number of days can be easily changed here.
			    for (var i = 1; i < 4; i++) {
				    date += 7;
				    if (date > daysInMonth(month, year)) {
				    	date = date % daysInMonth(month, year);
				    	month += 1;
				    	month = month % 13;
				    	if (month == 0) {
				    		year += 1;
				    		month = 1;
				    	}
				    }
				    var element = document.getElementById("nextweek" + i);
			    	element.innerHTML = "Week starting " + date + "/" + month + "." ;
			    	element.setAttribute('value', year + "-" + month + "-" + date);
				}
			</script>
		</select>
	</form>
	<p>
	<form class="input-form" action="avail_viewer.php" method="post">
		<button>View Availability Starting</button>
		<select name="month_available">
  			<option id="nextmonth0" value="next">Next Week </option>
  			<option id="nextmonth1" value="next1">Next next Week</option>
  			<option id="nextmonth2" value="next2">Next next next Week</option>
  			<option id="nextmonth3" value="next3">Next next next next Week</option>
  		</select>
  		<input id="year", name="year" type="hidden" value="2018"> </input>
  		<script type="text/javascript">
			var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
			var date = new Date();
			var month = (date.getMonth() - 1) % 12;
			var year = date.getFullYear();
			for (var i = 0; i < 4; i++) {
				
				var element = document.getElementById("nextmonth" + i);
				element.innerHTML = months[(month + 1) % 12];
				element.setAttribute('value', months[month] + " " + year);
				month++;
				if (month == 12) {
					month = 0;
					year++;
				}
			}
			var element = document.getElementById("nextmonth" + i);
			element.setAttribute('value', year);
  		</script>
	</form>
	</p>
	<p>
		<form class="input-form" action="load_roster.php" method="post">
			<button>View Roster</button>
		</form>
	</p>
	<p>
		<?php
			if ($_SESSION['clearance'] == 'admin') {
				echo "<form class=\"input-form\" action=\"Emp_data.php\" method=\"post\">
					<button>Employee preferences</button>
						</form>";
			}

		?>
	</p>
	<p>This is secure area.</p>
	<a href="logout.php">Logout</a>
</div>
</body>
</html>