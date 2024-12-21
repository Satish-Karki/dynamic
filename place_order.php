<?php
session_start();

if (isset($_POST['submit'])) {

    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $customerID = $_SESSION['user_login']; 
    include "databaseconn.php";


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

    $insertOrderDetailsSql = "
        INSERT INTO orderdetails (VendorID, ProductName, Location, Quantity, Amount) 
        VALUES (?, ?, ?, ?, ?)
    ";
    $insertOrderDetailsStmt = $conn->prepare($insertOrderDetailsSql);


    $insertOrdersSql = "
        INSERT INTO orders (CustomerID, VendorID, ProductName, Quantity, TotalAmount) 
        VALUES (?, ?, ?, ?, ?)
    ";
    $insertOrdersStmt = $conn->prepare($insertOrdersSql);

 
    while ($row = $result->fetch_assoc()) {
        $vendorID = $row['VendorID'];
        $productName = $row['ProductName'];
        $quantity = $row['Quantity'];
        $amount = $row['Amount']; 

      
        $insertOrderDetailsStmt->bind_param(
            "issidiss", 
            $vendorID, $productName, $address, $quantity, $amount
        );
        $insertOrderDetailsStmt->execute();

        $insertOrdersStmt->bind_param(
            "iisid", 
            $customerID, $vendorID, $productName, $quantity, $amount
        );
        $insertOrdersStmt->execute();
    }


    $insertOrderDetailsStmt->close();
    $insertOrdersStmt->close();
    $stmt->close();

 
    $clearCartSql = "DELETE FROM carts WHERE CustomerID = ?";
    $clearCartStmt = $conn->prepare($clearCartSql);
    $clearCartStmt->bind_param("i", $customerID);
    $clearCartStmt->execute();
    $clearCartStmt->close();

    $conn->close();


    header("Location: thankyou.php");
    exit();
}
?>
