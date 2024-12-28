<?php
session_start();
include "databaseconn.php";

if (!isset($_SESSION['user_login'])) {
    header("location:login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartID = intval($_POST['cartID']);
    $quantity = intval($_POST['quantity']);
    $action = $_POST['action']; 
    $customerID = intval($_SESSION['user_login']);

    


    $sql = "SELECT Stock FROM products WHERE ProductID = (SELECT ProductID FROM carts WHERE CartID = '$cartID' AND CustomerID = $customerID)";
    $res = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($res);
    $maxStock = $product['Stock'];

    if ($quantity > $maxStock) {
        $quantity = $maxStock;
    }

  
    $sql = "UPDATE carts SET Quantity = '$quantity' WHERE CartID = '$cartID' AND CustomerID = '$customerID'";
    $res = mysqli_query($conn, $sql);
   
    if ($res) {
        header("Location: cart.php"); 
        exit;
    } else {
        echo "Failed to update cart.";
    }

}
?>
