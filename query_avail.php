<?php 

  function printAvailability() {
    $host = 'localhost:3308';
    $user = 'root';
    $pass = '';
    $db = 'subwayroster';

    $con = mysqli_connect($host, $user, $pass, $db);
    if (!$con) {
      echo "unable to connect";
      echo("Error description: " . mysqli_error($con));
    }
    $_SESSION['day'] = date('y-m-d', strtotime($_SESSION['day']. ' + 1 days'));
    if (date('m-d', strtotime($_SESSION['day'])) == "01-01") {
      echo "<strong>" . date('Y-m', strtotime($_SESSION['day'])) . "-" . "</strong>";
    }
    elseif (date('d', strtotime($_SESSION['day'])) == "01") {
      echo "<b>" . date('m', strtotime($_SESSION['day'])) . "-" . "</b>";
    } 

    echo date('d', strtotime($_SESSION['day'])) . "<br>";
    $date = date('01-m-Y');
    if ($date <= $_SESSION['day']) {
      if ($_SESSION['clearance'] == 'admin') {
        $sql = "SELECT * FROM availability WHERE date ='".$_SESSION['day']."'";

        $query = mysqli_query($con, $sql);
        if (!$query || mysqli_num_rows($query) == 0) {
          echo "";
        } else {
          while ($level = mysqli_fetch_array($query)) {

            if ($level['start'] == "07:30" && $level['end'] == "25:30") {
              echo "<p>" . $level['eName'] . ": available all day." . "</p>";
            } elseif ($level['start'] == 0) {
              echo $level['eName'] . ": Not available." . "<br>";
            } else {
              echo $level['eName'] . ": " . $level['start'] . "-" . $level['end'] . "<br>";
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
          if ($level['start'] == 7 && $level['end'] == 26) {
            echo "Available: all day.";
          } elseif ($level['start'] == 0) {
            echo "Not available.";
          } else {
            echo "Available: " . $level['start'] . "-" . $level['end'];
          }
        }
      }
    }
  }

?>