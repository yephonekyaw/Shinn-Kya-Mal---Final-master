<?php
    session_start();
    include("../main/cons/config.php");
    if (isset($_SESSION['user'])) {

        $user_id = $_SESSION['id'];
        $id = $_GET['id'];

        // Get Categories Name from expense table
        $sql = "SELECT * FROM expense WHERE expense_id='$id' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $catName = $row['expense_categories'];
        $date = $row['expense_dateTime'];
        $dateMonth = date('m', strtotime($date));

        // Get Id Form Categories Table
        $sqlCatId = "SELECT * FROM expensecat WHERE categories_name='$catName' AND extra_cat_on_user_id IN(0,'$user_id') ";
        $resultCatId = mysqli_query($conn, $sqlCatId);
        $rowCatId = mysqli_fetch_assoc($resultCatId);
        $catId = $rowCatId['categories_id'];

        // Minus From ExpenseByCat
        $sqlMin = "SELECT * FROM expensebycat WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' ";
        $resutlMin = mysqli_query($conn, $sqlMin);
        $rowMin = mysqli_fetch_assoc($resutlMin);
        $amountMin = 0;
        $amountMin = $rowMin['expense_cat_amount'] - $row['expense_amount'];

        // Update ExpenseByCat table
        mysqli_query($conn, "UPDATE expensebycat SET expense_cat_amount='$amountMin' WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' ");
        mysqli_query($conn, "DELETE FROM expensebycat WHERE expense_cat_amount = 0");

        // Minus used amount From budget table
        $totalBudUsed = 0;
        $sqlBud = "SELECT * FROM expense_budget WHERE exp_cat_fk_id='$catId' AND exp_user_fk_id='$user_id' AND exp_bud_month='$dateMonth' ";
        $resultBud = mysqli_query($conn, $sqlBud);
        if ($rowBud = mysqli_fetch_assoc($resultBud)) {
            $totalBudUsed = $rowBud['exp_bud_used_amount'] - $row['expense_amount'];

            // Update used budget
            mysqli_query($conn, "UPDATE expense_budget SET exp_bud_used_amount='$totalBudUsed' WHERE exp_cat_fk_id='$catId' AND exp_user_fk_id='$user_id' AND exp_bud_month='$dateMonth' ");
        }

        // Delete From Expense
        $sqlDel = "DELETE FROM expense WHERE expense_id='$id' AND expense_user_fk_id='$user_id' ";
        mysqli_query($conn, $sqlDel);
        header("location: dashboard.php?month=$dateMonth ");

    } else if (!isset($_SESSION['user'])) {
        header("location: signinPage.php?");
        exit();
    }
?>