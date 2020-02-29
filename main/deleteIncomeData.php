<?php
    session_start();
    if(isset($_SESSION['user']))
    {
        $user_id = $_SESSION['id'];
        $id = $_GET['id'];
        include("cons/config.php");

        // Get Categories Name from income table
        $sql = "SELECT * FROM income WHERE income_id='$id' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $catName = $row['income_categories'];
        $date = $row['income_dateTime'];
        $dateMonth = date('m',strtotime($date));

        // Get Id Form Categories Table
        $sqlCatId = "SELECT * FROM incomecat WHERE income_categories_name='$catName' ";
        $resultCatId = mysqli_query($conn, $sqlCatId);
        $rowCatId = mysqli_fetch_assoc($resultCatId);
        $catId = $rowCatId['income_categories_id'];

        // Minus From incomeByCat
        $sqlMin = "SELECT * FROM incomebycat WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' ";
        $resutlMin = mysqli_query($conn, $sqlMin);
        $rowMin = mysqli_fetch_assoc($resutlMin);
        $amountMin = 0;
        $amountMin = $rowMin['income_cat_amount'] - $row['income_amount'];

        // Update incomeByCat table
        mysqli_query($conn,"UPDATE incomebycat SET income_cat_amount='$amountMin' WHERE income_cat_fk_id='$catId' AND income_user_cat_id='$user_id' AND MONTH(income_cat_date)='$dateMonth' ");

        // Delete From income
        $sqlDel = "DELETE FROM income WHERE income_id='$id' AND income_user_fk_id='$user_id' ";
        mysqli_query($conn, $sqlDel);
        header("location: incomeMainPage.php?month=$dateMonth ");
    }
    else if(!isset($_SESSION['user']))
    {
        header("location: signinPage.php?");
        exit();
    }
?>