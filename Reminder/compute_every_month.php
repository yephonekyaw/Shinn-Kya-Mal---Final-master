<?php

    function totalRepeatMonthToRemind($start_date, $end_date)
    {
        // Change the datetime data to string
        $start_dates = strtotime($start_date);
        $end_dates = strtotime($end_date);

        $start_day = date("d", $start_dates);
        $start_month = date("m", $start_dates);
        $start_year = date("Y", $start_dates);

        $end_day = date("d", $end_dates);
        $end_month = date("m", $end_dates);
        $end_year = date("Y", $end_dates);

        $totalRemindMonth = array();
        $totalMonthToRemind = array();
        $date = "";

        // Calculate total month that user want to remind him
        for($i = $start_month ; $i <= $end_month ; $i++)
        {
            if($i != $start_month)
            {
                $i = '0'.$i;
                array_push($totalRemindMonth, $i);
            }
            else 
            {
                array_push($totalRemindMonth, $i);
            }
        }

        // Compute month to remind
        for($j = 0 ; $j < count($totalRemindMonth) ; $j++)
        {
            $current_month = $totalRemindMonth[$j];
            $lastDayOfMonth = calculate_dayOfMonth($current_month, $start_year);

            if($j == count($totalRemindMonth) - 1)
            {
                if($end_day >= $start_day)
                {
                    // array_push($totalMonthToRemind, $start_day);
                    $date = $start_year."-".$current_month."-".$start_day;
                    array_push($totalMonthToRemind, $date);
                }
            }
            else 
            {
                if($start_day <= $lastDayOfMonth)
                {
                    // array_push($totalMonthToRemind, $start_day);
                    $date = $start_year."-".$current_month."-".$start_day;
                    array_push($totalMonthToRemind, $date);
                }
                else if($start_day > $lastDayOfMonth)
                {
                    // array_push($totalMonthToRemind, $lastDayOfMonth);
                    $date = $start_year."-".$current_month."-".$lastDayOfMonth;
                    array_push($totalMonthToRemind, $date);
                }
            }
        }

        return $totalMonthToRemind;
    }

?>