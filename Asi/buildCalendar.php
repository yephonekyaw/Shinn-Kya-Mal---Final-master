<?php
function build_calendar($calendarMonth, $calendarYear)
{
    include("../main/cons/config.php");
    $id = $_SESSION['id'];
    $daysOfWeek = array('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT');

    $firstDayOfMonth = mktime(0, 0, 0, $calendarMonth, 1, $calendarYear);

    $numberDays = date('t', $firstDayOfMonth);

    $dateComponents = getdate($firstDayOfMonth);

    $monthName = $dateComponents['month'];

    $dayOfWeek = $dateComponents['wday'];

    $datetoday = date('Y-m-d');

    $calendar  = '<div class = "calendar shadow bg-white p-5">';
    $calendar .= '  <div class = "d-flex align-items-center"><i class = "fa fa-calendar fa-2x mr-3"></i>';
    $calendar .= '      <h4 class = "month font-weight-bold mb-0 text-uppercase">' . $monthName . '</h4>';
    $calendar .= '  </div>';
    $calendar .= '  <p class = "font-italic text-muted mb-5" >Reminder Plans</p>';
    $calendar .= '  <ol class = "day-names list-unstyled" >';

    foreach ($daysOfWeek as $day) {
        $calendar .= '  <li class= "font-weight-bold text-uppercase" >' . $day . '</li>';
    }

    $calendar .= '  </ol>';
    $calendar .= '  <ol class = "days list-unstyled">';

    $currentDay = 1;

    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= '      <li>';
            $calendar .= '          <div class="date"></div>';
            $calendar .= '      </li>';
        }
    }
    $calendarMonth = str_pad($calendarMonth, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$calendarYear-$calendarMonth-$currentDayRel";

        $dayname = strtolower(date("l", strtotime($date)));
        $eventNum = 0;
        $today = $day == date('Y-m-d') ? "today" : "";

        $dayToCheckReminder = date('d', strtotime($date));
        $reminder_count = 0;
        $sqlReminder = "SELECT * FROM reminder_event WHERE reminder_user_fk_id='$id' AND DAY(reminder_date)='$dayToCheckReminder' ";
        $resultReminder = mysqli_query($conn, $sqlReminder);
        while($rowReminder = mysqli_fetch_assoc($resultReminder))
        {
            $reminder_count++;
        }

        if($reminder_count > 0)
        {
            if ($datetoday == $date) {
                $calendar .= '      <li>';
                $calendar .= '          <div class="date">'.$currentDay.'</div>';
                $calendar .= '          <div class="event bg-success">'.$reminder_count.'</div>';
                $calendar .= '      </li>';
            } else {
                $calendar .= '      <li>';
                $calendar .= '          <div class="date">'.$currentDay.'</div>';
                $calendar .= '          <div class="event bg-success">'.$reminder_count.'</div>';
                $calendar .= '      </li>';
            }

        }
        else
        {
            if ($datetoday == $date) {
                $calendar .= '      <li>';
                $calendar .= '          <div class="date">'.$currentDay.'</div>';
                $calendar .= '      </li>';
            } else {
                $calendar .= '      <li>';
                $calendar .= '          <div class="date">'.$currentDay.'</div>';
                $calendar .= '      </li>';
            }
        }

        // Increment counters
        $currentDay++;
        $dayOfWeek++;
    }
    if ($dayOfWeek != 7) { 
        $remainingDays = 7 - $dayOfWeek;
        for($l=0;$l<$remainingDays;$l++){
            $calendar .= '      <li>';
            $calendar .= '          <div class="date"></div>';
            $calendar .= '      </li>';
        }
    }

    $calendar .= '  </ol>';

    echo $calendar;
}
?>