<?php session_start();
if(isset($_GET['id'])) {
$id = $_GET['id'];
$sql = "DELETE FROM products WHERE ProductID=$id";

include "databaseconn.php";
mysqli_query($conn, $sql);

$_SESSION['msg'] = "User with id: " . $id . " is deleted successfully.";
header("location: lists.php"); 
}
else{
    header("location:lists.php");
}