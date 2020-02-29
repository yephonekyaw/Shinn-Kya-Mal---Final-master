<?php
    session_start();
    include("../main/cons/config.php");

    if(isset($_SESSION['user']))
    {
        if(isset($_POST['addBud']))
        {
            $id = $_SESSION['id'];
            $email = $_SESSION['email'];

            // Get data to save in the database
            $bud_cat = mysqli_real_escape_string($conn, $_POST['bud_cat']);
            $bud_amount = mysqli_real_escape_string($conn, $_POST['bud_amount']);
            $bud_start_date = mysqli_real_escape_string($conn, $_POST['bud_start_date']);
            $bud_end_date = mysqli_real_escape_string($conn, $_POST['bud_end_date']);
            $bud_type = mysqli_real_escape_string($conn, $_POST['bud_type']);

            if($bud_type == "expense")
            {
                // Get expense category id
                $sqlExpCatId = "SELECT * FROM expensecat WHERE extra_cat_on_user_id IN(0, $id) AND categories_name='$bud_cat'";
                $resultExpCatId = mysqli_query($conn, $sqlExpCatId);
                while($rowExpCatId = mysqli_fetch_assoc($resultExpCatId))
                {
                    $bud_cat_id = $rowExpCatId['categories_id'];
                }
                

                // Insert into the database 
                $sqlExpIn = "INSERT INTO expense_budget(exp_bud_id, exp_cat_fk_id, exp_user_fk_id, exp_bud_cat, exp_bud_amount, exp_bud_used_amount, exp_bud_start_date, exp_bud_end_date) VALUES (null, '$bud_cat_id', '$id', '$bud_cat', '$bud_amount', 0, '$bud_start_date', '$bud_end_date')";
                mysqli_query($conn, $sqlExpIn);
            }
            else if($bud_type == "income")
            {
                // Get income category id
                $sqlInCatId = "SELECT * FROM incomecat WHERE extra_cat_on_user_id IN(0, $id) AND income_categories_name='$bud_cat'";
                $resultInCatId = mysqli_query($conn, $sqlInCatId);
                while($rowInCatId = mysqli_fetch_assoc($resultInCatId))
                {
                    $bud_cat_id = $rowInCatId['income_categories_id'];
                }

                // Insert into the database
                $sqlIn = "INSERT INTO income_budget(inc_bud_id, inc_cat_fk_id, inc_user_fk_id, inc_bud_cat, inc_bud_amount, inc_bud_used_amount, inc_bud_start_date, inc_bud_end_date) VALUES (null, '$bud_cat_id', '$id', '$bud_cat', '$bud_amount', 0, '$bud_start_date', '$bud_end_date')";
                mysqli_query($conn, $sqlIn);
            }
        }
        else if(isset($_POST['logout']))
        {
            header("location:logout.php?");
        }
    }
?>

<html>
    <head>
        <title>Add Budget</title>
    </head>
    <form action="" method="POST">
        <label for="">Category Name:</label>
        <input type="text" name="bud_cat"><br>

        <label for="">Budget Amount:</label>
        <input type="text" name="bud_amount"><br>

        <label for="">Start Date:</label>
        <input type="date" name="bud_start_date"><br>

        <label for="">End Date:</label>
        <input type="date" name="bud_end_date"><br>

        <label for="">Budget Type:</label>
        <select name="bud_type" id="">
            <option value="expense">Expense</option>
            <option value="income">Income</option>
        </select><br>

        <input type="submit" value="Add Budget" name="addBud">
        <input type="submit" value="Log Out" name="logout">
    </form>
</html>