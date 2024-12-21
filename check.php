<?php
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    include "databaseconn.php";

    $sql = "SELECT UserId, Email, PasswordHash, UserType FROM users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
    
        if (password_verify($password, $row['PasswordHash'])) {
            $_SESSION['user_login'] = $row['UserId'];
            $_SESSION['error_msg'] = "";
            $_SESSION['user_type'] = $row['UserType'];

           header("location:home.php");
        } else {
            $_SESSION['error_msg'] = "Invalid email or password.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error_msg'] = "No user found with that email.";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
