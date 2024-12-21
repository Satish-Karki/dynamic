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

    $sql_check = "SELECT * FROM users WHERE Email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $_SESSION['msg'] = "Email already exists!";
        header("location:signup.php");
        exit();
    }


    $hashPwd = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (UserType, Name, Email, PasswordHash) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $role, $uname, $email, $hashPwd);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Signed up successfully!";
        header("location:login.php");
    } else {
        $_SESSION['msg'] = "Couldn't sign up. Something went wrong.";
        header("location:signup.php");
    }
}
?>
