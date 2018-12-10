<?php

class shiftArray {
	private $shiftPair;
	private $container;

	function __construct() {
		$this->container = array();
		$this->container['open'] = array();
		$this->container['afternoon'] = array();
		$this->container['close'] = array();

	}

	function compareDay($a, $b) {
		if (count($a->getPotentialWorkers()) == count($b->getPotentialWorkers())) {
			return 0;
		}
		return (count($a->getPotentialWorkers()) < count($b->getPotentialWorkers())) ? -1 : 1;
	}


	function addShifts($shifts) {
		foreach ($shifts as $shift) {
			array_push($this->container[explode("_", $shift->getType())[0]], $shift);
		}

		foreach ($this->container['open'] as $shift1) {
			foreach ($this->container['open'] as $shift2) {
				if ($shift1 != $shift2 && $shift1->getDate() == $shift2->getDate()) {
					$shift1->pairShift($shift2);
				}
			}
		}

		usort($this->container['open'], array($this,'compareDay'));
		usort($this->container['afternoon'], array($this,'compareDay'));
		usort($this->container['close'], array($this,'compareDay'));
	}

	function getContainer() {
		return $this->container;
	}


}


class shift {
	private $start;
	private $end;
	private $date;
	private $pair;
	private $type;
	private $potentialWorkers;



	function __construct($start, $end, $date, $type) {
		$this->start = $start;
		$this->end = $end;
		$this->date = $date;
		$this->type = $type;
		$this->potentialWorkers = array();
	}

	function getStart() {
		return $this->start;
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
  		return $this->potentialWorkers;
  	}

  	function compareWorker($emp1, $emp2) {
  		$date = date('Y-m-d', strtotime('next wednesday'));
  		$host = 'localhost:3308';
		$user = 'root';
		$pass = '';
		$db = 'subwayroster';
		$con = mysqli_connect($host, $user, $pass, $db);
		if (!$con) {
			echo "unable to connect";
			echo("Error description: " . mysqli_error($con));
		}
		$sql = "SELECT eName, SUM(end-start) FROM shift WHERE eName = '".$emp1."' or eName = '".$emp2."' and date >= '".$date."' ";

		$totalWorkingHours =  mysqli_query($con, $sql);

		$sql = "SELECT name, wantedHours FROM employee WHERE eName = '".$emp1."' or eName = '".$emp2."' ";

		$wantedHours =  mysqli_query($con, $sql);

		$sql = "SELECT eName, SUM(end-start) FROM availability WHERE eName = '".$emp1."' or eName = '".$emp2."' and date >= '".$date."' ";;

		$totalAvailability =  mysqli_query($con, $sql);

		$sql = "SELECT eName, * FROM partners WHERE eName = '".$emp1."' or eName = '".$emp2."'";

		$preferredPartners =  mysqli_query($con, $sql);

		$sql = "SELECT eName, count(*) FROM shift WHERE eName = '".$emp1."' or eName = '".$emp2."' and date >= '".$date."' ";

		$numShifts =  mysqli_query($con, $sql);

		if (true) {
			return 0;
		}
		return (true) ? -1 : 1;
	}

}

function insertShifts($shifts) {
	$shiftArray = new shiftArray();
	$host = 'localhost:3308';
	$user = 'root';
	$pass = '';
	$db = 'subwayroster';
	$con = mysqli_connect($host, $user, $pass, $db);
	if (!$con) {
		echo "unable to connect";
		echo("Error description: " . mysqli_error($con));
	}
	$query = null;
	$sql = "";
	foreach ($shifts as $shift) {
		$sql = "INSERT INTO shift(date, eName, start, end, type) VALUES('".$shift->getDate()."', null, '".$shift->getStart()."', '".$shift->getEnd()."', '".$shift->getType()."')";
		$query = mysqli_query($con, $sql);
		if (!$query) {
			$sql = $sql = "UPDATE shift SET start='".$shift->getStart()."', end='".$shift->getEnd()."' WHERE date = '".$shift->getDate()."' AND type='".$shift->getType()."'";			
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


for ($i = 0; $i < 7; $i++) {
	$dayOfWeek = date("l", strtotime($date));
	if ($dayOfWeek == "Friday") {
		array_push($shifts, new shift(730, 1400, $date, "open"), new shift(900, 1400, $date, "open_help"), new shift(1400, 1800, $date, "afternoon_help"), new shift(1100, 1800, $date, "afternoon"), new shift(1800, 2200, $date, "close_help"), new shift(1800, 2530, $date, "close"));
	} elseif ($dayOfWeek == 'Saturday') {
		array_push($shifts, new shift(830, 1400, $date, "open"), new shift(900, 1400, $date, "open_help"), new shift(1400, 1800, $date, "afternoon_help"), new shift(1100, 1800, $date, "afternoon"), new shift(1800, 2200, $date, "close_help"), new shift(1800, 2530, $date, "close"));
	} elseif ($dayOfWeek == 'Sunday') {
		array_push($shifts, new shift(830, 1400, $date, "open"), new shift(900, 1400, $date, "open_help"), new shift(1400, 1800, $date, "afternoon_help"), new shift(1400, 1800, $date, "afternoon"), new shift(1800, 2200, $date, "close_help"), new shift(1800, 2430, $date, "close"));
	} else {
		array_push($shifts, new shift(730, 1400, $date, "open"), new shift(900, 1400, $date, "open_help"), new shift(1000, 1800, $date, "afternoon_help"), new shift(1100, 1800, $date, "afternoon"), new shift(1800, 2200, $date, "close_help"), new shift(1800, 2430, $date, "close"));
	}

	insertShifts($shifts);
	$shifts = array();
	$date = date('y-m-d', strtotime($date . ' + 1 days'));


}

function addWorkers($shift) {
	$host = 'localhost:3308';
	$user = 'root';
	$pass = '';
	$db = 'subwayroster';
	$con = mysqli_connect($host, $user, $pass, $db);
	if (!$con) {
		echo "unable to connect";
		echo("Error description: " . mysqli_error($con));
	}
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
			// error message.
		}
		while ($worker = mysqli_fetch_array($query)) {
			$shift->addPotentialWorker($worker['eName']);
		}
	}

	//echo implode(" ", $shift->getPotentialWorkers()) . "   can be worked   " . $shift . "<br>";

	
}
































?>