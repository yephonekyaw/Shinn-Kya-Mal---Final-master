<?php

    include("cons/config.php");
    if(isset($_POST['sign-in-submit']))
    {
        $user_email=mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_passwrod=mysqli_real_escape_string($conn, $_POST['user_password']);
        
        if(empty($user_email) && empty($user_passwrod))
        {
            header("location: signinPage.php?login=empty");
        }
        else if(empty($user_email))
        {   
            header("location: signinPage.php?emial=empty");
        }
        else if(empty($user_passwrod))
        {
            header("location: signinPage.php?password=empty");
        }
        else
        {
            if(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $user_email))
            {
                $sql = "SELECT * FROM userinfo WHERE user_email=? ";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql))
                {
                    header("location: signinPage.php?error=sqlerror");
                }
                else 
                {
                    mysqli_stmt_bind_param($stmt, "s", $user_email);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    {
                        if($row = mysqli_fetch_assoc($result))
                        {
                            if($row['mail_confirmation'] == 1)
                            {
                                $pwdCheck = password_verify($user_passwrod, $row['user_password']);
                                if($pwdCheck == false)
                                {
                                    header("location: signinPage.php?error=wrongpassword");
                                }
                                else if($pwdCheck == true)
                                {
                                    session_start();
                                    $_SESSION['id'] = $row['user_id'];
                                    $_SESSION['email'] = $row['user_email'];
                                    $_SESSION['user'] = true;

                                    // Get the current month
                                    $month = date('m', time());
                                    header("location: ../Asi/dashboard.php?month=$month");
                                }
                            }
                            else if($row['mail_confirmation'] == 0)
                            {
                                header("location: signinPage.php?error=noconfirm");
                            }
                        }
                        else 
                        {
                            header("location: signinPage.php?error=nouser");
                        }
                    }
                }
            }
            else
            {
                header("location: signinPage.php?email=invalid");
            }
        }
    }
    else if(isset($_POST['google-login']))
    {
        // Include Configuration File
        include('../GoogleLogin/config.php');

        $login_button = '';

        // This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
        if(isset($_GET["code"]))
        {
            // It will Attempt to exchange a code for an valid authentication token.
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

            // This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
            if(!isset($token['error']))
            {
                // Set the access token used for requests
                $google_client->setAccessToken($token['access_token']);

                // Store "access_token" value in $_SESSION variable for future use.
                $_SESSION['access_token'] = $token['access_token'];

            }
        }

        //This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
        if(!isset($_SESSION['access_token']))
        {
            $login_button = $google_client->createAuthUrl();
            header("location:".$login_button);   
        }
    }
    else if(isset($_POST['facebook-login']))
    {
        //index.php

        include('../FacebookLogin/config.php');

        $facebook_output = '';

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
        
        }
        else
        {
            // Get login url
            $facebook_permissions = ['email']; // Optional permissions

            $facebook_login_url = $facebook_helper->getLoginUrl('http://localhost/Shinn-Kya-Mal---Final-master/FacebookLogin/index.php', $facebook_permissions);
            
            header("location:".$facebook_login_url);
        }
    }
?>