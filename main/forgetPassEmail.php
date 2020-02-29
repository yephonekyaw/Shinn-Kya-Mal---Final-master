<?php
    include("cons/config.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '..\PHPMailer-master\src\Exception.php';
    require '..\PHPMailer-master\src\PHPMailer.php';
    require '..\PHPMailer-master\src\SMTP.php';
    
    $mail = new PHPMailer(TRUE);
    $code = rand(111111,999999);
    if(isset($_POST['forget-password-email-submit']))
    {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        if(empty($email))
        {
            header("location: forgetPassEmailPage.php?email=empty");
        }
        else
        {
            $sql = "SELECT * FROM userinfo WHERE user_email='$email' ";
            $result = mysqli_query($conn, $sql);

            if($row = mysqli_fetch_assoc($result))
            {
                $name = $row['user_name'];
                try 
                {
                    $mail->setFrom('moneymanager03@gmail.com', 'Money Manager');
                    $mail->addAddress($email, $row['user_name']); 
                    $mail->Subject = 'Money Manager - Password Reset';
                    $mail->isHTML(TRUE);
                    $mail->AddEmbeddedImage("Image/emailPiggy.png", "Piggy", "emailPiggy.png", "base64", "image/png");
                    $mail->Body = "
                            <html>
                                <head>
                                    <meta charset='UTF-8'>
                                    <meta name='viewport' content='width=device-width, initial-scale=1'>
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
                                        <p> Hello $name,We got a request to reset your Money Manager Account Password.</p>
                                        <p>Here is your code to reset your account
                                        <b>$code</b>
                                        </p>
                                        <br>
                                        <p><b> Do not forward this message or code to anyone even if they told you they are from MoneyManager</b></p>
                                        <hr>
                                        <p> If you ignore this message ,your password won't be changed</p>
                                        <div id='text'>
                                            <p><b>Money Manager</b></p>
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
                    $req = "UPDATE userinfo SET user_password='null', mail_confirmation=0, one_time_password='$code' WHERE user_email='$email' ";
                    mysqli_query($conn, $req);
                    header("location: forgetPassCode.php?email=$email");
                }                  
            }
            else
            {
                header("location: forgetPassEmailPage.php?error=nouser");
            }
        }
    }
?>