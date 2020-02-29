<?php
    session_start();
    include("cons/config.php");
    if(isset($_SESSION['user']))
    {
        $id=$_SESSION['id'];
        $email=$_SESSION['email'];
        $sql = "SELECT * FROM userinfo WHERE user_id='$id' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if(isset($_POST['change']))
        {
            $curPass = mysqli_real_escape_string($conn, $_POST['curPass']);
            $newPass = mysqli_real_escape_string($conn, $_POST['newPass']);
            $newCurPass = mysqli_real_escape_string($conn, $_POST['newConfPass']);
            
            $pwdCheck = password_verify($curPass, $row['user_password']);
            if($pwdCheck == false)
            {
                header("location: profilePage.php?error=wrongpassword");
            }
            else 
            {
                if($newPass != $newCurPass)
                {
                    header("location: profilePage.php?error=equalpassword");
                }
                else
                {
                    $hashedPwd = password_hash($newPass, PASSWORD_DEFAULT);
                    mysqli_query($conn, "UPDATE userinfo SET user_password='$hashedPwd' WHERE user_id='$id' ");
                    header("location: profilePage.php?error=success");
                }
            }
        }
    }
    else if(!isset($_SESSION['user']))
    {
        header("location: signinPage.php?");
    }
?>