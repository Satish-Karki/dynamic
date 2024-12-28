<?php
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    include "databaseconn.php";

    $sql = "SELECT UserId, Email, PasswordHash, UserType FROM users WHERE Email = '$email'";
    $res = mysqli_query($conn,$sql);

    if ($res) {
       
        $row = mysqli_fetch_assoc($res);
    if ($row) {
    
        if (password_verify($password, $row['PasswordHash'])) {
            $_SESSION['user_login'] = $row['UserId'];
            $_SESSION['error_msg'] = "";
            $_SESSION['user_type'] = $row['UserType'];

           header("location:home.php");
        } else {
           $message = "Invalid email or password.";
            header("Location: login.php?message=$message");
            exit();
        }
    } else {
        $message = "No user found with that email.";
        header("Location: login.php?message=$message");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}}
else{
    header("location:login.php");
};
?>
