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

$stmt = $conn->prepare("INSERT INTO wishlists (CustomerID, ProductID) VALUES (?, ?)");
$stmt->bind_param("ii", $id, $productid);

if ($stmt->execute()) {
    $message = urlencode("Added to wishlist successfully.");
    if ($source === 'productdetails') {
        header("location:productdetails.php?id=$productid&message=$message");
    } else {
        header("location:shop.php?scroll=$scroll&message=$message");
    }
    
} else {
    $message = urlencode("Failed to add to wishlist: " . $stmt->error);
    header("location:shop.php?id=$productid&message=$message");
}


$stmt->close();
$conn->close();