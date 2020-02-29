<?php
    session_start();
    include("../main/cons/config.php");
    include("compute_every_day.php");
    include("compute_every_week.php");
    include("compute_every_month.php");

    if(isset($_SESSION['user']))
    {   
        if(isset($_POST['add']))
        {
            $id = $_SESSION['id'];
            $email = $_SESSION['email'];

            // Get data to save in the database
            $rem_desc = mysqli_real_escape_string($conn, $_POST['description']);
            $rem_start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
            $rem_end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
            $rem_repeat = mysqli_real_escape_string($conn, $_POST['repeat']);
            $rem_amount = mysqli_real_escape_string($conn, $_POST['amount']);
            $rem_type = mysqli_real_escape_string($conn, $_POST['type']);

            $reminder_schedule_id = rand(111111,999999);
            $alreadyUsed = false;

            // Check it(random number) is already used in the database as primary key
            do{
                $sqlCheckRan = "SELECT * FROM reminder_schedule WHERE reminder_schedule_id='$reminder_schedule_id' ";
                $resultCheckRan = mysqli_query($conn, $sqlCheckRan);
                $rowCheckRan = $resultCheckRan->fetch_assoc();
                if( $rowCheckRan > 0 )
                {
                    $alreadyUsed = true;
                    $reminder_schedule_id = rand(111111,999999);
                }
            }while($alreadyUsed == true);

            // Insert into the schedule table
            if($alreadyUsed == false)
            {
                $sqlSchedule = "INSERT INTO reminder_schedule(reminder_schedule_id, reminder_user_fk_id, reminder_description, reminder_start_date, reminder_end_date, reminder_repeat, reminder_amount, reminder_type) VALUES('$reminder_schedule_id','$id','$rem_desc','$rem_start_date','$rem_end_date','$rem_repeat','$rem_amount','$rem_type')";
                mysqli_query($conn,$sqlSchedule);
            }

            // Insert into the database
            if($rem_repeat == "day")
            {
                $addDay = "";
                $totalDayToRemind = totalRepeatDayToRemind($rem_start_date, $rem_end_date);
                for($j = 0 ; $j < count($totalDayToRemind) ; $j++)
                {
                    $addDay = $totalDayToRemind[$j];
                    $addDay = date('Y-m-d', strtotime($addDay));

                    $sqlDay = "INSERT INTO reminder_event(reminder_id,reminder_user_fk_id,reminder_schedule_fk_id,reminder_description,reminder_date,reminder_amount,reminder_type,check_reminder) VALUES (null,'$id','$reminder_schedule_id','$rem_desc','$addDay','$rem_amount','$rem_type',0)";
                    mysqli_query($conn, $sqlDay);
                }
            }
            else if($rem_repeat == "week")
            {
                $addDay = "";
                $totalWeekToRemind = totalRepeatWeekToRemind($rem_start_date, $rem_end_date);
                for($j = 0 ; $j < count($totalWeekToRemind) ; $j++)
                {
                    $addDay = $totalWeekToRemind[$j];
                    $addDay = date('Y-m-d', strtotime($addDay));

                    $sqlWeek = "INSERT INTO reminder_event(reminder_id,reminder_user_fk_id,reminder_schedule_fk_id,reminder_description,reminder_date,reminder_amount,reminder_type,check_reminder) VALUES (null,'$id','$reminder_schedule_id','$rem_desc','$addDay','$rem_amount','$rem_type',0)";
                    mysqli_query($conn, $sqlWeek);
                }
            }
            else if($rem_repeat == "month")
            {
                $addDay = "";
                $totalMonthToRemind = totalRepeatMonthToRemind($rem_start_date, $rem_end_date);
                for($j = 0 ; $j < count($totalMonthToRemind) ; $j++)
                {
                    $addDay = $totalMonthToRemind[$j];
                    $addDay = date('Y-m-d', strtotime($addDay));

                    $sqlMonth = "INSERT INTO reminder_event(reminder_id,reminder_user_fk_id,reminder_schedule_fk_id,reminder_description,reminder_date,reminder_amount,reminder_type,check_reminder) VALUES (null,'$id','$reminder_schedule_id','$rem_desc','$addDay','$rem_amount','$rem_type',0)";
                    mysqli_query($conn, $sqlMonth);
                }
            }

        }
        else if(isset($_POST['logout']))
        {
            header("location:logout.php?");
        }
    }
    else 
    {
        header("location:signin.php?");
    }
?>
<html>
    <head>
        <title>Add Reminder</title>
    </head>
    <body>
        <html>
            <form action="" method="POST">
                <label for="">Description:</label>
                <input type="text" name="description" placeholder="Description..."><br>  

                <label for="">Start Date:</label>
                <input type="date" name="start_date"><br>

                <label for="">End Date:</label>
                <input type="date" name="end_date"><br>

                <label for="">Repeat:</label>
                <select name="repeat" id="">
                    <option value="month">Every Month</option>
                    <option value="week">Every Week</option>
                    <option value="day">Every Day</option>
                </select><br>

                <label for="">Amount:</label>
                <input type="text" name="amount"><br>

                <label for="">Type:</label>
                <select name="type" id="">
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                    <option value="refund">Refund</option>
                    <option value="transfer">Transfer</option>
                </select><br>

                <input type="submit" name="add" value="Add">
                <input type="submit" name="logout" value="Log Out">

            </form>
        </html>
    </body>
</html>