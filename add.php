<?php
session_start();

if (isset($_POST['submit'])) {
    include "databaseconn.php";

   
    if (!is_dir('productimgs')) {
        mkdir('productimgs', 0777, true);
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
                $message="Invalid file type for $fileName. Only JPG, JPEG, and PNG files are allowed.";
                header("location:products.php?message=$message");
                exit();
            }

            $uploadPath = 'productimgs/' . basename($fileName);

           
            if (move_uploaded_file($tempName, $uploadPath)) {
                $uploadedFiles[] = $uploadPath;
            } else {
                $message= "Faied to upload $fileName.";
                header("location:products.php?message=$message");
                exit();
            }
        } else {
            $uploadedFiles[] = null;
        }
    }

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = $_POST['options'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $capacity = $_POST['capacity'] . 'L';
    $id = $_SESSION['user_login'];

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

  
    $sql = "INSERT INTO products (VendorID, image1, image2, image3, image4, Name, Category, Capacity, Description, Price, Stock) 
            VALUES ('$id', '{$uploadedFiles[0]}', '{$uploadedFiles[1]}', '{$uploadedFiles[2]}', '{$uploadedFiles[3]}', 
                    '$name', '$category', '$capacity', '$description', '$price', '$stock')";

    if (mysqli_query($conn, $sql)) {
       $message = "Product added successfully!";
       header("location:products.php?message=$message");
    } else {
       $message = "Couldn't add product. Error: " . mysqli_error($conn);
       header("location:products.php?message=$message");
    }

    header("location:products.php");
    exit();
} else {
    header("location:products.php");
    exit();
}
?>
