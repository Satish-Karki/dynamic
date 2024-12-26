<?php 
    session_start();
    include "databaseconn.php";

    if(!isset($_POST['submit'])){
        header('location:home.php');
    }

    $id=$_SESSION['user_login'];
    $review=$_POST['reviewtext'];
    $pid=$_POST['productid'];
    $sql="INSERT into reviews (ProductID,CustomerID,ReviewText) VALUES('$pid','$id','$review')";
    $res=mysqli_query($conn,$sql);

    if ($res) {
       
        header("location:productdetails.php?id=$pid");
        exit();
} else {
    $message = urlencode("Failed to add review: " );
    header("location:shop.php?id=$productid&message=$message");
    exit();
}
