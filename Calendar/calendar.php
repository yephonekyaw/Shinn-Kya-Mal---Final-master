<?php
    function build_calendar($month, $year) 
    {
        $daysOfWeek = array('SUN','MON','TUE','WED','THU','FRI','SAT');

        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

        $numberDays = date('t',$firstDayOfMonth);

        $dateComponents = getdate($firstDayOfMonth);

        $monthName = $dateComponents['month'];

        $dayOfWeek = $dateComponents['wday'];
        
        $datetoday = date('Y-m-d');  
        
        $calendar = '<div class = "wrapper">';
        $calendar .= '  <main>';
        $calendar .= '    <div class = "toolbar">';
        $calendar .= '      <div class = "toggle">';
        $calendar .= '        <div class = "toggle__option toggle__option--selected">week</div>';
        $calendar .= '        <div class = "toggle__option toggle__option--selected">month</div>';
        $calendar .= '      </div>';
        $calendar .= "      <div>";
        $calendar .= "        <a class='toggle__option' href='?month=".date('m', mktime(0, 0, 0, $month-1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'>< Previous Month</a> ";
        $calendar .= "        <a class='toggle__option' href='?month=".date('m')."&year=".date('Y')."'>Current Month</a> ";
        $calendar .= "        <a class='toggle__option' href='?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>Next Month ></a>";
        $calendar .= "      </div>";
        $calendar .= '      <div class="search-input"></div>';
        $calendar .= '    </div>';
        $calendar .= '     <div class = "calendar">';
        $calendar .= '      <div class = "calendar__header">';

        foreach($daysOfWeek as $day) {
            $calendar .= "<div>$day</div>";
        } 
        $calendar .= '      </div>';
        $calendar .= '      <div class="calendar__week">';
        $currentDay = 1;

        if ($dayOfWeek > 0) { 
            for($k=0;$k<$dayOfWeek;$k++){
                $calendar .= '<div class="calendar__day day"></div>'; 

            }
        }
  
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    
        while ($currentDay <= $numberDays) {

            if ($dayOfWeek == 7) {
                $dayOfWeek = 0;
            }
            
            $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
            $date = "$year-$month-$currentDayRel";
            
            $dayname=strtolower(date("l",strtotime($date)));
            $eventNum=0;
            $today=$day==date('Y-m-d')?"today" : "";
            
            if($datetoday==$date){
                $calendar.="<div class='calendar__day day'>$currentDay</div>";
            }
            else
            {
                $calendar.="<div class='calendar__day day'>$currentDay</div>";
            }
      
            $calendar .="</td>";
            // Increment counters
    
            $currentDay++;
            $dayOfWeek++;
        }

        if ($dayOfWeek != 7) { 
            $remainingDays = 7 - $dayOfWeek;
            for($l=0;$l<$remainingDays;$l++){
                $calendar .= "<div class='calendar__day day'></div>";
            }
        }
        echo $calendar;
    }    
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="calendar.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat:100,300,400,500,700"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <?php
    $dateComponents = getdate();
    if(isset($_GET['month']) && isset($_GET['year']))
    {
      $month = $_GET['month'];            
      $year = $_GET['year'];
    }
    else
    {
      $month = $dateComponents['month'];            
      $year = $dateComponents['year'];
    }
    echo build_calendar($month,$year);
    ?>
</body>
</html>