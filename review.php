<?php
session_start();
include 'databaseconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id = $_SESSION['user_login'];
    $text = mysqli_real_escape_string($conn, $_POST['reviewtext']);
    $pid = mysqli_real_escape_string($conn, $_POST['productid']);
    $sql = "INSERT INTO reviews (ProductID, CustomerID, ReviewText) VALUES ('$pid', '$id', '$text')";
    $res = mysqli_query($conn, $sql);
    if ($res) {
       
        header("location:productdetails.php?id=$pid");
        exit();
} else {
    $message = urlencode("Failed to add review: " );
    header("location:shop.php?id=$productid&message=$message");
    exit();
}
}