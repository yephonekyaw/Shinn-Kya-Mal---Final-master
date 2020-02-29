<?php
    session_start(); 
    unset($_SESSION['user']);  
    header("location: ../main/homePage.php?"); 
    exit();
?>