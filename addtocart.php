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

$sql_check = "SELECT * FROM carts WHERE CustomerID = $id AND ProductID = $productid";
$res_check = mysqli_query($conn, $sql_check);
if (mysqli_num_rows($res_check) > 0) {
    
    $message = urlencode("This product is already in your cart.");
    if ($source === 'productdetails') {
        header("location:productdetails.php?id=$productid&message=$message");
        exit();
    } else {
        header("location:shop.php?scroll=$scroll&message=$message");
    }
} else {

$sql = "INSERT INTO carts (CustomerID, ProductID, Quantity) VALUES ($id, $productid, 1)";

$res=mysqli_query($conn,$sql);
if ($res) {
    $message = urlencode("Added to cart successfully.");
    if ($source === 'productdetails') {
        header("location:productdetails.php?id=$productid&message=$message");
        exit();
    } else {
        header("location:shop.php?scroll=$scroll&message=$message");
    }
} 
else {
    $message = urlencode("Failed to add to cart: " );
    header("location:shop.php?id=$productid&message=$message");
    exit();
}}

?>
