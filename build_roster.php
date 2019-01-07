
<?php
include("auth.php");
if ($_SESSION["clearance"] == "pleb") {
		header("Location: index.php");
		exit(); 
}

if (isset($_SESSION['roster']) && $_SESSION['roster'] == true) {
	//header("location: display_roster.php");
}
class shiftArray {
	private $shiftPair;
	private $container;

	function __construct() {
		$this->container = array();
		$this->container['open'] = array();
		$this->container['afternoon'] = array();
		$this->container['close'] = array();
		$this->container['help'] = array();

	}

	function compareDay($a, $b) {
		if (count($a->getPotentialWorkers()) == count($b->getPotentialWorkers())) {
			return 0;
		}
		return (count($a->getPotentialWorkers()) < count($b->getPotentialWorkers())) ? -1 : 1;
	}


	function addShifts($shifts) {
		foreach ($shifts as $shift) {
			array_push($this->container[explode("_", $shift->getType())[count(explode("_", $shift->getType())) - 1]], $shift);
		}

	}

	function getContainer() {
		return $this->container;
	}

	function assignShifts() {
		foreach ($this->container['open'] as $shift1) {
			foreach ($this->container['help'] as $shift2) {
				if ($shift1 != $shift2 && $shift1->getDate() == $shift2->getDate() && explode("_", $shift1->getType())[0] == explode("_", $shift2->getType())[0]) {
					$shift1->pairShift($shift2);
					$shift2->pairShift($shift1);
				}
			}
		}
		foreach ($this->container['afternoon'] as $shift1) {
			foreach ($this->container['help'] as $shift2) {
				if ($shift1 != $shift2 && $shift1->getDate() == $shift2->getDate() && explode("_", $shift1->getType())[0] == explode("_", $shift2->getType())[0]) {
					$shift1->pairShift($shift2);
					$shift2->pairShift($shift1);
				}
			}
		}
		foreach ($this->container['close'] as $shift1) {
			foreach ($this->container['help'] as $shift2) {
				if ($shift1 != $shift2 && $shift1->getDate() == $shift2->getDate() && explode("_", $shift1->getType())[0] == explode("_", $shift2->getType())[0]) {
					$shift1->pairShift($shift2);
					$shift2->pairShift($shift1);
				}
			}
		}
		usort($this->container['open'], array($this,'compareDay'));
		foreach($this->container['open'] as $shift) {
			$shift->assignWorker();
		}
		usort($this->container['close'], array($this,'compareDay'));
		foreach($this->container['close'] as $shift) {
			$shift->assignWorker();
		}
		usort($this->container['afternoon'], array($this,'compareDay'));
		foreach($this->container['afternoon'] as $shift) {
			$shift->assignWorker();
		}
		usort($this->container['help'], array($this,'compareDay'));
		foreach($this->container['help'] as $shift) {
			$shift->assignWorker();
		}

		$this->handleDuplicates();

	}

	function handleDuplicates() {
		include("connect.php");
		$sql = "SELECT * FROM shift s1 WHERE (SELECT count(*) FROM shift s2 WHERE s1.date = s2.date and s1.eName = s2.eName) > 1 ORDER BY eName, date";
		$query =  mysqli_query($con, $sql);
		$shift1 = mysqli_fetch_array($query);
		$employee = $shift1['eName'];
		$current_date = $shift1['date'];
		while ($shift2 = mysqli_fetch_array($query)) {
			if ($employee != $shift2['eName']) {
				$employee = $shift2['eName'];
				$shift1 = $shift2;
				$current_date = $shift1['date'];
			} else if ($current_date == $shift2['date']) {
				$shift1 = $this->mergeShift($shift1, $shift2);
			} else {
				$current_date = $shift2['date'];
				$shift1 = $shift2;
			}
		}

	}

	function mergeShift($shift1, $shift2) {
		//echo "mergeing " . $shift1['date'] . " " . $shift1['Type'] . " " . $shift2['Type'] . " " . $shift1['eName'];
		include("connect.php");
		$start = ($shift1['start'] < $shift2['start']) ? $shift1['start'] : $shift2['start'];
		$end = ($shift1['end'] > $shift2['end']) ? $shift1['end']  : $shift2['end'] ;
		$shift1['start'] = $start;
		$shift1['end'] = $end;
		$sql = "DELETE FROM shift WHERE date = '".$shift1['date']."' AND (type = '".$shift1['Type']."' OR type = '".$shift2['Type']."') ";
		$query =  mysqli_query($con, $sql);
		$sql = "INSERT INTO shift(date, eName, start, end, Type) VALUES('".$shift1['date']."', '".$shift1['eName']."', '".$start."', '".$end."', '".$shift1['Type']."') ";
		$query =  mysqli_query($con, $sql);
		// Handle type change here.
		return $shift1;
	}


}


class shift {
	private $start;
	private $end;
	private $date;
	private $pair;
	private $type;
	private $potentialWorkers;
	private $worker;



	function __construct($start, $end, $date, $type) {
		$this->start = $start;
		$this->end = $end;
		$this->date = $date;
		$this->type = $type;
		$this->potentialWorkers = array();
		$this->pair = null;
	}

	function getStart() {
		return $this->start;
	}

	function getWorker() {
		return $this->worker;
	}


	function getEnd() {
		return $this->end;
	}

	function getDate() {
		return $this->date;
	}

	function pairShift($shift) {
		$this->pair = $shift;
	}

	function getPair() {
		return $this->pair;
	}

	function getType() {
		return $this->type;
	}

	function getLength() {
		if ($this->start % 100 != 0) {
			return ($this->end - $this->start - 40);
		} 
		return ($this->end - $this->start);
	}

	public function __toString() {
    	return $this->type . "(" . $this->start . " - " . $this->end . ") " . $this->date ;
  	}

  	function addPotentialWorker($name) {
  		array_push($this->potentialWorkers, $name);
  	}

  	function getPotentialWorkers() {
  		if (count($this->potentialWorkers) > 0) {
  			return $this->potentialWorkers;
  		} else {
  			return array("nobody");
  		}
  	}

  	function canWork($emp) {
  		include("connect.php");

		$sql = "SELECT * FROM shift WHERE eName = '".$emp."' and date = '".$this->date."' ";

		$query =  mysqli_query($con, $sql);
		if (!$query) {
			echo("Error description: " . mysqli_error($con));
		} 
		if (mysqli_num_rows($query) > 0) {
			// Remove equals signs to enable multis-shifts.
			while ($time = mysqli_fetch_array($query)) {
				if (($time['end'] > $this->start && $time['start'] < $this->start) || ($time['start'] < $this->end && $time['end'] > $this->end)) {
					return false;
				}
			}
		}
		return true;
  	}

  	function compareWorker($emp1, $emp2) {
  		if ($emp1 == "nobody" || $emp2 == "nobody") {
  			return;
  		}
  		$employee1 = array();
  		$employee2 = array();
  		$score1 = 0;
  		$score2 = 0;
  		$date = date('Y-m-d', strtotime('next wednesday'));
  		include("connect.php");

		$sql = "SELECT eName, SUM(end-start) as hours FROM shift WHERE eName = '".$emp1."' and date >= '".$date."' and date <= '".date('Y-m-d', strtotime($date. ' + 7 days'))."' ";

		$totalWorkingHours1 =  mysqli_query($con, $sql);

		$sql = "SELECT eName, SUM(end-start) as hours FROM shift WHERE eName = '".$emp2."' and date >= '".$date."' and date <= '".date('Y-m-d', strtotime($date. ' + 7 days'))."' ";

		$totalWorkingHours2 =  mysqli_query($con, $sql);

		$sql = "SELECT Name, hoursWanted as wantedHours FROM employee WHERE Name = '".$emp1."' or Name = '".$emp2."' ";

		$wantedHours =  mysqli_query($con, $sql);
		if (!$wantedHours) {
				echo("Error description: " . mysqli_error($con));
		}

		$sql = "SELECT eName, SUM(end-start) as avail FROM availability WHERE eName = '".$emp1."' and date >= '".$date."' and date <= '".date('Y-m-d', strtotime($date. ' + 7 days'))."' ";

		$totalAvailability1 =  mysqli_query($con, $sql);

		$sql = "SELECT eName, SUM(end-start) as avail FROM availability WHERE eName = '".$emp2."' and date >= '".$date."' and date <= '".date('Y-m-d', strtotime($date. ' + 7 days'))."' ";

		$totalAvailability2 =  mysqli_query($con, $sql);

		$sql = "SELECT eName, partner FROM partners WHERE eName = '".$emp1."'";

		$preferredPartners1 =  mysqli_query($con, $sql);

		$sql = "SELECT eName, partner FROM partners WHERE eName = '".$emp2."'";

		$preferredPartners2 =  mysqli_query($con, $sql);

		$sql = "SELECT eName, count(*) as numShifts FROM shift WHERE eName = '".$emp1."' and date >= '".$date."' and date <= '".date('Y-m-d', strtotime($date. ' + 7 days'))."' ";

		$numShifts1 =  mysqli_query($con, $sql);

		$sql = "SELECT eName, count(*) as numShifts FROM shift WHERE eName = '".$emp2."' and date >= '".$date."' and date <= '".date('Y-m-d', strtotime($date. ' + 7 days'))."' ";

		$numShifts2 =  mysqli_query($con, $sql);
		$employee1['totalHours'] = 0;
		$employee2['totalHours'] = 0;
		$employee1['availability'] = 0;
		$employee2['availability'] = 0;
		$employee1['numShifts'] = 1;
		$employee2['numShifts'] = 1;
		while ($emp = mysqli_fetch_array($totalWorkingHours1)) {
			if ($emp['eName'] == $emp1) {
				$employee1['totalHours'] = $emp['hours'];
			}
		}
		while ($emp = mysqli_fetch_array($totalWorkingHours2)) {
			if ($emp['eName'] == $emp2) {
				$employee2['totalHours'] = $emp['hours'];
			}
		}
		while ($emp = mysqli_fetch_array($totalAvailability1)) {
			if ($emp['eName'] == $emp1) {
				$employee2['availability'] = $emp['avail'];
			}
		}
		while ($emp = mysqli_fetch_array($totalAvailability2)) {
			if ($emp['eName'] == $emp2) {
				$employee2['availability'] = $emp['avail'];
			}
		}
		while ($emp = mysqli_fetch_array($numShifts1)) {
			if ($emp['eName'] == $emp1) {
				$employee2['numShifts'] = $emp['numShifts'];
			}
		}
		while ($emp = mysqli_fetch_array($numShifts2)) {
			if ($emp['eName'] == $emp2) {
				$employee2['numShifts'] = $emp['numShifts'];
			}
		}

		for ($i = 0; $i < 2; $i++) {
			$emp = mysqli_fetch_array($wantedHours);
			if ($emp['Name'] == $emp1) {
				$employee1['wantedHours'] = $emp['wantedHours'];
			} else {
				$employee2['wantedHours'] = $emp['wantedHours'];
			}
		}
		$partner1 = 0;
		$partner2 = 0;

		if ($this->pair != null) {
			if (count(explode("_", $this->type)) == 2) {
				while ($partner = mysqli_fetch_array($preferredPartners1)) {
					if ($partner['partner'] == $this->pair->getWorker()) {
						$partner1 = 400;
					}
				}
				while ($partner = mysqli_fetch_array($preferredPartners2)) {
					if ($partner['partner'] == $this->pair->getWorker()) {
						$partner2 = 400;
					}
				}
			}
		}	
		$score1 +=  $employee1['wantedHours']*100 - $employee1['totalHours'];
		$score2 +=  $employee2['wantedHours']*100 - $employee2['totalHours'];
		$score1 = ($score1 < 0) ? $score1 : $score1 + $partner1;
		$score2 = ($score2 < 0) ? $score2 : $score2 + $partner2;
		//echo $this . $emp1 . $score1 . $emp2 . $score2 . "<br>";
		if ($score1 == $score2) {
			return 0;
		}
		return ($score1 > $score2) ? -1 : 1;
	}

	function assignWorker() {
		foreach ($this->potentialWorkers as $worker) {
			if (!$this->canWork($worker)) {
				$key = array_search( $worker , $this->potentialWorkers);
				if($key!==false){
				    unset($this->potentialWorkers[$key]);
				}
			}
		}

		usort($this->potentialWorkers, array($this,'compareWorker'));
		$date = date('Y-m-d', strtotime('next wednesday'));
  		include("connect.php");
		if ($this->getPotentialWorkers()[0] != "nobody") {
			echo $this . $this->getPotentialWorkers()[0] . "<br>";
			$this->worker = $this->getPotentialWorkers()[0];

			$sql = "UPDATE shift SET eName = '" . $this->worker . "' WHERE date = '".$this->getDate()."' AND type = '".$this->getType()."' ";
			$query =  mysqli_query($con, $sql);
			if (!$query) {
				echo("Error description: " . mysqli_error($con));
			}
		}
	}

}

function insertShifts($shiftArray, $shifts) {
	include("connect.php");
	$query = null;
	$sql = "";
	foreach ($shifts as $shift) {
		$sql = "INSERT INTO shift(date, eName, start, end, type) VALUES('".$shift->getDate()."', null, '".$shift->getStart()."', '".$shift->getEnd()."', '".$shift->getType()."')";
		$query = mysqli_query($con, $sql);
		if (!$query) {
			$sql = $sql = "UPDATE shift SET start='".$shift->getStart()."', end='".$shift->getEnd()."', eName=null WHERE date = '".$shift->getDate()."' AND type='".$shift->getType()."' ";			
			$query = mysqli_query($con, $sql);
			if (!$query) {
				echo("Error description: " . mysqli_error($con));
			}
		}
		addWorkers($shift);
		//echo "<br>";
	}
	$shiftArray->addShifts($shifts);
}


$date = date('Y-m-d', strtotime('next wednesday'));
$shifts = array();
$shiftArray = new shiftArray();

for ($i = 0; $i < 7; $i++) {
	$dayOfWeek = date("l", strtotime($date));
	if ($dayOfWeek == "Friday") {
		array_push($shifts, new shift(750, 1400, $date, "open"), new shift(900, 1400, $date, "open_help"), new shift(1400, 1800, $date, "afternoon_help"), new shift(1100, 1800, $date, "afternoon"), new shift(1800, 2230, $date, "close_help"), new shift(1800, 2550, $date, "close"));
	} elseif ($dayOfWeek == 'Saturday') {
		array_push($shifts, new shift(850, 1400, $date, "open"), new shift(900, 1400, $date, "open_help"), new shift(1400, 1800, $date, "afternoon_help"), new shift(1100, 1800, $date, "afternoon"), new shift(1800, 2250, $date, "close_help"), new shift(1800, 2550, $date, "close"));
	} elseif ($dayOfWeek == 'Sunday') {
		array_push($shifts, new shift(850, 1400, $date, "open"), new shift(900, 1400, $date, "open_help"), new shift(1400, 1800, $date, "afternoon_help"), new shift(1400, 1800, $date, "afternoon"), new shift(1800, 2200, $date, "close_help"), new shift(1800, 2450, $date, "close"));
	} else {
		array_push($shifts, new shift(750, 1400, $date, "open"), new shift(900, 1400, $date, "open_help"), new shift(1400, 1800, $date, "afternoon_help"), new shift(1100, 1800, $date, "afternoon"), new shift(1800, 2200, $date, "close_help"), new shift(1800, 2450, $date, "close"));
	}

	insertShifts($shiftArray, $shifts);
	$shifts = array();
	$date = date('y-m-d', strtotime($date . ' + 1 days'));


}

function addWorkers($shift) {
	include("connect.php");
	$start = $shift->getStart();
	$end = $shift->getEnd();
	$date = $shift->getDate();
	$type = $shift->getType();
	if ($type == 'close') {
		$sql = "SELECT a.* FROM employee e, availability a WHERE a.date = '".$date."' AND a.start <= ".$start." AND a.end >= ".$end." AND e.canClose = 1 AND e.name = a.eName";
		$query = mysqli_query($con, $sql);
	} elseif ($type == 'open') {
		$sql = "SELECT a.* FROM employee e, availability a WHERE a.date = '".$date."' AND a.start <= ".$start." AND a.end >= ".$end." AND e.canOpen = 1 AND e.name = a.eName";
		$query = mysqli_query($con, $sql);
	} else {
		$sql = "SELECT * FROM availability WHERE date = '".$date."' AND start <= ".$start." AND end >= ".$end." ";
		$query = mysqli_query($con, $sql);
	}
	if (!$query) {
		echo("Error description: " . mysqli_error($con));
	} else {
		if (mysqli_num_rows($query) == 0) {
			echo "No one available" . $shift;
			// Adds the worker of the previous shift to the current shift...
		}
		while ($worker = mysqli_fetch_array($query)) {
			$shift->addPotentialWorker($worker['eName']);
		}
	}
}
$shiftArray->assignShifts();
$_SESSION['roster'] = true;
session_write_close();
header("location: display_roster.php");
?>
