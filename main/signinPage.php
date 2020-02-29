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
    <title>Sign In</title>


    <script>
        window.addEventListener("load", function () {
            const preloader = document.querySelector(".preloader");
            preloader.classList.add("hidden");
        });
    </script>
</head>

<body>

    <div class="preloader" id="Loader">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- ----------------- Sign In Form ----------------- -->

    <section id="SignIn" class="Sign">
        <nav class="navbar navbar-expand-sm">
            <a class="navbar-brand" href="homePage.php"><i class="fas fa-piggy-bank"></i>Shinn Kya Mal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="signupPage.php">SIGN UP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signinPage.php">SIGN IN</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-7">

                </div>
                <div class="col SignUp">
                    <h1>Welcome Back!</h1>
                    <form action="signin_inc.php" method="POST">
                            <div class="form-group">
                                <!-- <label for="email">Email</label> -->
                                <input name="user_email" type="email" class="form-control" id="email" placeholder="Email" onkeyup="return gmailcheck();">
                            </div>
                            <!-- <h6>Password</h6> -->
                            <div class="form-group">
                                <!-- <label for="password">Password</label> -->
                                <input name="user_password" type="password" class="form-control" id="password" placeholder="Password">
                                <!-- <a href="#"><small>Forget your password?</small></a> -->
                            </div>
                        <div class="row">
                            <div class="col forget align-middle">
                                <a href="forgetPassEmailPage.php"><small>Forget your password?</small></a>
                            </div>
                            <div class="col text-right">
                                <button name="sign-in-submit" type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                        <h6 class="mb-3">Doesn't Have an Account? <a href="signupPage.php">Register Now</a></h6>
                        <div class="row mb-3">
                            <div class="col text-center">
                                <button name="google-login" class="btn btn-outline-success px-3"> <i class="fab fa-google"></i> &ensp; Sign In With Google</button>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <button name="facebook-login" class="btn btn-outline-primary"> <i class="fab fa-facebook-f"></i> &ensp; Sign In With Facebook</button>
                            </div>
                        </div>
                    </form>
                    <script src="validation.js"></script>
                </div>
            </div>
        </div>
        <div class="sign-footer text-center">
            <h6><i class="fas fa-copyright"></i> 2020 UIT. All Rights Reserved. </h6>
        </div>
    </section>
    <?php
    $fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if(strpos($fullURL, "error=nouser") == true)
    {
    ?>
        <script>
            swal ( "Oops" ,  "Your address or password is wrong!" ,  "error" );
        </script>
    <?php          
        }
        else if(strpos($fullURL, "error=noconfirm") == true)
        {
    ?>
        <script>
            swal ( "Oops" ,  "Your are not confirmed yet!" ,  "error" );
        </script>
    <?php       
        }
        else if(strpos($fullURL, "error=wrongpassword") == true)
        {
    ?>
        <script>
            swal ( "Oops" ,  "Your address or password is wrong!" ,  "error" ); 
        </script>
    <?php
        }
        else if(strpos($fullURL, "login=empty") == true)
        {
    ?>
        <script>
            swal ("Oops" , "The fields are empty!" , "error");
        </script>
    <?php 
        }
        else if(strpos($fullURL, "email=empty") == true)
        {
    ?>
        <script>
            swal ("Oops" , "Email field is empty" , "error");
        </script>
    <?php
        }
        else if(strpos($fullURL, "password=empty") == true)
        {
    ?>
        <script>
            swal ("Oops" , "Password field is empty" , "error");
        </script>
    <?php
        }
    ?>
</body>

</html>