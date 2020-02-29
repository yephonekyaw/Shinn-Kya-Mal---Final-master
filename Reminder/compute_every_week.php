<?php

    function totalRepeatWeekToRemind($start_date, $end_date)
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
        $totalWeekToRemind = array();
        $totalDayToRemind = totalRepeatDayToRemind($start_date, $end_date);
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

        $current_month = $start_month;
        $addWeek = $start_day;

        for($j = 1 ; $j <= ceil(count($totalDayToRemind) / 7) ; $j++)
        {
            $totalDayOfCurrentMonth = calculate_dayOFMonth($current_month, $start_year);
            if($j == 1)
            {
                // array_push($totalWeekToRemind, $addWeek);
                $date = $start_year."-".$current_month."-".$addWeek;
                array_push($totalWeekToRemind, $date);
            }
            else 
            {
                $addWeek = $addWeek + 7;
                if($addWeek > $totalDayOfCurrentMonth)
                {
                    if($current_month >= 1 && $current_month <= 9)
                    {
                        // Minus total day of current month from +7 day;
                        $addWeek = $addWeek - $totalDayOfCurrentMonth;

                        // Increase the current month to next month
                        $current_month = '0'.($current_month + 1);

                        if($addWeek >= 1 && $addWeek <= 9)
                        {
                            $addWeek = '0'.$addWeek;
                            // array_push($totalWeekToRemind, $addWeek);
                            $date = $start_year."-".$current_month."-".$addWeek;
                            array_push($totalWeekToRemind, $date);
                        }
                        else 
                        {
                            // array_push($totalWeekToRemind, $addWeek);
                            $date = $start_year."-".$current_month."-".$addWeek;
                            array_push($totalWeekToRemind, $date);
                        }
                    }
                    else 
                    {
                        // Minus total day of current month from +7 day;
                        $addWeek = $totalDayOfCurrentMonth - $addWeek;

                        // Increase the current month to next month
                        $current_month++;

                        if($addWeek >= 1 && $addWeek <= 9)
                        {
                            $addWeek = '0'.$addWeek;
                            // array_push($totalWeekToRemind, $addWeek);
                            $date = $start_year."-".$current_month."-".$addWeek;
                            array_push($totalWeekToRemind, $date);
                        }
                        else 
                        {
                            // array_push($totalWeekToRemind, $addWeek);
                            $date = $start_year."-".$current_month."-".$addWeek;
                            array_push($totalWeekToRemind, $date);
                        }
                    }
                }
                else 
                {
                    if($addWeek >= 1 && $addWeek <= 9)
                    {
                        $addWeek = '0'.$addWeek;
                    }
                    // array_push($totalWeekToRemind, $addWeek);
                    $date = $start_year."-".$current_month."-".$addWeek;
                    array_push($totalWeekToRemind, $date);
                }
            }
        }
        return $totalWeekToRemind;
        
    }

?>