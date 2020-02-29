<?php 
    
    include("cons/config.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '..\PHPMailer-master\src\Exception.php';
    require '..\PHPMailer-master\src\PHPMailer.php';
    require '..\PHPMailer-master\src\SMTP.php';
    
    $mail = new PHPMailer(TRUE);
    $code = rand(111111, 999999);
    
    if(isset($_POST['submit']))
    {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $conf_password = mysqli_real_escape_string($conn, $_POST['conf_password']);
        $oauth_provider = "system";

        if(empty($name) || empty($email) || empty($password) || empty($conf_password))
        {
            header("location: signupPage.php?signupPage=empty");
        }
        else
        {
            if(preg_match("/^[a-zA-Z0-9._-]/", $name))
            {
                //filter_var($email, FILTER_VALIDATE_EMAIL)
                //preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$", $email)

                if(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $email))
                {
                    $sql = "SELECT * FROM userinfo WHERE user_email='$email'";
                    $result = mysqli_query($conn, $sql);
                    $resutlCheck = mysqli_num_rows($result);
    
                    if($resutlCheck > 0)
                    {
                        header("Location: signupPage.php?signupPage=usertaken");
                    }
                    else
                    {
                        if($password != $conf_password)
                        {
                            header("Location: signupPage.php?signupPage=invalidpassword");
                        }
                        else
                        {
                            //cretae token
                            $token = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()/';
                            $token = str_shuffle($token);
                            $token = substr($token,0,10);

                            //Hashing the password
                            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                            //Insert the user into the database
                                
                            $sql = "INSERT INTO userinfo (oauth_provider, user_name, user_email, user_password, token, created_date, mail_confirmation, one_time_password) VALUES ('$oauth_provider', '$name', '$email', '$hashedPwd', '$token', now(), 0, 0 )";
    
                            mysqli_query($conn, $sql);

                            try {
   
                                $mail->setFrom('moneymanager03@gmail.com', 'Money Manager');
                                $mail->addAddress($email, $name);
                                
                                $mail->Subject = 'Money Manager - Email Verification';
                                $mail->isHTML(TRUE);
                                $mail->AddEmbeddedImage("Image/emailPiggy.png", "Piggy", "emailPiggy.png", "base64", "image/png");
                                $mail->Body = "
                                      <html>
                                      <head>
                                         <meta charset='UTF-8'>
                                         <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                         <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                                         <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
                                         <link rel='stylesheet' href='emailStyle.css' type='text/css'>
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
                                            <p id='inline'> Welcome to Money Manager! Money Manager is the free website designed to give you the best money assistant in your Financial Plan. 
                                                           Please verify your email address <p  class='text-primary'>$email</p><p>Please sign up on Money Manager by using the code below<br>
                                            <b>$code</b><br>
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

                            if($mail->send())
                            {
                                $req = "UPDATE userinfo SET one_time_password='$code' WHERE user_email='$email' AND token='$token' ";
                                mysqli_query($conn, $req);
                                header("location: mail_verify.php?email='$email'");
                            }
                        }
                    }
                }
                else
                {
                    header("location: signupPage.php?signupPage=invalidemail");
                }
            }
            else
            {
                header("location: signupPage.php?signupPage=invalidname");
            }
        }
    }
?>