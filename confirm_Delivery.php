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

$sql = "UPDATE orderdetails SET Status= 'Delivered' WHERE OrderID = $id";
$res = mysqli_query($conn, $sql);

if ($res) {
    header("location:dashboard.php?message='Updated Successfully!'");
    exit();
}

else {
    header("location:dashboard.php?message='Update Failed!'");
    exit();
}


header("location:dashboard.php");
exit();
?>
