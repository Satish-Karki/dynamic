 <?php 
    session_start();
    include "databaseconn.php";
    $customerID=$_SESSION['user_login'];
        $clearCartSql = "DELETE FROM carts WHERE CustomerID = ?";
        $stmt = $conn->prepare($clearCartSql);
        $stmt->bind_param("i", $customerID);
        $stmt->execute();
       
    
        
if ($stmt->execute()) {
    $message = urlencode("Removed from cart successfully.");
    header("location:cart.php?message=$message");
 
    
} else {
    $message = urlencode("Failed to remove from cart: " . $stmt->error);
    header("location:cart.php?message=$message");
}
$stmt->close();
$conn->close();
