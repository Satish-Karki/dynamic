<?php
    session_start();
    if(!isset($_GET['id']))
    {
        header("location:home.php");
    }
    $id=$_GET['id'];
    $customerid=$_SESSION['user_login'];

    include "databaseconn.php";

    $sql="DELETE FROM carts WHERE CartID=$id";
    $res=mysqli_query($conn,$sql);

    if($res){
        $message='Removed from Cart';
        header("location:cart.php?message=$message");
    }
    else{
        $message='Failed to remove';
        header("location:cart.php?message=$message");
    }