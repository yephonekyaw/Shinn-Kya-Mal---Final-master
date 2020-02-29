<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="script.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/8da23e008a.js"></script>
    <link href="https://fonts.googleapis.com/css?family=DM+Sans&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="Image/Piggy.png">
    <title>Sign Up</title>

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
    <!-- ----------------- Sign Up Form ----------------- -->

    <section class="Sign" id="SignUp">
        <nav class="navbar navbar-expand-sm">
            <a class="navbar-brand" href="homePage.php"><i class="fas fa-piggy-bank"></i>Shinn Kya Mal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
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
                <div class="col-md-5 SignUp">
                    <h1>Join Us Now</h1>
                    <form action="signup_inc.php" method="post" name="register" onsubmit="return passwordsMatch(this)">
                        <div class="form-group">
                            <input name="name" type="text" class="form-control" id="name" placeholder="Name" required title="Please enter your name">
                        </div>
                        <div class="form-group">
                            <input name="email" type="email" class="form-control" id="email" placeholder="Email" onkeyup="return gmailcheck();" required>
                        </div>
                        <div class="form-group">
                            <input name="password" type="password" class="form-control" id="password" name = password1 placeholder="Password" onkeyup="return passwordcheck();" required>
                            <small id="strength" class="text-muted">
                                Must be 8-20 characters long.
                            </small>
                        </div>
                        <div class="form-group">
                            <input name="conf_password" type="password" class="form-control" id="password2" placeholder="Confirmed Password" required>
                        </div>
                        <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="" id="gridCheck" required>
                                  <label class="form-check-label" for="gridCheck">
                                    Agree to terms and conditions
                                  </label>
                                </div>
                              </div>
                        <button name="submit" type="submit" class="btn btn-primary w-100  rounded-pill" data-toggle="modal" data-target="#TermsAndCondition">Sign Up</button>
                        <h6>Already Have an Account? <a href="signinPage.php">Sign In</a></h6>
                    </form>
                </div>
            </div>
        </div>
        <div class="container text-center">
            <h6><i class="fas fa-copyright"></i> 2020 UIT. All Rights Reserved. </h6>
        </div>
    </section>
    <?php
    $fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    if(strpos($fullURL, "signupPage=usertaken") == true)
    {
    ?>
        <script>
            swal ( "Oops" ,  "Your eamil address is already taken!" ,  "error" );
        </script>
    <?php          
    }
    else if(strpos($fullURL, "signupPage=invalidpassword") == true)
    {
    ?>
            <script>
                swal( "Oops", "Your two passwords do not match!" , "error");
            </script>
    <?php
    }
    ?>
</body>

</html>