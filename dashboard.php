<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="dashboarde.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <?php session_start(); 
    if (!isset($_SESSION['user_login']) || $_SESSION['user_type'] != 'Vendor') {
        header("location:login.php");
        exit(); 
    }
    
        include "navbar.php";
        include "databaseconn.php";?>
    <div class="dashboard">
        <div class="options">
            <h2>DashStack</h2>
            <a href="dashboard.php" id="dash"><img src="images/dashboard.png"> Dashboard</a>
            <a href="products.php"><img src="images/projects.png"> Products</a>
            <a href="productstock.php"><img src="images/projects.png">Product Stock</a>
            <a href="#"><img src="images/inbox.png">Inbox</a>
            <a href="lists.php"><img src="images/projects.png"> Lists</a>
            <div class="options-down">
                <a href="#">Settings</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <div class="user-infos">
            <h2>Dashboard</h2>
            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <p>Total Users</br></br>
                    <b> 40,689</b></p>
                        <div class="stat">
                            <img src="images/up.png" alt="Upwards">
                            <span>8.5% Up from yesterday</span>
                        </div>
                    </div>
                    <div class="icon">
                        <img src="images/icon.png" alt="User Icon">
                    </div>
                </div>
            <div class="card">
                    <div class="card-content">
                        <p>Total Order</br></br>
                    <b> 40,689</b></p>
                        <div class="stat">
                            <img src="images/up.png" alt="Upwards">
                            <span>8.5% Up from yesterday</span>
                        </div>
                    </div>
                    <div class="icon">
                        <img src="images/order.png" alt="User Icon">
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <p>Total Sales</br></br>
                    <b> 40,689</b></p>
                        <div class="stat">
                            <img src="images/up.png" alt="Upwards">
                            <span>8.5% Up from yesterday</span>
                        </div>
                    </div>
                    <div class="icon">
                        <img src="images/sales.png" alt="User Icon">
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <p>Total Orders Pending</br></br>
                    <b> 40,689</b></p>
                        <div class="stat">
                            <img src="images/up.png" alt="Upwards">
                            <span>8.5% Up from yesterday</span>
                        </div>
                    </div>
                    <div class="icon">
                        <img src="images/orderpending.png" alt="User Icon">
                    </div>
                </div>
            </div>
    <div class="unknown">
    
    <?php 
        $id=$_SESSION['user_login'];
        $sql = "SELECT ProductName, Location, DateTime, Quantity,Amount,Status FROM orderdetails where VendorId='$id'";
        $res = mysqli_query($conn, $sql);?>
            <table>
            <b>Product Details</b>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Location</th>
                        <th>Date-Time</th>
                        <th>Piece</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = mysqli_fetch_assoc($res)): ?>
                    <tr>
                        <td><?php echo $row['ProductName']; ?></td>
                        <td><?php echo $row['Location']; ?></td>
                        <td><?php echo $row['DateTime']; ?></td>
                        <td><?php echo $row['Quantity']; ?></td>
                        <td><?php echo $row['Amount']; ?></td>
                        <td><?php if($row['Status']=='Delivered'){ ?> <img src="images/delivered.png"> <?php } else{  ?><img src="images/pending.png"><?php }?> </td>
                        <td><button>Accept</button><button>Reject</button></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>

</body>
</html>

