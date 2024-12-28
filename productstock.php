<?php   
    session_start();
    include "databaseconn.php";
    if (!isset($_SESSION['user_login']) || $_SESSION['user_type'] != 'Vendor') {
        header("location:login.php");
        exit(); 
    }
    
    $id=$_SESSION['user_login'];
    $sql = "SELECT * FROM products WHERE VendorID = $id AND Stock > 0";
    $res=mysqli_query($conn,$sql);
    ?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Stock</title>
    <link rel="stylesheet" href="lists.css">
    <link rel="stylesheet" href="dashboarde.css">
    
    <link rel="stylesheet" href="global.css">
    
</head>
<body>
    <?php include "navbar.php";?>
<div class="dashboard">
    <div class="options">
        <h2>DashStack</h2>
        <a href="dashboard.php" ><img src="images/ndashboard.png"> Dashboard</a>
        <a href="products.php"><img src="images/projects.png"> Products</a>
        <a href="productstock.php" id="dash"><img src="images/projects.png">Product Stock</a>
        <a href="inbox.php"><img src="images/inbox.png">Inbox</a>
        <a href="lists.php" ><img src="images/projects.png"> Lists</a>
        <div class="options-down">
            <a href="#">Settings</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="user-infos">
       <h2>Details</h2>
       <h3>Your Products:</h3>
    <table>
        <thead>
           
            <th>Name</th>
            <th>Category</th>
            <th>Quanity</th>
            <th>Price</th>
            <th>Rating</th>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($res)):?>
            <tr>
            <td><?php echo $row['Name'];?></td>
            <td><?php echo $row['Category'];?></td>
            <td><?php echo $row['Stock'];?></td>
            <td><?php echo $row['Price'];?></td>
            <td><?php echo $row['Stock'];?></td>
            <td>
                <div class="btn-container">
                    <a href="editproduct.php?id=<?php echo $row['ProductID']; ?>" class="btn btn--small">Edit</a>
                    <a href="delete.php?id=<?php echo $row['ProductID']; ?>" class="btn btn--danger btn--small">Delete</a>
                </div>
            </td>

            </tr>
            <?php 
                endwhile;
               ?>
        </tbody>
       </table>
    </div>
</div>
</body>
</html> 