<?php
//include auth.php file on all secure pages
include("auth.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Availability</title>
	<link rel="stylesheet" href="stylesheet.css" />
</head>
<body>
	<?php 
		$_SESSION['availability_date'] = $_POST['week_available'];
	?>
<div class="form">
	<p>You are currently modifying availability for the week starting: <?php echo $_SESSION['availability_date']; ?></p>
	<form class="input-form" action="availprocess.php" method="post">
		<p> Wednesday: start time 
			<select name="wedstart">
				<option id="open" value="730">open</option>
				<option id="two" value="1400">2</option>
				<option id="six" value="1800">6</option>
				<option id="n/a" value="0">n/a</option>
			</select>
			end time
			<select name="wedend">
				<option id="close" value="2530">close</option>
				<option id="etwo" value="1400">2</option>
				<option id="esix" value="1800">6</option>
				<option id="eten" value="2200">10</option>
				<option id="n/a" value="0">n/a</option>
			</select>
		</p>
		<p> Thursday: start time 
			<select name="thurstart">
				<option id="open" value="730">open</option>
				<option id="two" value="1400">2</option>
				<option id="six" value="1800">6</option>
				<option id="n/a" value="0">n/a</option>
			</select>
			end time
			<select name="thurend">
				<option id="close" value="2530">close</option>
				<option id="etwo" value="1400">2</option>
				<option id="esix" value="1800">6</option>
				<option id="eten" value="2200">10</option>
				<option id="n/a" value="0">n/a</option>
			</select>
		</p>
		<p> Friday: start time 
			<select name="fristart">
				<option id="open" value="730">open</option>
				<option id="two" value="1400">2</option>
				<option id="six" value="1800">6</option>
				<option id="n/a" value="0">n/a</option>
			</select>
			end time
			<select name="friend">
				<option id="close" value="2530">close</option>
				<option id="etwo" value="1400">2</option>
				<option id="esix" value="1800">6</option>
				<option id="eten" value="2200">10</option>
				<option id="n/a" value="0">n/a</option>
			</select>
		</p>
		<p> Saturday: start time 
			<select name="satstart">
				<option id="open" value="730">open</option>
				<option id="two" value="1400">2</option>
				<option id="six" value="1800">6</option>
				<option id="n/a" value="0">n/a</option>
			</select>
			end time
			<select name="satend">
				<option id="close" value="2530">close</option>
				<option id="etwo" value="1400">2</option>
				<option id="esix" value="1800">6</option>
				<option id="eten" value="2200">10</option>
				<option id="n/a" value="0">n/a</option>
			</select>
		</p>
		<p> Sunday: start time 
			<select name="sunstart">
				<option id="open" value="730">open</option>
				<option id="two" value="1400">2</option>
				<option id="six" value="1800">6</option>
				<option id="n/a" value="0">n/a</option>
			</select>
			end time
			<select name="sunend">
				<option id="close" value="2530">close</option>
				<option id="etwo" value="1400">2</option>
				<option id="esix" value="1800">6</option>
				<option id="eten" value="2200">10</option>
				<option id="n/a" value="0">n/a</option>
			</select>
		</p>
		<p> Monday: start time 
			<select name="monstart">
				<option id="open" value="730">open</option>
				<option id="two" value="1400">2</option>
				<option id="six" value="1800">6</option>
				<option id="n/a" value="0">n/a</option>
			</select>
			end time
			<select name="monend">
				<option id="close" value="2530">close</option>
				<option id="etwo" value="1400">2</option>
				<option id="esix" value="1800">6</option>
				<option id="eten" value="2200">10</option>
				<option id="n/a" value="0">n/a</option>
			</select>
		</p>
		<p> Tuesday: start time 
			<select name="tuestart">
				<option id="open" value="730">open</option>
				<option id="two" value="1400">2</option>
				<option id="six" value="1800">6</option>
				<option id="n/a" value="0">n/a</option>
			</select>
			end time
			<select name="tueend">
				<option id="close" value="2530">close</option>
				<option id="etwo" value="1400">2</option>
				<option id="esix" value="1800">6</option>
				<option id="eten" value="2200">10</option>
				<option id="n/a" value="0">n/a</option>
			</select>
		</p>

		<p> Effective until?
			<input type="text" name="effective" placeholder="Enter date in yyyy-mm-dd format"/>
		</p>
		<button> Submit </button>
	</form>

	<p>This is secure area.</p>
	<a href="logout.php">Logout</a>
</div>
</body>
</html>