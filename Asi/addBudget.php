<?php
    include("../main/cons/config.php");
    session_start();
    if(isset($_SESSION['user']))
    {
        $id=$_SESSION['id'];
        $email=$_SESSION['email'];
        if(isset($_POST['bud_add']))
        {
            $bud_cat = mysqli_real_escape_string($conn, $_POST['bud_cat']);
            $bud_month = mysqli_real_escape_string($conn, $_POST['bud_month']);
            $bud_amount = mysqli_real_escape_string($conn, $_POST['bud_amount']);

            // Take categories Id 
            $sqlCat = "SELECT categories_id FROM expensecat WHERE categories_name='$bud_cat' AND extra_cat_on_user_id IN(0,'$id')";
            $resultCat = mysqli_query($conn, $sqlCat);
            $rowCat = mysqli_fetch_assoc($resultCat);
            $catId = $rowCat['categories_id'];

            // Check that kind of budget already exists or not 
            $check_month = date('m', strtotime($bud_month));
            $sqlCheck = "SELECT * FROM expense_budget WHERE exp_cat_fk_id='$catId' AND exp_user_fk_id='$id' AND exp_bud_month='$check_month' ";
            $resultCheck = mysqli_query($conn, $sqlCheck);
            if($rowCheck = mysqli_fetch_assoc($resultCheck))
            {
                // Update more data or more budget
                $total = 0;
                $total = $rowCheck['exp_bud_amount'] + $bud_amount;
                $sqlUpdate = "UPDATE expense_budget SET expense_bud_amount = '$total' ";
                mysqli_query($conn, $sqlUpdate);
            }
            else if(!$rowCheck = mysqli_fetch_assoc($resultCheck))
            {
                $bud_month = date('m', strtotime($bud_month));

                // Check Budget Category is already used in expense transaction
                $sqlCheckUsed = "SELECT * FROM expensebycat WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$id' AND MONTH(expense_cat_date)='$bud_month' ";
                $resultCheckUsed = mysqli_query($conn, $sqlCheckUsed);
                if($rowCheckUsed = mysqli_fetch_assoc($resultCheckUsed))
                {
                    $usedAmount = $rowCheckUsed['expense_cat_amount'];
                }
                else if(!$rowCheckUsed = mysqli_fetch_assoc($resultCheckUsed))
                {
                    $usedAmount = 0;
                }

                // Insert into expense budget
                $sqlIn = "INSERT INTO expense_budget(exp_bud_id, exp_cat_fk_id, exp_user_fk_id, exp_bud_cat, exp_bud_month, exp_bud_amount, exp_bud_used_amount) VALUES(null, '$catId', '$id', '$bud_cat', '$bud_month', '$bud_amount', '$usedAmount')";
                mysqli_query($conn, $sqlIn);
                header("location:dashboard.php?month=$bud_month");
            }

        }
    }
    else
    {
        header("location:../main/signinPage.php?");
    }
