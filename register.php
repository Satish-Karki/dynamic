<?php
session_start();

if (isset($_POST['submit'])) {
    include_once "databaseconn.php";

    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpwd = $_POST['cpwd'];
    $role = $_POST['options'];

    if ($password != $cpwd) {
        $_SESSION['msg'] = "Passwords do not match!";
        header("location:signup.php");
        exit();
    }

    $sql = "SELECT * FROM users WHERE Email = '$email'";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $message = "Email already exists!!";
        header("Location: signup.php?message=" . urlencode($message));
        exit();
    } else {
        $hashPwd = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (UserType, Name, Email, PasswordHash) VALUES ('$role', '$uname', '$email', '$hashPwd')";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $message = "Signed up successfully!";
            header("location:login.php?message=$message");
        } else {
            $message = "Couldn't sign up. Something went wrong.";
            header("location:signup.php?message=$message");
        }
    }
} else {
    header("location:signup.php");
}
?>
