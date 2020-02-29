<?php
    session_start();
    if(isset($_SESSION['user']))
    {
        $user_id = $_SESSION['id'];
        $id = $_GET['id'];
        include("cons/config.php");

        // Get Categories Name from expense table
        $sql = "SELECT * FROM expense WHERE expense_id='$id' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $catName = $row['expense_categories'];
        $date = $row['expense_dateTime'];
        $dateMonth = date('m',strtotime($date));

        // Get Id Form Categories Table
        $sqlCatId = "SELECT * FROM expensecat WHERE categories_name='$catName' ";
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
        mysqli_query($conn,"UPDATE expensebycat SET expense_cat_amount='$amountMin' WHERE expense_cat_fk_id='$catId' AND expense_user_cat_id='$user_id' AND MONTH(expense_cat_date)='$dateMonth' ");

        // Delete From Expense
        $sqlDel = "DELETE FROM expense WHERE expense_id='$id' AND expense_user_fk_id='$user_id' ";
        mysqli_query($conn, $sqlDel);
        header("location: expenseMainPage.php?month=$dateMonth ");
    }
    else if(!isset($_SESSION['user']))
    {
        header("location: signinPage.php?");
        exit();
    }
?>