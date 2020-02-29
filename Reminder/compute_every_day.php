<?php
    function totalRepeatDayToRemind($start_date, $end_date)
    {
        // Change the datetime data to string
        $start_date = strtotime($start_date);
        $end_date = strtotime($end_date);

        $start_day = date("d", $start_date);
        $start_month = date("m", $start_date);
        $start_year = date("Y", $start_date);

        $end_day = date("d", $end_date);
        $end_month = date("m", $end_date);
        $end_year = date("Y", $end_date);


        $totalRemindMonth = array();
        $totalRemindDay = array();
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

        if(count($totalRemindMonth) == 1)
        {
            for($i = $start_day ; $i <= $end_day ; $i++)
            {
                // array_push($totalRemindDay, $i);
                $date = $start_year."-".$start_month."-".$i;
                array_push($totalRemindDay, $date);
            }
        }
        else 
        {
            for($i = 0 ; $i < count($totalRemindMonth) ; $i++)
            {
                $currentMonth = $totalRemindMonth[$i];
                $currentMonthLastDay = calculate_dayOFMonth($currentMonth, $start_year);
                if($i == 0)
                {
                    for($j = $start_day ; $j <= $currentMonthLastDay ; $j++ )
                    {
                        // array_push($totalRemindDay, $j);
                        $date = $start_year."-".$currentMonth."-".$j;
                        array_push($totalRemindDay, $date);
                    }
                }
                else if( $i > 0 && $i < ( count($totalRemindMonth) - 1 ) )
                {
                    for($j = 1 ; $j <= $currentMonthLastDay ; $j++)
                    {
                        if($j >= 1 && $j <= 9)
                        {
                            $j = '0'.$j;
                            // array_push($totalRemindDay, $j);
                            $date = $start_year."-".$currentMonth."-".$j;
                            array_push($totalRemindDay, $date);
                        }
                        else 
                        {
                            // array_push($totalRemindDay, $j);
                            $date = $start_year."-".$currentMonth."-".$j;
                            array_push($totalRemindDay, $date);
                        }
                    }
                }
                else if( $i == ( count($totalRemindMonth) - 1 ) )
                {
                    for($j = 1 ; $j <= $end_day ; $j++)
                    {
                        if($j >= 1 && $j <= 9)
                        {
                            $j = '0'.$j;
                            // array_push($totalRemindDay, $j);
                            $date = $start_year."-".$currentMonth."-".$j;
                            array_push($totalRemindDay, $date);
                        }
                        else 
                        {
                            // array_push($totalRemindDay, $j);
                            $date = $start_year."-".$currentMonth."-".$j;
                            array_push($totalRemindDay, $date);
                        }
                    }
                }
            }
        }

        return $totalRemindDay;
    }

    function calculate_dayOFMonth($month, $year)
    {
        $dayOfMonth = 0;
        if($month == '01')
        {
            $dayOfMonth = 31;
        }
        else if($month == '02')
        {
            if($year % 4 == 0)
            {
                $dayOfMonth = 29;
            }
            else 
            {
                $dayOfMonth = 28;
            }
        }
        else if($month == '03')
        {
            $dayOfMonth = 31;
        }
        else if($month == '04')
        {
            $dayOfMonth = 30;
        }
        else if($month == '05')
        {
            $dayOfMonth = 31;
        }
        else if($month == '06')
        {
            $dayOfMonth = 30;
        }
        else if($month == '07')
        {
            $dayOfMonth = 31;
        }
        else if($month == '08')
        {
            $dayOfMonth = 31;
        }
        else if($month == '09')
        {
            $dayOfMonth = 30;
        }
        else if($month == '10')
        {
            $dayOfMonth = 31;
        }
        else if($month == '11')
        {
            $dayOfMonth = 30;
        }
        else if($month == '12')
        {
            $dayOfMonth = 31;
        }
        
        return $dayOfMonth;
    }
?>