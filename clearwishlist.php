<?php 
session_start();
include "databaseconn.php";
$customerID=$_SESSION['user_login'];
    $sql = "DELETE FROM wishlists WHERE CustomerID = $customerID";
    $res =mysqli_query($conn,$sql);
    
if ($res) {
$message = urlencode("Removed from wishlists successfully.");
header("location:wishlist.php?message=$message");


} else {
$message = urlencode("Failed to remove from wishlists: ");
header("location:wishlist.php?message=$message");
}
