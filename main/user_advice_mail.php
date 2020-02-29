<?php
    include("cons/config.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '..\PHPMailer-master\src\Exception.php';
    require '..\PHPMailer-master\src\PHPMailer.php';
    require '..\PHPMailer-master\src\SMTP.php';

    $mail = new PHPMailer(TRUE);

    if(isset($_POST['send-message-submit']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        if(empty($name) || empty($email) || empty($message))
        {
            header("location: homePage.php?message=empty");
        }
        else 
        {
            if(preg_match("/^[a-zA-Z0-9._-]/", $name))
            {
                if(preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $email))
                {
                    try {
   
                        $mail->setFrom($email, $name);
                        $mail->addAddress('moneymanager03@gmail.com', 'Money Manager');
                        
                        $mail->Subject = 'User Advice Mail';
                        $mail->isHTML(TRUE);
                        $mail->Body = "
                                        <html>
                                        <head>
                                        <meta charset='UTF-8'>
                                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                                        <title>Document</title>
                                        </head>
                                        <body>
                                        <h1>User Advice Mail</h1>
                                        <p>$message</p>
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
                        header("location:homePage.php?send=success");
                    }
                }
                else
                {
                    header("location: homePage.php?email=invalid");
                }
            }
            else
            {
                header("location: homePage.php?name=invalid");
            }
        }
    }
?>