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
    $action = $_POST['action']; // either "increase" or "decrease"
    $customerID = intval($_SESSION['user_login']);

    
    if ($action == "increase") {
        $quantity++;
    } elseif ($action == "decrease" && $quantity > 1) {
        $quantity--;
    }

    // Get the maximum stock of the product
    $sql = "SELECT Stock FROM products WHERE ProductID = (SELECT ProductID FROM carts WHERE CartID = ? AND CustomerID = ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $cartID, $customerID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
    $maxStock = $product['Stock'];

    // Ensure quantity does not exceed stock
    if ($quantity > $maxStock) {
        $quantity = $maxStock;
    }

    // Update the cart quantity
    $sql = "UPDATE carts SET Quantity = ? WHERE CartID = ? AND CustomerID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $quantity, $cartID, $customerID);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: cart.php"); // Redirect back to the cart page
        exit;
    } else {
        echo "Failed to update cart.";
    }

    mysqli_stmt_close($stmt);
}
?>
