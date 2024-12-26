<?php
session_start();
include "databaseconn.php";

// Check if the form is submitted
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

    // Server settings
    $smail->isSMTP();
    $smail->Host = 'smtp.gmail.com';
    $smail->SMTPAuth = true;
    $smail->Username = 'satishkarki1000@gmail.com'; // Your Gmail address
    $smail->Password = 'kybr zddx pggd wdlq'; // Your Gmail App Password
    $smail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $smail->Port = 465;

    // Recipients
    $smail->setFrom('satishkarki1000@gmail.com', 'Customer Support'); // Your email as the sender
    $smail->addAddress('satishkarki1000@gmail.com'); // Your email to receive the feedback

    // Email content
    $smail->isHTML(true);
    $smail->Subject = 'Customer Feedback';
    $smail->Body = "<p><strong>From:</strong> $name ($email)</p>
                    <p><strong>Feedback:</strong><br>$feedback</p>";

    // Send the email
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
