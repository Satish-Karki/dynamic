<?php 
session_start();
include "databaseconn.php";
$customerID=$_SESSION['user_login'];
    $sql = "DELETE FROM carts WHERE CustomerID = $customerID";
    $res =mysqli_query($conn,$sql);
    
        
if ($res) {
    $message = urlencode("Removed from cart successfully.");
    header("location:cart.php?message=$message");
 
    
} else {
    $message = urlencode("Failed to remove from cart: " . $stmt->error);
    header("location:cart.php?message=$message");
}
