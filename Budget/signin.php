<?php
    
    session_start();
    include("../main/cons/config.php");
    if(isset($_POST['login']))
    {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM userinfo where user_email='$email' ";
        $resutl = mysqli_query($conn, $sql);
        $row = $resutl->fetch_assoc();
        if($row > 0)
        {
            $_SESSION['id'] = $row['user_id'];
            $_SESSION['email'] = $row['user_email'];
            $_SESSION['user'] = true;
            header("location:addBudget.php?");
        }
    }
?>

<html>
    <head>
        <title>Sign In</title>
    </head>
    <form action="" method="POST">

        <label for="">Email:</label>
        <input type="email" name="email"><br>

        <label for="">Password:</label>
        <input type="password" name="password"><br>

        <input type="submit" value="Log In" name="login">
    </form>
</html>