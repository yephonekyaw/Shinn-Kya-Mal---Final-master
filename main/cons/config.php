<?php 
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "moneymanager";

    $conn = mysqli_connect($dbhost,$dbuser, $dbpass);

    mysqli_select_db($conn, $dbname);

?>