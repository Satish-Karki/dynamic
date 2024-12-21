<?php
    session_start();
    if(isset($_POST['submit'])) {
    
    $name = $_POST['name'];
    $category = $_POST['options'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock=$_POST['stock'];
    $capacity=($_POST['capacity'].'L');
    
    $id=$_SESSION['user_login'];
    
    include "databaseconn.php";
    $sql="INSERT into products(VendorID,Name,Category,Capacity,Description,Price,Stock) VALUES('$id','$name','$category','$capacity','$description','$price','$stock')";
    $res = mysqli_query($conn, $sql);
    if($res){
        $_SESSION['msg'] = "Added Successfully!";
        header("location:./products.php");
        }

    else{$_SESSION['msg'] = "Couldn't add product. Something went wrong.";
        header("location:products.php");}
}

    else{
        header("location:products.php");
    }

?>