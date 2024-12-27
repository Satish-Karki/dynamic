<?php
    session_start();
    if(!isset($_GET['id']))
    {
        header("location:home.php");
    }
    $id=$_GET['id'];
    $customerid=$_SESSION['user_login'];

    include "databaseconn.php";

    $sql="DELETE FROM wishlists WHERE WishlistID=$id";
    $res=mysqli_query($conn,$sql);

    if($res){
        $message='Removed from Wishlist';
        header("location:wishlist.php?message=$message");
    }
    else{
        $message='Failed to remove';
        header("location:wishlist.php?message=$message");
    }