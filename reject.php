<?php 
    session_start();
    include "databaseconn.php";
    if(!isset($_SESSION['user_login']))
    {
        header("location:login.php");
    }
    if(!isset($_GET['id']))
    {
        header("location:dashboard.php");
    }
    $id=$_GET['id'];
    $sql="SELECT * FROM orderdetails where  OrderID=$id";
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res);
    $productid=$row['ProductID'];
    $customerid=$row['CustomerID'];
    $vendorid=$_SESSION['user_login'];
    $inboxsql="INSERT into inbox (ProductID,CustomerID,VendorID,Messages) VALUES ('$productid','$customerid','$vendorid','Your Order for $productid has been rejected by the Vendor')";
    $res=mysqli_query($conn,$inboxsql);

    $deletesql="DELETE FROM orderdetails where OrderID=$id";
    $res=mysqli_query($conn,$deletesql);

    header("location:dashboard.php");