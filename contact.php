<?php
session_start();
include "databaseconn.php";

if (!isset($_POST['submit'])) {
    header("location:home.php");
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/SMTP.php';

$name = htmlspecialchars($_POST['fname'], ENT_QUOTES);
$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
$feedback = htmlspecialchars($_POST['feedback'], ENT_QUOTES);

try {
    $smail = new PHPMailer(true);
    
    $smail->isSMTP();
    $smail->Host = 'smtp.gmail.com';
    $smail->SMTPAuth = true;
    $smail->Username = 'satishkarki1000@gmail.com';
    $smail->Password = 'kybr zddx pggd wdlq'; 
    $smail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $smail->Port = 465;

  
    $smail->setFrom('satishkarki1000@gmail.com', 'Customer Support'); 
    $smail->addAddress('satishkarki1000@gmail.com'); 

   
    $smail->isHTML(true);
    $smail->Subject = 'Customer Feedback';
    $smail->Body = "<p><strong>From:</strong> $name ($email)</p>
                    <p><strong>Feedback:</strong><br>$feedback</p>";


    if ($smail->send()) {
        $_SESSION['message'] = 'Your feedback has been sent successfully.';
    } else {
        $_SESSION['message'] = 'Failed to send feedback. Please try again later.';
    }
} catch (Exception $e) {
    $_SESSION['message'] = 'Mailer Error: ' . $smail->ErrorInfo;
}

header("location:home.php");
exit;
?>
