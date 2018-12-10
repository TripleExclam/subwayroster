<?php
//include auth.php file on all secure pages
include("auth.php");
$_SESSION['day'] = date('y-m-d', strtotime('last sunday of ' . $_POST['month_available']));
include("query_avail.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Welcome Home</title>
	<link rel="stylesheet" href="stylesheet2.css" />
</head>
<body>
	<div class="wrapper">
  <main>
    <div class="toolbar">
      <div class="toggle">
      </div>
      <div id="current_month" class="current-month"> <?php echo date('y-m-d', strtotime($_POST['month_available']. ' + 1 months'));?></div>
    </div>
    <div class="calendar">
      <div class="calendar__header">
        <div>mon</div>
        <div>tue</div>
        <div>wed</div>
        <div>thu</div>
        <div>fri</div>
        <div>sat</div>
        <div>sun</div>
      </div>
      <div class="calendar__week">
        <div id="day0" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day1" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day2" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day3" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day4" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day5" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day6" class="calendar__day day"> <?php printAvailability(); ?> </div>
      </div>
      <div class="calendar__week">
        <div id="day7" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day8" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day9" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day10" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day11" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day12" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day13" class="calendar__day day"> <?php printAvailability(); ?> </div>        
      </div>
      <div class="calendar__week">
        <div id="day14" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day15" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day16" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day17" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day18" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day19" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day20" class="calendar__day day"> <?php printAvailability(); ?> </div>    
      </div>
      <div class="calendar__week">
        <div id="day21" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day22" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day23" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day24" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day25" class="calendar__day day"> <?php printAvailability(); ?> </div> 
        <div id="day26" class="calendar__day day"> <?php printAvailability(); ?> </div> 
        <div id="day27" class="calendar__day day"> <?php printAvailability(); ?> </div> 
      </div>
      <div class="calendar__week">
        <div id="day28" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day29" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day30" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day31" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day32" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day33" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day34" class="calendar__day day"> <?php printAvailability(); ?> </div>
      </div>
      <div class="calendar__week">
        <div id="day35" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day36" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day37" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day38" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day39" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day40" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day41" class="calendar__day day"> <?php printAvailability(); ?> </div>
      </div>
      <div class="calendar__week">
        <div id="day42" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day43" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day44" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day45" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day46" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day47" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day48" class="calendar__day day"> <?php printAvailability(); ?> </div>
      </div>
      <div class="calendar__week">
        <div id="day49" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day50" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day51" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day52" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day53" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day54" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day55" class="calendar__day day"> <?php printAvailability(); ?> </div>
      </div>
      <div class="calendar__week">
        <div id="day56" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day57" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day58" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day59" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day60" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day61" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day62" class="calendar__day day"> <?php printAvailability(); ?> </div>
      </div>
      <div class="calendar__week">
        <div id="day63" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day64" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day65" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day66" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day67" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day68" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day69" class="calendar__day day"> <?php printAvailability(); ?> </div>
      </div>
      <div class="calendar__week">
        <div id="day70" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day71" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day72" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day73" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day74" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day75" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day76" class="calendar__day day"> <?php printAvailability(); ?> </div>
      </div>
      <div class="calendar__week">
        <div id="day77" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day78" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day79" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day80" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day81" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day82" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day83" class="calendar__day day"> <?php printAvailability(); ?> </div>
      </div>
      <div class="calendar__week">
        <div id="day84" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day85" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day86" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day87" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day88" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day89" class="calendar__day day"> <?php printAvailability(); ?> </div>
        <div id="day90" class="calendar__day day"> <?php printAvailability(); ?> </div>
      </div>
    </div>
    
  </main>
  <sidebar>
    <div class="logo">logo</div>
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
    </nav>
    <div class="copyright">copyright &copy; 2018</div>
  </sidebar>
</div>
</body>
</html>