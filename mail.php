<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["send"])) {

  $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                              
    $mail->Host       = 'smtp.gmail.com';       
    $mail->SMTPAuth   = true;             
    $mail->Username   = 'prashanthsoori@gmail.com';   
    $mail->Password   = 'iwqc tjwh hnwt pyls';      
    $mail->SMTPSecure = 'ssl';            
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom( $_POST["email"], ''); 
    $mail->addAddress('prashanthsoori@gmail.com');     
    $mail->addReplyTo($_POST["email"], ''); 

    //Content
    $mail->Subject = "New message from contact page";
    $mail->Body    = "Name: " . $_POST['name'] . "\nEmail: " . $_POST['email'] . "\n\n" . $_POST['message']; 


    // Success sent message alert
    $mail->send();
    echo
    " 
    <script> 
     alert('Message was sent successfully!');
     document.location.href = 'index.php';
    </script>
    ";
}
?>