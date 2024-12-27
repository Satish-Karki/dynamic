<?php 
session_start();
include "databaseconn.php";
$customerID=$_SESSION['user_login'];
    $sql = "DELETE FROM wishlists WHERE CustomerID = $customerID";
    $res =mysqli_query($conn,$sql);