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
<!-- 	      </li>
	      <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          View Availability
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
	        	<?php 
					$date = date('Y-m', strtotime('next wednesday'));
					for ($i = 0; $i < 11; $i++) {
						echo "<a class=\"dropdown-item\" href=\"avail_viewer.php?month=".date('Y-m', strtotime($date . "- 1 months"))."\">".$date."</a>";
						$date = date('Y-m', strtotime($date. ' + 1 months'));
					}
				?>
	        </div>
	      </li> -->
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