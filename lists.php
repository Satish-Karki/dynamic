<?php 
    session_start();
    if(isset($_SESSION['user_login']) && $_SESSION['user_type']=="Vendor")
    {

    $id=$_SESSION['user_login'];
    include "databaseconn.php"; 
    include "navbar.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project</title>
    <link rel="stylesheet" href="lists.css">
    <link rel="stylesheet" href="global.css">
    
</head>

<div class="dashboard">
    <div class="options">
        <h2>DashStack</h2>
        <a href="dashboard.php" ><img src="images/dashboard.png"> Dashboard</a>
        <a href="products.php"><img src="images/projects.png"> Products</a>
        <a href="#"><img src="images/projects.png">Product Stock</a>
        <a href="#"><img src="images/inbox.png">Inbox</a>
        <a href="lists.php" id="dash"><img src="images/projects.png"> Lists</a>
        <div class="options-down">
            <a href="#">Settings</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="user-infos">
       <h2>Details</h2>
       <h3>Your Products:</h3>
       <?php 
        $sql = "SELECT ProductID,Name, Category, Description, Price,Stock FROM products where VendorId='$id'";
        $res = mysqli_query($conn, $sql);?>
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
            <td><?php echo $row['Description'];?></td>
            <td><?php echo $row['Price'];?></td>
            <td><?php echo $row['Stock'];?></td>
            <td>
                 <a href="editproduct.php?id=<?php echo $row['ProductID']; ?>" class="btn btn--small" id="btn">Edit</a>
                 <a href="delete.php?id=<?php echo$row['ProductID']; ?>" class="btn btn--danger btn--small" id="btn">Delete</a>
            </td>
            </tr>
            <?php 
                endwhile;
                }
                else{
                    (header("location:login.php"));
                    }?>
        </tbody>
       </table>
    </div>
</div>
</body>
</html> 