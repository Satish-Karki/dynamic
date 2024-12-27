<?php
session_start();

if (isset($_POST['submit'])) {
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $customerID = $_SESSION['user_login']; 
    $productID = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : null;

    include "databaseconn.php";

    if ($productID) {
        $sql = "SELECT VendorID, Name AS ProductName, Price FROM products WHERE ProductID = $productID";
        $result = mysqli_query($conn, $sql);
        $product = mysqli_fetch_assoc($result);

        $vendorID = $product['VendorID'];
        $productName = $product['ProductName'];
        $quantity = $quantity;
        $amount = $product['Price'];

        $insertOrderDetailsSql = "INSERT INTO orderdetails (VendorID, ProductName, Location, Quantity, Amount) 
                                  VALUES ('$vendorID', '$productName', '$address', $quantity, $amount)";
        mysqli_query($conn, $insertOrderDetailsSql);

        $insertOrdersSql = "INSERT INTO orders (CustomerID, VendorID, ProductName, Quantity, TotalAmount) 
                            VALUES ('$customerID', '$vendorID', '$productName', $quantity, $amount)";
        mysqli_query($conn, $insertOrdersSql);

        $updateStockSql = "UPDATE products SET Stock = Stock - $quantity WHERE ProductID = $productID";
        mysqli_query($conn, $updateStockSql);
    } else {
        $sql = "SELECT 
                    carts.ProductID, 
                    products.VendorID, 
                    products.Name AS ProductName, 
                    carts.Quantity, 
                    (carts.Quantity * products.Price) AS Amount
                FROM carts
                INNER JOIN products ON carts.ProductID = products.ProductID
                WHERE carts.CustomerID = $customerID";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $vendorID = $row['VendorID'];
            $productName = $row['ProductName'];
            $quantity = $row['Quantity'];
            $amount = $row['Amount'];

            $insertOrderDetailsSql = "INSERT INTO orderdetails (VendorID, ProductName, Location, Quantity, Amount) 
                                      VALUES ('$vendorID', '$productName', '$address', $quantity, $amount)";
            mysqli_query($conn, $insertOrderDetailsSql);

            $insertOrdersSql = "INSERT INTO orders (CustomerID, VendorID, ProductName, Quantity, TotalAmount) 
                                VALUES ('$customerID', '$vendorID', '$productName', $quantity, $amount)";
            mysqli_query($conn, $insertOrdersSql);

            $updateStockSql = "UPDATE products SET Stock = Stock - $quantity WHERE ProductID = " . $row['ProductID'];
            mysqli_query($conn, $updateStockSql);
        }

        $clearCartSql = "DELETE FROM carts WHERE CustomerID = $customerID";
        mysqli_query($conn, $clearCartSql);
    }

    mysqli_close($conn);

    header("Location: thankyou.php");
    exit();
}
?>
