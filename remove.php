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

    header("location:cart.php");