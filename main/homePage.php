<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css" type="text/css">
    <script src="script.js"></script>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/8da23e008a.js"></script>
    <link href="https://fonts.googleapis.com/css?family=DM+Sans&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="Image/Piggy.png">
    <title>Home Page</title>


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

    <!-- ---------------- Navigation Bar ---------------- -->

    <header id="Top">
        <nav class="navbar fixed-top navbar-expand-sm " data-spy="affix">
            <!-- <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light"> -->
            <a class="navbar-brand" href="homePage.php"><i class="fas fa-piggy-bank"></i>Shinn Kya Mal</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#FAQ">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#Contact">CONTACT</a>
                    </li>
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
                <div class="col-md-6 text-left mx-2">
                    <h1>Track all your cash in <span>one place</span> </h1>

                    <p>Shinn Kya Mal helps you with the financial means.
                        So you can <span>focus on the goals</span> .</p>

                    <a href="#Features" class="btn btn-outline-dark"> Let's Start</a>
                </div>
            </div>

        </div>
        </div>
    </header>

    <!-- ---------------- Our Main Features ---------------- -->
    <section id="Features">
        <div class="container">
            <h1>Main Features</h1>
            <div class="row feature">
                <div class="col-md-4 text-center">
                    <div class="icon">
                        <i class="far fa-chart-bar"></i>
                    </div>
                    <h3>Analysis</h3>
                    <p>Easily Analysis your financial in one place
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Security</h3>
                    <p>Since our Web use strong security, 
                    it's not necessary to worry about your data
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="icon">
                        <i class="fas fa-medkit"></i>
                    </div>
                    <h3>Support</h3>
                    <p>We provide our mail so that every user could ask if your system had any error
                    </p>
                </div>
            </div>
            <div class="row justify-content-md-center feature">
                <div class="col-md-4 text-center">
                    <div class="icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Privacy</h3>
                    <p>All your personal data are all yours.
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <h3>Reliable</h3>
                    <p>You can trust us for your future plan and every data is correct.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- ---------------- How ---------------- -->

    <section id="How">
        <div class="container">
            <h1>How?</h1>
            <div class="row">
                <div class="col-md-7 Instruction">
                    <h2> <span>1.</span> <a href="signinPage.php" class="btn btn-dark">Sign In</a> <span
                            class="or">(OR)</span> <a href="signupPage.php" class="btn btn-dark">Sign Up</a></h2>
                    <small>to enter your cash notebook.</small>
                    <h2> <span>2.</span> Start Tracking Your Cash Daily</h2>
                    <small>Food, bills, shopping. Whatever</small> <br>
                    <h2> <span>3.</span> Let's track expenses and incomes</h2>
                    <small>Enter it in the app. Quickly. A basic expense is just 4 taps: </small> <br>
                    <small> Amount, next, category, save. Bam! Done.</small>
                </div>
                <div class="col-md-5">
                    <img src="Image/Mac.jpg" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- ---------------- Contact Us ---------------- -->
    <section id="Contact">
        <div class="container">
            <h1>Contact Us</h1>
            <div class="row">
                <div class="col-md-6">
                    <img src="Image/ContactBG.png" class="img-fluid" alt="">
                </div>
                <div class="col-md-6 contact-info">
                    <div class="follow">
                        <b>Address:</b>
                        <i class="fas fa-map-marker-alt"></i>
                        Parami Road, Hlaing Campus, Yangon, Myanmar
                    </div>
                    <div class="follow">
                        <b>Email:</b>
                        <i class="fas fa-envelope"></i>
                        moneymanger03@gmail.com
                    </div>
                    <div class="follow">
                        <b>Phone:</b>
                        <i class="fas fa-phone-alt"></i>
                        +951-9664254
                    </div>
                    <div class="follow">
                        <b>Get Social:</b>
                        <a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ---------------- Our Team ---------------- -->
    <section id="Team">
        <div class="container">
            <h1>Our Team</h1>
            <div class="row justify-content-md-center">
                <div class="col-md-2 profile-pic text-center">
                    <div class="img-box">
                        <img src="Image/YePhoneKyaw.jpg" class="img-fluid" alt="">
                        <!-- <ul class="align-middle">
                            <a href="https://www.facebook.com/yephone.kyaw.5439"><li><i class="fab fa-facebook"></i></li></a>
                        </ul> -->
                    </div>
                    <h2>Ye Phone Kyaw</h2>
                    <!-- <h3>Leader</h3> -->
                </div>

                <div class="col-md-2 profile-pic text-center">
                    <div class="img-box">
                        <img src="Image/Nyan Swan Aung.jpg" class="img-fluid" alt="">
                    </div>
                    <h2>Nyan Swan Aung</h2>
                    <!-- <h3>Backend Developer</h3> -->
                </div>

                <div class="col-md-2 profile-pic text-center">
                    <div class="img-box">
                        <img src="Image/KaungMyatHtet.jpg" class="img-fluid" alt="">
                    </div>
                    <h2>Kaung Myat Htet</h2>
                    <!-- <h3>UI/UX Designer</h3> -->
                </div>

                <!-- <div class="col-md-2 profile-pic text-center">
                    <div class="img-box">
                        <img src="Image/KaungMinHtet.jpg" class="img-fluid" alt="">
                    </div>
                    <h2>Kaung Min Htet</h2>
                    <h3>Error Tester</h3>
                </div> -->
            </div>

            <div class="row justify-content-md-center">
                <div class="col-md-2 profile-pic text-center">
                    <div class="img-box">
                        <img src="Image/Han Nwae.jpg" class="img-fluid" alt="">
                    </div>
                    <h2>Han Nwae Nyein</h2>
                    <!-- <h3>Backend Developer</h3> -->
                </div>

                <div class="col-md-2 profile-pic text-center">
                    <div class="img-box">
                        <img src="Image/Hnin Kay Thayi Naing.jpg" class="img-fluid" alt="">
                    </div>
                    <h2>Hnin Kay Thayi Naing</h2>
                    <!-- <h3>UI/UX Designer</h3> -->
                </div>

                <!-- <div class="col-md-2 profile-pic text-center">
                    <div class="img-box">
                        <img src="Image/ZuZanWin.jpg" class="img-fluid" alt="">
                    </div>
                    <h2>Zu Zan Win</h2>
                    <h3>UI/UX Designer</h3>
                </div>
            </div> -->
        </div>
    </section>

    <!-- ---------------- FAQ ---------------- -->
    <section id="FAQ">
        <div class="container">
            <h1>FAQ</h1>
            <div class="row">
                <div class="col-md-5 justify-content-md-center">
                    <img src="Image/FAQ.png" class="img-fluid" alt="">
                </div>
                <div class="col-md-7 justify-content-md-center">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-secondary" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        What is Shinn Kya Mal?
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                Shinn Kya Mal allows you to track your finance. 
                                   You can check out your transaction in one place.
                                   You can make decision upon your income and expense.
                                   A goal without a plan is just a wish. So
                                   start your first plan with Shinn Kya Ml.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-secondary collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Does your information secure?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                As we provibe 2 factor authentications, you can fully trust us.
                                What you want are sites associated with trusted institutions that have been
                                 around for a while and have a proven track record of reliability and integrity we strongly advice to 
                                 choose our site. "Your finance Your Privacy"
                                 When you trust us, you have confidence in Shin Kya Ml - 
                                 in their integrity and in their abilities.
                                 In case you have any problam our administrator mail was provided.
                                 shinnkyaml@gmail.com.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-secondary collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        How much it costs to use the service?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                We have free site online for students and for personal use.
                                 For company and organization,we have premeium version.
                                  If you wish to use fully service update to Premium version
                                Purchase 25$ per month to get premium version.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-secondary collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                        How to use Shinn Kya Mal?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                Sign in our site 
                                    Ask for security code. 
                                    Paste it in the text box
                                    Click and download our user guide
                                    The User Guide (aka User Manual) provides the information and
                                     instructions needed to set up and use our site. Our User Guide includes written 
                                     and visual information (such as diagrams or screen shots) to assist the user in 
                                     completing tasks associated with the product (or service),
                                     organized along functional or workflow lines.
                                    If you have any problem, feel free to ask   shinnkyaml@gmail.com
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- ---------------- Footer ---------------- -->

    <footer class="bg-dark">
        <div class="container">
            <a class="brandlink" href="#Top">
                <h3>Shinn Kya Mal</h3>
            </a>
            <div class="row">
                <div class="col-md-6 links">
                    <ul>
                        <li><a href="privacypolicyPage.php">Privacy Policy</a></li>
                        <li><a href="TermsAndConditionPage.php">Terms And Condition</a></li>
                        <li><a href="#FAQ">FAQ</a></li>
                        <li><a href="#Contact">Contact</a></li>
                    </ul>

                    <ul>
                        <li></li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <form action="user_advice_mail.php" method="POST" class="contact-form">
                        <div class="form-group">
                            <input name="name" type="text" class="form-control" placeholder="Your Name">
                        </div>

                        <div class="form-group">
                            <input name="email" type="email" class="form-control" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <textarea name="message" rows="4" class="form-control" placeholder="Your Message"></textarea>
                        </div>
                        <button name="send-message-submit" type="submit" class="btn btn-outline-light">SEND MESSAGE</button>
                    </form>
                </div>
            </div>
            <div class="text-center copyright">
                <h5><i class="fas fa-copyright"></i> 2020 UIT. All Rights Reserved. </h5>
            </div>
        </div>
    </footer>
</body>

</html>