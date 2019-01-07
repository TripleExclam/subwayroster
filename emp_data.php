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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Home</title>
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
				echo "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"emp_data.php\">Employee Preferences<span class=\"sr-only\">(current)</span></a></li>";
			}
			?>
	    </ul>
	  </div>
	</nav>
	<div class="wrapper">
	<main>	
	<form method="POST" id="my_form" action="process_emp_data.php"></form>

	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">Name</th>
			    <th class="text-nowrap" scope="col">Hours Wanted</th>
			    <th class="text-nowrap" scope="col">Can Open</th>
			    <th class="text-nowrap" scope="col">Can Close</th>
			    <th scope="col">Partners</th>
			</tr>
		</thead>
		
		<?php
		include("connect.php");
		$openclose = array('no', 'yes');

		$sql = "SELECT * FROM employee ORDER BY lastName";
		$query = mysqli_query($con, $sql);
		$i = 0;
		while ($emp = mysqli_fetch_array($query)) {
			$begin = "<tbody>";
			$name = "<tr><th scope=\"col\">" . $emp['Name'] . "<input type=\"hidden\" name=\"name" . $emp['Name'] . "\" value=" . $emp['Name'] . " form=\"my_form\"></th>";
			$options = "";
			for ($i = 0; $i < 30; $i++) {
				$options = $options . "<option value = \"" . $i ."\">" . $i . "</option>";
			}
			$hoursWanted = "<td class=\"d-flex justify-content-center\" scope=\"col\"> <select name=\"hoursWanted" . $emp['Name'] . "\" form=\"my_form\"> <option value=\"". $emp['hoursWanted'] . "\" form=\"my_form\">"  . $emp['hoursWanted'] . $options ."</select></td>";
			$opposite = ($emp['canOpen'] + 1) % 2;
			$canOpen = "<td scope=\"col\"> <select name=\"canOpen" . $emp['Name'] . "\" form=\"my_form\">
					<option class=\"text-uppercase\" value=".$emp['canOpen'].">" . strtoupper($openclose[$emp['canOpen']]) ."</option>
					<option class=\"text-uppercase\" value=".$opposite.">" . strtoupper($openclose[($emp['canOpen'] + 1) % 2]) . "</option></select> </td>";
			$opposite = ($emp['canClose'] + 1) % 2;
			$canClose = "<td scope=\"col\"> <select name=\"canClose" . $emp['Name'] . "\" form=\"my_form\">
					<option class=\"text-uppercase\" value=".$emp['canClose'].">" . strtoupper($openclose[$emp['canClose']]) ."</option>
					<option class=\"text-uppercase\" value=".$opposite.">" . strtoupper($openclose[($emp['canClose'] + 1) % 2]) . "</option></select> </td>";
			$partners = "<td scope=\"col\">";
			$sql = "SELECT * FROM employee ORDER By lastName";
			$query2 = mysqli_query($con, $sql);
			$j = 0;
			while ($emp2 = mysqli_fetch_array($query2)) {
				if ($emp2['Name'] == $emp['Name']) {
					continue;
				}
				$checked = "";
				$sql = "SELECT * FROM partners Where eName = '".$emp['Name']."' AND partner = '".$emp2['Name']."'";
				$query3 = mysqli_query($con, $sql);
				if (mysqli_fetch_array($query3)) {
					$checked = "checked";
				} 
				$partners = $partners . "<label><input type=\"checkbox\" value=\"" . $emp2['Name'] . "\" name=\"" . $j . $emp['Name'] . "\" form=\"my_form\" " . $checked ." /> " . $emp2['Name'] . " </label> ";
				$j++;
			}
			$partners = $partners . "</th>";

			$end = "</tr>";

			echo $begin . $name . $hoursWanted . $canOpen . $canClose . $partners . $end;
			$i++;
		}
		?>
	</table>
	<div class="d-flex justify-content-center">
		<button class="btn btn-outline-primary btn-block" form="my_form">Update data</button>
	</div>
	<div class="d-flex justify-content-center">
		
	</div>
	<div class="d-flex justify-content-center">
		<p>
			
		</p>
	</div>
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
				<a class="menu__item" href="index.php">
        			<i class="menu__icon fa fa-home"></i>
        			<span class="menu__text"><button class="btn btn-outline-primary btn-block" form="my_form">Update data</button>
					</span>
      			</a>
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
