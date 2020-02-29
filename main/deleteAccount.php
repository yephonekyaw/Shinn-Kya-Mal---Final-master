<?php
    session_start();
    include("cons/config.php");
    if(isset($_SESSION['user']))
    {
        $id=$_SESSION['id'];
        $email=$_SESSION['email'];
        mysqli_query($conn, "DELETE FROM expense WHERE expense_user_fk_id='$id' ");
        mysqli_query($conn, "DELETE FROM income WHERE income_user_fk_id='$id' ");
        mysqli_query($conn, "DELETE FROM expensebycat WHERE expenes_user_cat_id='$id' " );
        mysqli_query($conn, "DELETE FROM incomebycat WHERE income_user_cat_id='$id' ");
        mysqli_query($conn, "DELETE FROM userinfo WHERE user_id='$id' ");
        header("location: homePage.php?");
    }
    else if(!isset($_SESSION['user']))
    {
        header("location: signinPage.php?");
    }
?>