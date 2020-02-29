<?php
     include("cons/config.php");
     $email=$_GET['email'];
 
     if(isset($_POST['reset-confirm-submit']))
     {
        
        $password=mysqli_real_escape_string($conn, $_POST['password']);
        $conf_password=mysqli_real_escape_string($conn, $_POST['conf_password']);
        
        if(empty($password) || empty($conf_password))
        {
            header("location: forgetPassReset.php?email=$email&password=empty");
        }
        else
        {
            if($password !== $conf_password)
            {
                header("location: forgetPassReset.php?email=$email&password=noequal");
            }
            else
            {
                $pwdHash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "SELECT user_password, mail_confirmation FROM userinfo WHERE user_email='$email' ";
                $result=mysqli_query($conn, $sql);
                if($row = mysqli_fetch_assoc($result))
                {
                    mysqli_query($conn, "UPDATE userinfo SET user_password='$pwdHash' , mail_confirmation=1 WHERE user_email='$email' ");
                    header("location: forgetPassReset.php?email=$email&reset=success");
                }
                else
                {
                    header("location: forgetPassEmailPage.php?email=$email&error=nouser");
                }
            }
        }  
     }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/8da23e008a.js"></script>
    <link href="https://fonts.googleapis.com/css?family=DM+Sans&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="shortcut icon" type="image/png" href="Image/Piggy.png">
    <title>Verification Form</title>
</head>

<body>

    <!-- ----------------- Verification form ----------------- -->
    <section id="Verification">
        <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
            <a class="navbar-brand" href="home.html"><i class="fas fa-piggy-bank"></i>Shinn Kya Mal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="Signup.html">SIGN UP</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="Signin.html">SIGN IN</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container verification">
            <div class="row">
                <i class="fas fa-key"></i>
            </div>
            <div class="row">
                    <h2>Please Enter New Password</h2>
                    <!-- <p>We will send 6 codes to your email address.</p> -->
                    <form action="" method="POST">
                            <div class="form-group">
                                <!-- <label for="">Enter the code</label> -->
                                    <input name="password" type="password" class="form-control w-100" id="verificationCode" placeholder="New Password">
                                    <small id="passwordHelpInline" class="text-muted">
                                        Must be 8-20 characters long.
                                    </small>
                                </div>
                                <div class="form-group">
                                    <!-- <label for="">Enter the code</label> -->
                                        <input name="conf_password" type="password" class="form-control w-100" id="verificationCode" placeholder="Confirmed Password">
                                    </div>
                                <button name="reset-confirm-submit" type="submit" class="btn btn-primary">Confirmed</button>
                    </form>
            </div>
        </div>

        <div class="container">
            <h6><i class="fas fa-copyright"></i> 2019 UIT. All Rights Reserved. </h6>
        </div>
    </section>
    <?php
            $fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            if(strpos($fullURL, "password=empty") == true)
            {
    ?>
            <script>
                swal ( "Oops" ,  "Code is empty!" ,  "error" );
            </script>
    <?php          
            }
            else if(strpos($fullURL, "password=noequal") == true)
            {
    ?>
            <script>
                swal ( "Oops" ,  "Code is wrong!" ,  "error" );
            </script>
    <?php       
            }
            else if(strpos($fullURL, "error=nouser") == true)
            {
    ?>
            <script>
                swal ( "Oops" ,  "Your account is not found!" ,  "error" ); 
            </script>
    <?php
            }
            else if(strpos($fullURL, "reset=success") == true)
            {
    ?>
            <script>
                swal ( "Done!" ,  "Your password is reset now!" ,  "success" );
            </script>
    <?php
            }
    ?> 

</body>

</html>