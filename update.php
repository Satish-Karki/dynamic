<?php 
session_start();
include "databaseconn.php";
if(isset($_POST['submit'])) {
  
    $id=$_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['options'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock=$_POST['stock'];
    $capacity=$_POST['capacity'].'L';

    $sql = "UPDATE products SET Name='$name', Category='$category', Capacity='$capacity',Description='$description',Price='$price',Stock='$stock' WHERE ProductID=$id";
    $res = mysqli_query($conn, $sql);
    if($res) $_SESSION['msg'] = "Data updated successfully.";
    else $_SESSION['msg'] = "Oops! Data updation failed.";
}
header("location: ./lists.php");