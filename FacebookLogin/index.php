<?php

    //index.php

    include('config.php');
    include('../main/cons/config.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '..\PHPMailer-master\src\Exception.php';
    require '..\PHPMailer-master\src\PHPMailer.php';
    require '..\PHPMailer-master\src\SMTP.php';

    $mail = new PHPMailer(TRUE);

    $facebook_helper = $facebook->getRedirectLoginHelper();

    if(isset($_GET['code']))
    {
        if(isset($_SESSION['access_token']))
        {
            $access_token = $_SESSION['access_token'];
        }
        else
        {
            $access_token = $facebook_helper->getAccessToken();

            $_SESSION['access_token'] = $access_token;

            $facebook->setDefaultAccessToken($_SESSION['access_token']);
        }

        $_SESSION['user_name'] = '';
        $_SESSION['user_email_address'] = '';
        $_SESSION['user_image'] = '';

        $graph_response = $facebook->get("/me?fields=name,email", $access_token);

        $facebook_user_info = $graph_response->getGraphUser();

        if(!empty($facebook_user_info['id']))
        {
            $_SESSION['user_image'] = 'http://graph.facebook.com/'.$facebook_user_info['id'].'/picture';
        }

        if(!empty($facebook_user_info['name']))
        {
            $_SESSION['user_name'] = $facebook_user_info['name'];
        }

        if(!empty($facebook_user_info['email']))
        {
            $_SESSION['user_email_address'] = $facebook_user_info['email'];
        }
    
        if(isset($_SESSION['access_token']))
        {
            $oauth_provider = 'facebook';
            $user_name = $_SESSION['user_name'];
            $user_email = $_SESSION['user_email_address'];
            $user_picture = $_SESSION['user_image'];
            $user_password = substr( password_hash( 'dupa.8', PASSWORD_DEFAULT ), 8, 15 );

            // cretae token
            $token = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()/';
            $token = str_shuffle($token);
            $token = substr($token,0,10);

            // Hashing the password
            $user_hashedPwd = password_hash($user_password, PASSWORD_DEFAULT);

            // Check this account already exists or not
            $checkSql = "SELECT * from userinfo where oauth_provider='$oauth_provider' and user_email='$user_email' ";
            $resultCheckSql = mysqli_query($conn, $checkSql);
            $rowCheckSql = $resultCheckSql->fetch_assoc();
            if($rowCheckSql > 0)
            {
                // Destroy entire session data
                session_destroy();

                session_start();
                $_SESSION['id'] = $rowCheckSql['user_id'];
                $_SESSION['email'] = $rowCheckSql['user_email'];
                $_SESSION['user'] = true;

                // Get the current month
                $month = date('m', time());
                header("location: ../Asi/dashboard.php?month=$month"); 
            }
            else 
            {
                // No existing account so this is to insert the account
                $sql = "INSERT INTO userinfo (oauth_provider, user_name, user_email, user_password, token, created_date, mail_confirmation, one_time_password) VALUES ('$oauth_provider', '$user_name', '$user_email', '$user_hashedPwd', '$token', now(), 1, 0 )";
                mysqli_query($conn, $sql);

                // log in with existed account
                session_destroy();
                
                // Check the data that is being inserted into database or not
                session_start();
                $checkData = "SELECT * from userinfo WHERE oauth_provider='facebook' and user_email='$user_email' ";
                $resultCheckData = mysqli_query($conn, $checkData);
                $rowCheckData = $resultCheckData->fetch_assoc();
                if($rowCheckData > 0)
                {
                    $_SESSION['id'] = $rowCheckData['user_id'];
                    $_SESSION['email'] = $rowCheckData['user_email'];
                    $_SESSION['user'] = true;
    
                    // Get the current month
                    $month = date('m', time());
                    header("location:../Asi/dashboard.php?month=$month");
                }

                try {
   
                    $mail->setFrom('moneymanager03@gmail.com', 'Money Manager');
                    $mail->addAddress($user_email, $user_name);
                    
                    $mail->Subject = 'Money Manager - Log In With Facebook';
                    $mail->isHTML(TRUE);
                    $mail->AddEmbeddedImage("../main/Image/emailPiggy.png", "Piggy", "emailPiggy.png", "base64", "image/png");
                    $mail->Body = "
                          <html>
                          <head>
                             <meta charset='UTF-8'>
                             <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                             <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                             <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
                             <link rel='stylesheet' href='../main/emailStyle.css' type='text/css'>
                             <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
                             <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>
                             <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>
                             <title>Document</title>
                          </head>
                          <body>
                             <div id='outer'>         
                             <div class='inner'>
                                <header class='text-center'>
                                      <img src='cid:Piggy' alt='' width=150 height=150>
                                </header>
                                <h1>Money Manager</h1>
                                <p id='inline'>
                                    Welcome to Money Manager! Money Manager is the free website designed to give you the best money assistant in your Financial Plan. 
                                    <br>
                                    You are signed in as <i>$user_email</i>            
                                </p>
                                <hr>                                 
                                <div id='text'>
                                   <p>
                                      <b>Money Manager</b></p>
                                   <p class='small'> By Second year,Section (A)<br>
                                      University Of Information Technology
                                   </p>
                                </div>
                    
                             </div>
                          </div>
                          </body>
                          </html>
                    ";
                    
                    $mail->isSMTP();
                    
                 
                    /* SMTP server address. */
                    $mail->Host = 'smtp.gmail.com';
                 
                    /* Use SMTP authentication. */
                    $mail->SMTPAuth = TRUE;
                    
                    /* Set the encryption system. */
                    $mail->SMTPSecure = 'tls';
                    
                    /* SMTP authentication username. */
                    $mail->Username = 'moneymanager03@gmail.com';
                    
                    /* SMTP authentication password. */
                    $mail->Password = 'm0neyM@n@g3r';
                    
                    /* Set the SMTP port. */
                    $mail->Port = 587;
                    
                    /* Finally send the mail. */
                    $mail->send();
    
                }
                catch (Exception $e)
                {
                    echo $e->errorMessage();
                } 

            }
        }
    }
?>