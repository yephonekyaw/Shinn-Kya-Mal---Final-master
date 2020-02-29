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
    }
    else if(!isset($_SESSION['user']))
    {
        header("location: signinPage.php?");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.php" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <script src="https://kit.fontawesome.com/8da23e008a.js"></script>
    <link href="https://fonts.googleapis.com/css?family=DM+Sans&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="Image/Piggy.png">
    <title>My Profile</title>


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

    <header id="main">
        <nav class="navbar navbar-light bg-primary">
            <a class="navbar-brand" href="#"><i class="fas fa-piggy-bank"></i>Shinn Kya Mal</a>
            <ul class="navbar-nav mr-auto my-auto">
                <li class="nav-item">
                    Profile
                </li>
            </ul>
            <span><a href=""><i class="fas fa-user-circle"></i></a></span>
        </nav>
    </header>

    <?php
        $currentMont = date('m', time());
    ?>

    <section id="sub-Main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 shadow justify-content-md-center" id="left-column">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="monthlyMainPage.php?month=<?php echo($currentMont) ?>">
                                <i class="fas fa-chart-line"></i>
                                <span>Monthly Overview</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="incomeMainPage.php?month=<?php echo($currentMont) ?>">
                                <i class="fas fa-plus"></i>
                                <span>Incomes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="expenseMainPage.php?month=<?php echo($currentMont) ?>">
                                <i class="fas fa-minus"></i>
                                <span>Expense</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout_inc.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <span> Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>


                <div class="col AccountProfile" id="middle-column">
                    <div class="container-fluid">
                        <div class="row justify-content-md-center">
                            <img src="Image/PiggyProfile.png" class="img-fluid" alt="">
                        </div>
                        <div class="row justify-content-md-center">
                            <h2><?php echo($row['user_name']) ?></h2>
                        </div>
                        <div class="row justify-content-md-center mr-5">
                            <div class="col-3 text-right">
                                <h6>Email Address</h6>
                            </div>
                            <div class="col-3">
                                <h6><?php echo($email) ?></h6>
                            </div>
                        </div>
                        <div class="row justify-content-md-center mr-5">
                            <div class="col-3 text-right">
                                <h6>Password</h6>
                            </div>
                            <div class="col-3">
                                <h6>&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;</h6>
                            </div>
                        </div>

                        <div class="row justify-content-md-center mr-5">
                            <div class="col-3">

                            </div>
                            <div class="col-3">
                                <a href="" data-toggle="modal" data-target="#changePassword">Change Password?</a>
                            </div>
                        </div>

                        <div class="row justify-content-md-center mr-5 py-4">
                            <div class="col-3">

                            </div>
                            <div class="col-3">
                                <h6 class="font-weight-bold">Delete Account</h6>
                                <p>
                                    Be careful. This will delete your user account and all the information you entered.
                                    Expenses, income, all will be deleted.
                                </p>
                                <a href="" data-toggle="modal" data-target="#deleteAccountModal">Delete my account</a>
                            </div>

                        </div>

                        
                        <div class="row justify-content-md-center">
                                <p><i class="fas fa-copyright"></i> 2019 UIT. All Rights Reserved. </p>
                            </div>
                </div>

            </div>
        </div>
        </div>
    </section>


    <div class="modal fade" tabindex="-1" id="changePassword" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body justify-content-md-center">
                    <form action="passChange.php" class="container-fluid" method="POST">
                        <div class="row">
                            <label>Enter Current Password</label>
                        </div>
                        <div class="row">
                            <input name="curPass" type="password" class="form-control" id="password" required>
                        </div>
                        <div class="row">
                                <label>Enter New Password</label>
                            </div>
                            <div class="row">
                                <input name="newPass" type="password" class="form-control" id="password" required>
                            </div>
                            <div class="row">
                                    <label>Confirmed Password</label>
                                </div>
                                <div class="row">
                                    <input name="newConfPass" type="password" class="form-control" id="password" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button name="change" type="submit" class="btn btn-primary">Change</button>
                                </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" tabindex="-1" id="deleteAccountModal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete My Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body justify-content-md-center mx-4">
                        <p> Be careful. This will delete your user account and all the information you entered.
                                Expenses, income, all will be deleted.</p>
                    </div>
                    <form action="deleteAccount.php" method="POST">
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button name="confirm" type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                    </form>
                    </div>
                    
                </div>
            </div>
    
            <?php
        $fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if(strpos($fullURL, "error=wrongpassword") == true)
        {
        ?>
                <script>
                    swal ( "Oops" ,  "Your current password is not equal!" ,  "error" );
                </script>
        <?php            
            }
            else if(strpos($fullURL, "error=equalpassword") == true)
            {
        ?>
                <script>
                    swal ( "Oops" ,  "Please verify your new password!" ,  "error" );
                </script>
        <?php
            }
            else if(strpos($fullURL, "error=success") == true)
            {
        ?>
                <script>
                    swal ( "Great!" ,  "You have new password now!" ,  "success" );
                </script>
        <?php
            }
        ?>
        <script>
        window.onUsersnapCXLoad = function(api) {
            api.init();
        }
        var script = document.createElement('script');
        script.async = 1;
        script.src = 'https://widget.usersnap.com/load/3328a598-9f1d-40e8-9ad6-e66451d54aab?onload=onUsersnapCXLoad';
        document.getElementsByTagName('head')[0].appendChild(script);
        </script>

</body>

</html>