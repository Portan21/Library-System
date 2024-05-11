<?php
require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
require 'PHPMailer\src\PHPMailer.php';
require 'PHPMailer\src\SMTP.php';
require 'PHPMailer\src\Exception.php';

if(!empty($_SESSION["accountID"])){
    header("Location: catalogs.php");
}

if(empty($_SESSION["verifyemail"])){
    header("Location: login.php");
}
else{
    
    $mail = new PHPMailer(true);

    $verifyemail = $_SESSION["verifyemail"];

    $otp = rand(100000, 999999);
    $otp_string = "The Verification code for your SCRIBE account is: <h1><b>$otp</b></h1>";

    $insertquery = "UPDATE account_approval SET code = '$otp' WHERE email = '$verifyemail'";
    mysqli_query($conn,$insertquery);

    //dtldbwzroixdlthq
    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 465;
        $mail->Username   = 'adamson.scribe@gmail.com';                     //SMTP username
        $mail->Password   = 'awfktuoyqppofsgb';                               //SMTP password



        //Recipients
        $mail->setFrom('adamson.scribe@gmail.com', 'Adamson SCRIBE');
        $mail->addAddress($verifyemail);     //Add a recipient


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'SCRIBE Verification Code';
        $mail->Body    = $otp_string;


        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo "<script> alert('Message has been sent')</script>";
    } catch (Exception $e) {
        echo "<script> alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
    }

    
    $_SESSION["resend"] = true;
    header("Location: verification.php");
}
?>