<?php 
  function printAvailability() {
    include("connect.php");
    $_SESSION['day'] = date('y-m-d', strtotime($_SESSION['day']. ' + 1 days'));
    if (date('m-d', strtotime($_SESSION['day'])) == "01-01") {
      echo "<b>" . date('Y-m', strtotime($_SESSION['day'])) . "-" . "</b>";
    }
    elseif (date('d', strtotime($_SESSION['day'])) == "01") {
      echo "<b>" . date('m', strtotime($_SESSION['day'])) . "-" . "</b>";
    } 

    echo "<p>" . date('d', strtotime($_SESSION['day'])) . "</p>";
    $date = date('01-m-Y');
    if ($date <= $_SESSION['day']) {
      if ($_SESSION['clearance'] == 'admin') {
        $sql = "SELECT availability.*, employee.* FROM availability, employee WHERE Name = eName and date ='".$_SESSION['day']."' ORDER BY lastName";

        $query = mysqli_query($con, $sql);
        if (!$query || mysqli_num_rows($query) == 0) {
          echo "";
        } else {
          while ($level = mysqli_fetch_array($query)) {

            if ($level['start'] == "730" && $level['end'] == "2550") {
              echo $level['firstName'] . " " . $level['lastName'] . ": available all day." . "<br>";
            } elseif ($level['start'] == 0) {
              echo $level['firstName'] . " " . $level['lastName'] . ": Not available." . "<br>";
            } else {
              echo $level['firstName'] . " " . $level['lastName'] . ": " . $level['start'] . "-" . $level['end'] . "<br>";
            }
          }
        }
      } else {
        $sql = "SELECT * FROM availability WHERE eName = '".$_SESSION['username']."' AND date ='".$_SESSION['day']."'";

        $query = mysqli_query($con, $sql);
        if (!$query || mysqli_num_rows($query) == 0) {
          echo "";
        } else {
        $level = mysqli_fetch_array($query);
          if ($level['start'] == "730" && $level['end'] == "2550") {
            echo "Available: all day." . "<br>";
          } elseif ($level['start'] == 0) {
            echo "Not available." . "<br>";
          } else {
            echo "Available: " . $level['start'] . "-" . $level['end'] . "<br>";
          }
        }
      }
    }
  }

?>