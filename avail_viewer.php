<?php
//include auth.php file on all secure pages
include("auth.php");
if ($_SESSION["clearance"] == "pleb") {
    header("Location: index.php");
    exit(); 
}
function isDate($value) 
{
    if (!$value) {
        return false;
    }

    try {
        new \DateTime($value);
        return true;
    } catch (\Exception $e) {
        return false;
    }
}
if (!isset($_GET['month']) || !isDate($_GET['month'])) {
  $_GET['month'] = date('y-m-d', strtotime("-1 months"));
} 
$_SESSION['day'] = date('y-m-d', strtotime('last sunday of ' . $_GET['month']));

include("query_avail.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Welcome Home</title>
  <link rel="stylesheet" href="stylesheet2.css" />
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
        <li class="nav-item active">
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
	<div class="wrapper">
  <main>
    <div class="calendar">
      <div class="position-sticky border bg-info" style="top:0px;">
        <div class="calendar__header">
          <div>mon</div>
          <div>tue</div>
          <div>wed</div>
          <div>thu</div>
          <div>fri</div>
          <div>sat</div>
          <div>sun</div>
        </div> 
      </div>
      <div data-spy="scroll" data-target="#list-example" data-offset="0" class="scrollspy-example">  
        <?php
        $j = 1;
        echo "<h4 id=\"list-item-0\">";
        echo "<div class=\"calendar__week\">";
        $_GET['month'] = date('y-m-d', strtotime($_GET['month']. ' + 1 months'));
        for ($i = 0; $i < 10000; $i++) {
          if ($i % 7 == 0 && $i > 1 && (date('y-m-d', strtotime($_SESSION['day']. ' + 15 days')) > date('y-m-01', strtotime($_GET['month']. ' + '.$j.' months')))) {
            echo "</div></h4><h4 id=\"list-item-".$j."\">";
            echo "<div class=\"calendar__week\">";
            $j++;
          }
          elseif ($i % 7 == 0 && $i > 1) {
            echo "</div><div class=\"calendar__week\">";
          } 
          echo "<div id=\"day".$i."\" class=\"calendar__day day\">";
          printAvailability();
          echo "</div>";
          if (date('y-m-d', strtotime($_SESSION['day']. ' + 1 days')) == date('y-m-01', strtotime($_GET['month']. ' + 12 months'))) {
            break;
          }
        }
        echo "</div>";
        echo "</h4>";
        
        ?>
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
      <div id="list-example" class="list-group">
        <?php 
        function isMobile() {
            return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
        }
        if (!isMobile()) {
          for ($i = 0; $i < 12; $i++) {
            echo "<a class=\"list-group-item list-group-item-action\" href=\"#list-item-" . $i . "\">" . date('F', strtotime($_GET['month']. ' + ' . $i . ' months')) . "</a>";
          }
        }
        ?>
      </div>
    </nav>
    <div class="copyright">copyright &copy; 2018</div>
  </sidebar>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>