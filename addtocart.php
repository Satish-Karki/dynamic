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
$source = isset($_GET['source']) ? $_GET['source'] : '';
$scroll = isset($_GET['scroll']) ? intval($_GET['scroll']) : 0;

include "databaseconn.php";

$stmt = $conn->prepare("INSERT INTO carts (CustomerID, ProductID, Quantity) VALUES (?, ?, 1)");
$stmt->bind_param("ii", $id, $productid);

if ($stmt->execute()) {
    $_SESSION['msg'] = "Added to cart successfully.";

  
    if ($source === 'productdetails') {
        header("location:productdetails.php?id=$productid");
    } else {
        header("location:shop.php?scroll=$scroll");
    }
} else {
    $_SESSION['msg'] = "Failed to add to cart: " . $stmt->error;
    header("location:shop.php?scroll=$scroll"); 
}

$stmt->close();
$conn->close();
?>
