<?php
session_start();
if (!isset($_SESSION['user_login'])) {
    header("location:login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Invalid product ID.");
}

$id = $_SESSION['user_login'];
$productid = intval($_GET['id']); 

include "databaseconn.php";


$stmt = $conn->prepare("INSERT INTO carts (CustomerID, ProductID, Quantity) VALUES (?, ?, 1)");
$stmt->bind_param("ii", $id, $productid);

if ($stmt->execute()) {
   $_SESSION['msg']= "Added to cart successfully.";
   header("location:shop.php");
} else {
    $_SESSION['msg']= "Added to cart successfully." . $stmt->error;
}

$stmt->close();
$conn->close();
