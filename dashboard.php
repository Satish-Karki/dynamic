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
        include "databaseconn.php";
        $id=$_SESSION['user_login'];
                $sql_total_orders = "SELECT COUNT(*) AS total_orders FROM orderdetails WHERE VendorID = $id";
        $res_total_orders = mysqli_query($conn, $sql_total_orders);
        $total_orders = mysqli_fetch_assoc($res_total_orders)['total_orders'];

      
        $sql_total_users = "SELECT COUNT(DISTINCT CustomerID) AS total_users FROM orderdetails WHERE VendorID = $id";
        $res_total_users = mysqli_query($conn, $sql_total_users);
        $total_users = mysqli_fetch_assoc($res_total_users)['total_users'];

        $sql_total_sales = "SELECT SUM(Amount) AS total_sales FROM orderdetails WHERE VendorID = $id AND Status = 'Delivered'";
        $res_total_sales = mysqli_query($conn, $sql_total_sales);
        $total_sales = mysqli_fetch_assoc($res_total_sales)['total_sales'];

     
        $sql_total_pending = "SELECT COUNT(*) AS total_pending FROM orderdetails WHERE VendorID = $id AND Status = 'Pending'";
        $res_total_pending = mysqli_query($conn, $sql_total_pending);
        $total_pending = mysqli_fetch_assoc($res_total_pending)['total_pending'];
        ?>
    <div class="dashboard">
        <div class="options">
            <h2>DashStack</h2>
            <a href="dashboard.php" id="dash"><img src="images/dashboard.png"> Dashboard</a>
            <a href="products.php"><img src="images/projects.png"> Products</a>
            <a href="productstock.php"><img src="images/projects.png">Product Stock</a>
            <a href="inbox.php"><img src="images/inbox.png">Inbox</a>
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
                            <b><?php echo htmlspecialchars($total_users); ?></b></p>
                            <div class="stat">
                                <img src="images/up.png" alt="Upwards">
                                <span>Unique customers who ordered</span>
                            </div>
                        </div>
                        <div class="icon">
                            <img src="images/icon.png" alt="User Icon">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <p>Total Orders</br></br>
                            <b><?php echo htmlspecialchars($total_orders); ?></b></p>
                            <div class="stat">
                                <img src="images/up.png" alt="Upwards">
                                <span>Total orders from your products</span>
                            </div>
                        </div>
                        <div class="icon">
                            <img src="images/order.png" alt="Order Icon">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <p>Total Sales</br></br>
                            <b>Rs. <?php echo htmlspecialchars($total_sales); ?></b></p>
                            <div class="stat">
                                <img src="images/up.png" alt="Upwards">
                                <span>Sales from delivered orders</span>
                            </div>
                        </div>
                        <div class="icon">
                            <img src="images/sales.png" alt="Sales Icon">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <p>Total Orders Pending</br></br>
                            <b><?php echo htmlspecialchars($total_pending); ?></b></p>
                            <div class="stat">
                                <img src="images/up.png" alt="Upwards">
                                <span>Orders waiting for processing</span>
                            </div>
                        </div>
                        <div class="icon">
                            <img src="images/orderpending.png" alt="Order Pending Icon">
                        </div>
                    </div>
                </div>
         
    <div class="unknown">
    
    <?php 
      
        $sql = "SELECT OrderID,ProductName, Location, DateTime, Quantity,Amount,Status FROM orderdetails where VendorId='$id'";
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
                        <td><a href="accept.php?id=<?php echo(htmlspecialchars($row['OrderID']))?>"><button>Accept</button></a><a href="reject.php?id=<?php echo(htmlspecialchars($row['OrderID']))?>"><button>Reject</button></a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>

</body>
</html>

