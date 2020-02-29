<?php
    include("cons/config.php");
    $email=$_GET['email'];

    if(isset($_POST['submit']))
    {
        $sql = "SELECT mail_confirmation, one_time_password FROM userinfo WHERE user_email=$email";
        $result=mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $code = $row['one_time_password'];
        $verify = $_POST['verify_code'];

        if(empty($verify))
        {
            header("location: mail_verify.php?email=$email&code=empty");
        }
        else if($code !== $verify)
        {
            header("location: mail_verify.php?email=$email&code=wrong ");
        }
        else if($code == $verify)
        {
            mysqli_query($conn, "UPDATE userinfo SET mail_confirmation=1, one_time_password=0 WHERE user_email=$email");
            header("location: verifyComplete.php?creation=success");
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
        <nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
            <a class="navbar-brand" href="home.html"><i class="fas fa-piggy-bank"></i>Shinn Kya Mal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="Signup.html">SIGN UP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Signin.html">SIGN IN</a>
                    </li>
                </ul>
            </div> -->
        </nav>

        <div class="container verification">
            <div class="row">
                <img src="Image/Email.png" class="rounded" alt="">
            </div>
            <div class="row">
                    <h2>Please Verify Your Email</h2>
                    <p>An email with a verification code was just sent to your mail</p>
                    <form action="" method="POST">
                            <div class="form-group">
                                <label for="">Enter the code</label>
                                <input name="verify_code" type="number" class="form-control w-100" id="verificationCode">
                            </div>
                                <button name="submit" type="submit" class="btn btn-primary">Verify</button>
                    </form>
            </div>
        </div>
        <div class="container">
            <h6><i class="fas fa-copyright"></i> 2019 UIT. All Rights Reserved. </h6>
        </div>
    </section>

    <?php
            $fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            if(strpos($fullURL, "code=empty") == true)
            {
    ?>
            <script>
                swal ( "Oops" ,  "Code is empty!" ,  "error" )
            </script>
    <?php          
            }
            else if(strpos($fullURL, "code=wrong") == true)
            {
    ?>
            <script>
                swal ( "Oops" ,  "Code is wrong!" ,  "error" )
            </script>
    <?php       
            }
    ?> 
    
</body>

</html>