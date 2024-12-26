<?php 
    session_start();
    $user=$_SESSION['user_type'];

    if($user=="Vendor"){
        header("location:dashboard.php");
        exit();
    }
    else{
        header("location:customerdashboard.php");
    }