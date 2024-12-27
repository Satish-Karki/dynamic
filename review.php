<?php
session_start();
include 'databaseconn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id = $_SESSION['user_login'];
    $text = mysqli_real_escape_string($conn, $_POST['reviewtext']);
    $pid = $_POST['productid'];
    $rating = $_POST['rating'];

   
    $sql = "INSERT INTO reviews (ProductID, CustomerID, ReviewText, Rating) 
            VALUES ('$pid', '$id', '$text', '$rating')";
    $res = mysqli_query($conn, $sql);
    
 
    $sql = "SELECT Rating, TotalRatings FROM products WHERE ProductID = $pid";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentRating = $row['Rating'];
        $totalRatings = $row['TotalRatings'];
        
        
        $newTotalRatings = $totalRatings + 1;
        $newRating = (($currentRating * $totalRatings) + $rating) / $newTotalRatings;
   
        $sql = "UPDATE products SET Rating = '$newRating', TotalRatings = '$newTotalRatings' WHERE ProductID = $pid";
        $res = mysqli_query($conn, $sql);
        
        if ($res) {
            header("location: productdetails.php?id=$pid");
            exit();
        } else {
            $message = urlencode("Failed to update product rating");
            header("location: shop.php?id=$pid&message=$message");
            exit();
        }
    } else {
        $message = urlencode("Product not found or invalid data");
        header("location: shop.php?id=$pid&message=$message");
        exit();
    }
}
?>
