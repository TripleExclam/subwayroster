<?php
//include auth.php file on all secure pages
include("auth.php");
if ($_SESSION["clearance"] == "pleb") {
		header("Location: index.php");
		exit(); 
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Availability</title>
	<link rel="stylesheet" href="stylesheet2.css">
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
	      	<li class="nav-item dropdown active">
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
	<?php 
	if (isset($_GET['date']) && $_GET['date'] >= date('Y-m-d', strtotime("next Wednesday"))) {
		$_SESSION['availability_date'] = $_GET['date'];
	} else {
		$_SESSION['availability_date'] = date('Y-m-d', strtotime("next Wednesday"));
	}
	?>
	<div class="wrapper">
		<main>
			<div class="d-flex justify-content-center">
				<h4>
					<?php 
					echo " <a class=\"btn btn-outline-primary btn-lg\" href=\"avail_enter.php?date=" . date('Y-m-d', strtotime($_SESSION['availability_date'] . ' - 7 days')) . "\"> PREVIOUS WEEK </a>";
					echo " You are currently modifying availability for the week starting: " . $_SESSION['availability_date']; 
					echo " <a class=\"btn btn-outline-primary btn-lg\" href=\"avail_enter.php?date=" . date('Y-m-d', strtotime($_SESSION['availability_date'] . ' + 7 days')) . "\"> NEXT WEEK </a>";
					?>
					
				</h4>
			</div>
			<form class="input-form" action="availprocess.php" method="post">
				<?php
				include("connect.php");
				
				$date = date('Y-m-d', strtotime($_SESSION['availability_date']));

				for ($i = 0; $i < 7; $i++) {
					$checked = array("", "", "", "", "", "", "", "", "", "", "");
					$sql = "SELECT * FROM availability WHERE eName = '".$_SESSION['username']."' AND date ='".$date."'";

			        $query = mysqli_query($con, $sql);
			        if ($query && mysqli_num_rows($query) != 0) {
			        	$level = mysqli_fetch_array($query);
			        	switch($level['start']) {
			        		case "730":
			        			$checked[0] = "selected";
			        			break;
			        		case "900":
			        			$checked[1] = "selected";
			        			break;
			        		case "1100":
			        			$checked[2] = "selected";
			        			break;
			        		case "1400":
			        			$checked[3] = "selected";
			        			break;
			        		case "1800":
			        			$checked[4] = "selected";
			        			break;
			        		case "0":
			        			$checked[5] = "selected";
			        			break;
			        	}
			        	switch($level['end']) {
			        		case "2550":
			        			$checked[6] = "selected";
			        			break;
			        		case "1400":
			        			$checked[7] = "selected";
			        			break;
			        		case "1800":
			        			$checked[8] = "selected";
			        			break;
			        		case "2250":
			        			$checked[9] = "selected";
			        			break;
			        		case "0":
			        			$checked[10] = "selected";
			        			break;
			        	}
					} else {
						$checked[0] = "selected";
						$checked[6] = "selected";
					}
					echo "<div class=\"d-flex justify-content-center\">
					<div class=\"form-inline\" style=\"text-align-last:center\">
					<p class=\"text-uppercase\"><b>" . date ('l', strtotime($date)) . " " . date ('Y-m-d', strtotime($date)) . ":</b> start time 
					<select class=\"form-control\" name=\"" . date ('l', strtotime($date)) . "start\">
					<option id=\"n/a\" value=\"0\" " . $checked[5] . ">n/a</option>
					<option id=\"open\" value=\"730\"" . $checked[0] . ">open</option>
					<option id=\"nine\" value=\"900\"" . $checked[1] . ">0900</option>
					<option id=\"eleven\" value=\"1100\" " . $checked[2] . ">1100</option>
					<option id=\"two\" value=\"1400\"" . $checked[3] . ">1400</option>
					<option id=\"six\" value=\"1800\"" . $checked[4] . ">1800</option>
					</select> end time 
					<select class=\"form-control\" name=\"" . date ('l', strtotime($date)) . "end\">
					<option id=\"etwo\" value=\"1400\"" . $checked[7] . ">1400</option>
					<option id=\"esix\"value=\"1800\"" . $checked[8] . ">1800</option>
					<option id=\"eten\" value=\"2250\"" . $checked[9] . ">2200</option>
					<option id=\"close\" value=\"2550\"" . $checked[6] . ">close</option>
					<option id=\"n/a\" value=\"0\"" . $checked[10] . ">n/a</option>
					</select>
					</p>
					</div>
					</div>";
					$date = date('Y-m-d', strtotime($date . ' + 1 days'));
				}
				?>

				<p> Effective until?
				<input class="form-control" type="text" name="effective" placeholder="Enter date in yyyy-mm-dd format"/>
				</p>
				<div class="d-flex justify-content-center">
					<button class="btn btn-outline-primary btn-block"> Submit </button>
				</div>
			</form>
		</main>
		<sidebar>
		    <div class="logo">Menu Bar</div>
	    	<div class="avatar">
	      		<div class="avatar__img">
	        		<img src="https://picsum.photos/70" alt="avatar">
	      		</div>
	      		<div class="avatar__name"> <?php echo $_SESSION['username']; ?></div>
    		</div>
    		<nav class="menu">
      			<a class="menu__item" href="index.php">
        			<i class="menu__icon fa fa-home"></i>
        			<span class="menu__text">Home</span>
      			</a>
		        <?php 
		        $date = date('Y-m-d', strtotime('next wednesday'));
		        for ($i = 0; $i < 8; $i++) {
		            echo "<a class=\"menu__item\" href=\"avail_enter.php?date=" . $date . "\"><i class=\"menu__icon fa fa-home\"></i><span class=\"menu__text\">" . $date . "</span></a>";
		            $date = date('Y-m-d', strtotime($date. ' + 1 months'));
		          }
		        ?>
      			<a class="menu__item" href="logout.php">
        			<i class="menu__icon fa fa-home"></i>
        			<span class="menu__text">Logout</span>
      			</a>
    		</nav>
		    <div class="copyright">copyright &copy; 2018</div>
		</sidebar>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>