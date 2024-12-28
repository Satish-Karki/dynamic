<?php 
session_start();
include "databaseconn.php";

if (!isset($_SESSION['user_login'])) {
    header("location:login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("location:dashboard.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM orderdetails WHERE OrderID = $id";
$res = mysqli_query($conn, $sql);

if (!$res || mysqli_num_rows($res) === 0) {
    header("location:dashboard.php");
    exit();
}

$row = mysqli_fetch_assoc($res);
$productid = $row['ProductID'];
$quantity = $row['Quantity'];
$customerid=$row['CustomerID'];

$checkStockSql = "SELECT Stock FROM products WHERE ProductID = $productid";
$stockRes = mysqli_query($conn, $checkStockSql);

if (!$stockRes || mysqli_num_rows($stockRes) === 0) {
    header("location:dashboard.php");
    exit();
}

$stockRow = mysqli_fetch_assoc($stockRes);
$currentStock = $stockRow['Stock'];

if ($currentStock < $quantity) {
    header("location:dashboard.php?message='Not sufficient quantity!'");
    exit();
}

$updateStockSql = "UPDATE products SET Stock = Stock - $quantity WHERE ProductID = $productid";
mysqli_query($conn, $updateStockSql);

$updateOrderSql = "UPDATE orderdetails SET Status = 'Shipping' WHERE OrderID = $id";
mysqli_query($conn, $updateOrderSql);
$vendorid=$_SESSION['user_login'];

$inboxsql="INSERT into inbox (ProductID,CustomerID,VendorID,Messages) VALUES ('$productid','$customerid','$vendorid','Your Order for $productid has been accepted by the Vendor')";
$res=mysqli_query($conn,$inboxsql);

header("location:dashboard.php");
exit();
?>
