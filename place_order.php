<?php
session_start();

if (isset($_POST['submit'])) {
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $customerID = $_SESSION['user_login']; 
    $productID = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;

    include "databaseconn.php";

    $insertOrderDetailsSql = "
        INSERT INTO orderdetails (VendorID, ProductName, Location, Quantity, Amount) 
        VALUES (?, ?, ?, ?, ?)
    ";
    $insertOrdersSql = "
        INSERT INTO orders (CustomerID, VendorID, ProductName, Quantity, TotalAmount) 
        VALUES (?, ?, ?, ?, ?)
    ";

    $insertOrderDetailsStmt = $conn->prepare($insertOrderDetailsSql);
    $insertOrdersStmt = $conn->prepare($insertOrdersSql);

    if ($productID) {
        $sql = "SELECT VendorID, Name AS ProductName, Price FROM products WHERE ProductID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $vendorID = $product['VendorID'];
        $productName = $product['ProductName'];
        $quantity = 1;
        $amount = $product['Price'];

        $insertOrderDetailsStmt->bind_param("issid", $vendorID, $productName, $address, $quantity, $amount);
        $insertOrderDetailsStmt->execute();

        $insertOrdersStmt->bind_param("iisid", $customerID, $vendorID, $productName, $quantity, $amount);
        $insertOrdersStmt->execute();
    } else {
        $sql = "
            SELECT 
                carts.ProductID, 
                products.VendorID, 
                products.Name AS ProductName, 
                carts.Quantity, 
                (carts.Quantity * products.Price) AS Amount
            FROM carts
            INNER JOIN products ON carts.ProductID = products.ProductID
            WHERE carts.CustomerID = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customerID);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $vendorID = $row['VendorID'];
            $productName = $row['ProductName'];
            $quantity = $row['Quantity'];
            $amount = $row['Amount'];

            $insertOrderDetailsStmt->bind_param("issid", $vendorID, $productName, $address, $quantity, $amount);
            $insertOrderDetailsStmt->execute();

            $insertOrdersStmt->bind_param("iisid", $customerID, $vendorID, $productName, $quantity, $amount);
            $insertOrdersStmt->execute();
        }

        $clearCartSql = "DELETE FROM carts WHERE CustomerID = ?";
        $clearCartStmt = $conn->prepare($clearCartSql);
        $clearCartStmt->bind_param("i", $customerID);
        $clearCartStmt->execute();
        $clearCartStmt->close();
    }

    $insertOrderDetailsStmt->close();
    $insertOrdersStmt->close();
    $conn->close();

    header("Location: thankyou.php");
    exit();
}
?>
