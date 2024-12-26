<?php
session_start();
include "databaseconn.php";

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = $_POST['options'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $capacity = $_POST['capacity'] . 'L';

   
    if (!is_numeric($price) || $price <= 0) {
        $message = "Price must be a positive number.";
        header("location:products.php?message=$message");
        exit();
    }

    if (!ctype_digit($stock) || (int)$stock <= 0) {
        $message = "Stock must be a positive whole number.";
        header("location:products.php?message=$message");
        exit();
    }

  
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $uploadedFiles = [];

    for ($i = 1; $i <= 4; $i++) {
        $fileKey = "image$i";
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
            $fileName = $_FILES[$fileKey]['name'];
            $tempName = $_FILES[$fileKey]['tmp_name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedExtensions)) {
                $message = "Invalid file type for $fileName. Only JPG, JPEG, and PNG files are allowed.";
                header("location:products.php?message=$message");
                exit();
            }

         
            if (!is_dir('productimgs')) {
                mkdir('productimgs', 0777, true);
            }

            $uploadPath = 'productimgs/' . basename($fileName);

            if (move_uploaded_file($tempName, $uploadPath)) {
                $uploadedFiles[$fileKey] = $uploadPath;
            } else {
                $message = "Failed to upload $fileName.";
                header("location:products.php?message=$message");
                exit();
            }
        }
    }

    $sql = "UPDATE products SET Name='$name', Category='$category', Capacity='$capacity', Description='$description', Price='$price', Stock='$stock'";

    // Append image fields to the query if new images were uploaded
    foreach ($uploadedFiles as $key => $path) {
        $sql .= ", $key='$path'";
    }

    $sql .= " WHERE ProductID=$id";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        $message = "Product updated successfully!";
        
    } else {
        $message = "Couldn't update product. Error: " . mysqli_error($conn);
    }

    header("location:products.php?message=$message");
    exit();
} else {
    header("location:products.php");
    exit();
}
?>
