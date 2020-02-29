<?php

    include("../main/cons/config.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '..\PHPMailer-master\src\Exception.php';
    require '..\PHPMailer-master\src\PHPMailer.php';
    require '..\PHPMailer-master\src\SMTP.php';

    $mail = new PHPMailer(TRUE);
    $reminderIDs = array();
    $currentId = 0;

    // Put the IDs into the array
    $date = date('Y-m-d');
    $sql = "SELECT * FROM reminder_event WHERE reminder_date='$date' AND check_reminder=0 ";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($reminderIDs, $row['reminder_id']);
    }
    
    // Data count for form button
    $formDataCount = count($reminderIDs);

    if(isset($_POST['sendMail']))
    {
        // Fetch data count for form button 
        $sqlForm = "SELECT * FROM reminder_event WHERE reminder_date='$date' AND check_reminder=0 ";
        $resultForm = mysqli_query($conn, $sql);
        $rowForm = mysqli_fetch_assoc($resultForm);
        if($rowForm > 0)
        {
            $formDataCount = $formDataCount - 1;
        }

        // Sending each reminder to the user
        if($currentId < count($reminderIDs))
        {
            // Fetch the data with reminder IDs
            $rem_id = $reminderIDs[$currentId];
            $sqlFetch = "SELECT * FROM reminder_event WHERE reminder_id='$rem_id'";
            $resultFetch = mysqli_query($conn, $sqlFetch);
            $rowFetch = mysqli_fetch_assoc($resultFetch);
            if($rowFetch > 0)
            {
                $rem_user_id = $rowFetch['reminder_user_fk_id'];
                $rem_schedule_id = $rowFetch['reminder_schedule_fk_id'];
                $rem_desc = $rowFetch['reminder_description'];
                $rem_date = $rowFetch['reminder_date'];
                
                $rem_date = date('D, d M', strtotime($rem_date));


                // Fetch user email according to reminder id
                $sqlUserFetch = "SELECT * FROM userinfo WHERE user_id='$rem_user_id' ";
                $resultUserFetch = mysqli_query($conn, $sqlUserFetch);
                $rowUserFetch = mysqli_fetch_assoc($resultUserFetch);
                if($rowUserFetch > 0)
                {
                    $email = $rowUserFetch['user_email'];
                    $name = $rowUserFetch['user_name'];


                    try {

                        $mail->setFrom('moneymanager03@gmail.com', 'Money Manager');
                        $mail->addAddress($email, $name);
                        
                        $mail->Subject = "Money Manager - Reminder:$rem_desc";
                        $mail->isHTML(TRUE);
                        $mail->AddEmbeddedImage("../main/Image/emailPiggy.png", "Piggy", "emailPiggy.png", "base64", "image/png");
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
                                <title>Reminder</title>
                            </head>
                            <body>
                                <div id='outer'>         
                                <div class='inner'>
                                    <header class='text-center'>
                                        <img src='cid:Piggy' alt='' width=150 height=150>
                                    </header>
                                    <h1>Money Manager</h1>
                                    <p id='inline'>Hi $name,<br>
                                        You have an upcoming reminder:<br>
                                        <b>$rem_desc</b> - due on $rem_date <br>
                                        Please check your activity<br>
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

                        /* Clear Address */
                        // $mail->clearAllRecipients();
                        // $mail->clearAttachments();

                        

                    }
                    catch (Exception $e)
                    {
                        echo $e->errorMessage();
                    }  

                    if($mail->send())
                    {
                        $sqlUpdate = "UPDATE reminder_event SET check_reminder=1 WHERE reminder_id='$rem_id' ";
                        mysqli_query($conn, $sqlUpdate);
                        $currentId++;
                    }
                }
            }
        }
    }


?>

<html>
    <form action="" method="POST">
        <input type="submit" name="sendMail" value="<?php echo $formDataCount; ?> Mail To Send">
    </form>
</html>