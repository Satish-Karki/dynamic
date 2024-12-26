
<?php
session_start();

if (isset($_POST['submit'])) {
    include "databaseconn.php";

    // Ensure the `productimgs` directory exists
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
                $_SESSION['msg'] = "Invalid file type for $fileName. Only JPG, JPEG, and PNG files are allowed.";
                header("location:products.php");
                exit();
            }

            
            $uploadPath = 'productimgs/' . basename($fileName);

            // Move the uploaded file
            if (move_uploaded_file($tempName, $uploadPath)) {
                $uploadedFiles[] = $uploadPath; 
            } else {
                $_SESSION['msg'] = "Failed to upload $fileName.";
                header("location:products.php");
                exit();
            }
        } else {
            $uploadedFiles[] = null; 
        }
    }


    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = $_POST['options'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price=$_POST['price'];
    $stock = $_POST['stock'];
    $capacity = $_POST['capacity'] . 'L';
    $id = $_SESSION['user_login'];

    
    $sql = "INSERT INTO products (VendorID, image1, image2, image3, image4, Name, Category, Capacity, Description, Price, Stock) 
            VALUES ('$id', '{$uploadedFiles[0]}', '{$uploadedFiles[1]}', '{$uploadedFiles[2]}', '{$uploadedFiles[3]}', 
                    '$name', '$category', '$capacity', '$description', '$price', '$stock')";


    if (mysqli_query($conn, $sql)) {
        $_SESSION['msg'] = "Product added successfully!";
    } else {
        $_SESSION['msg'] = "Couldn't add product. Error: " . mysqli_error($conn);
    }


    header("location:products.php");
    exit();
} else {
   
    header("location:products.php");
    exit();
}
?>
