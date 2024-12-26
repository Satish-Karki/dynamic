<?php 
session_start();

include "databaseconn.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="contactform">
        <h2>Contact Us</h2>
        <form action="contact.php" method="POST"  name="frm1"  onsubmit="return submitform()">
            <label>Full name: </label>
            <input type="text" placeholder="Fullname" name="fname" id="name" value=""></br>
            <label>E-mail: </label>
            <input type="email" placeholder="E-mail" name="email" id="email" value="" ></br>
            <label>Your Message: </label>
            <textarea rows="15" cols="30" placeholder="Type your message here" name="feedback" value="" id="msg"></textarea></br>
            <input type="submit"  name="submit"  id="button">
        </form>
    </div>
<script>
    function submitform()
        {
            if (document.frm1.fname.value==="")
            {
                alert("Please Enter your name first ");
                document.frm1.fname.focus();
                return false;
            }
            else if (document.frm1.email.value==="")
            {
                alert("Please Enter your email ");
                document.frm1.email.focus();
                return false;
            }
        }
</script>
    </body>
    </html>