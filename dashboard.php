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

        $current_month = date('Y-m');
        $previous_month = date('Y-m', strtotime('-1 month'));

       

      
        $sql_users_current = "SELECT COUNT(DISTINCT CustomerID) AS total_users FROM orderdetails WHERE VendorID = $id AND DATE_FORMAT(DateTime, '%Y-%m') = '$current_month'";
        $sql_users_previous = "SELECT COUNT(DISTINCT CustomerID) AS total_users FROM orderdetails WHERE VendorID = $id AND DATE_FORMAT(DateTime, '%Y-%m') = '$previous_month'";
        
        $res_users_current = mysqli_query($conn, $sql_users_current);
        $res_users_previous = mysqli_query($conn, $sql_users_previous);
        
        $total_users_current = mysqli_fetch_assoc($res_users_current)['total_users'];
        $total_users_previous = mysqli_fetch_assoc($res_users_previous)['total_users'];
        
        if($total_users_current=='')
        {
            $total_users_current=0;
        }
        if($total_users_previous=='')
        {
            $total_users_previous=0;
        }
    

        $users_difference = $total_users_current - $total_users_previous;

      
        $sql_orders_current = "SELECT COUNT(*) AS total_orders FROM orderdetails WHERE VendorID = $id AND DATE_FORMAT(DateTime, '%Y-%m') = '$current_month'";
        $sql_orders_previous = "SELECT COUNT(*) AS total_orders FROM orderdetails WHERE VendorID = $id AND DATE_FORMAT(DateTime, '%Y-%m') = '$previous_month'";

        $res_orders_current = mysqli_query($conn, $sql_orders_current);
        $res_orders_previous = mysqli_query($conn, $sql_orders_previous);

        $total_orders_current = mysqli_fetch_assoc($res_orders_current)['total_orders'];
        $total_orders_previous = mysqli_fetch_assoc($res_orders_previous)['total_orders'];
        if($total_orders_current=='')
        {
            $total_orders_current=0;
        }
        if($total_orders_previous=='')
        {
            $total_orders_previous=0;
        }

        $orders_difference = $total_orders_current - $total_orders_previous;

       
        $sql_sales_current = "SELECT SUM(Amount) AS total_sales FROM orderdetails WHERE VendorID = $id AND Status = 'Delivered' AND DATE_FORMAT(DateTime, '%Y-%m') = '$current_month'";
        $sql_sales_previous = "SELECT SUM(Amount) AS total_sales FROM orderdetails WHERE VendorID = $id AND Status = 'Delivered' AND DATE_FORMAT(DateTime, '%Y-%m') = '$previous_month'";

        $res_sales_current = mysqli_query($conn, $sql_sales_current);
        $res_sales_previous = mysqli_query($conn, $sql_sales_previous);

        $total_sales_current = mysqli_fetch_assoc($res_sales_current)['total_sales'] ?? 0;
        $total_sales_previous = mysqli_fetch_assoc($res_sales_previous)['total_sales'] ?? 0;
        if($total_sales_current=='')
        {
            $total_sales_current=0;
        }
        if($total_sales_previous=='')
        {   
            $total_sales_previous=0;
        }

        $sales_difference = $total_sales_current - $total_sales_previous;

        $sql_pending_current = "SELECT COUNT(*) AS total_pending FROM orderdetails WHERE VendorID = $id AND Status = 'Pending' AND DATE_FORMAT(DateTime, '%Y-%m') = '$current_month'";
        $sql_pending_previous = "SELECT COUNT(*) AS total_pending FROM orderdetails WHERE VendorID = $id AND Status = 'Pending' AND DATE_FORMAT(DateTime, '%Y-%m') = '$previous_month'";

        $res_pending_current = mysqli_query($conn, $sql_pending_current);
        $res_pending_previous = mysqli_query($conn, $sql_pending_previous);

        $total_pending_current = mysqli_fetch_assoc($res_pending_current)['total_pending'];
        $total_pending_previous = mysqli_fetch_assoc($res_pending_previous)['total_pending'];
        if($total_pending_current=='')
        {
            $total_pending_current=0;
        }
        if($total_pending_previous=='')
        {
            $total_pending_previous=0;
        }

        $pending_difference = $total_pending_current - $total_pending_previous;


        ?>
    <div class="dashboard">
        <div class="options">
            <h2>DashStack</h2>
            <a href="dashboard.php" id="dash"><img src="images/ndashboard.png"> Dashboard</a>
            <a href="products.php"><img src="images/projects.png"> Products</a>
            <a href="productstock.php"><img src="images/projects.png">Product Stock</a>
            <a href="inbox.php"><img src="images/inbox.png">Inbox</a>
            <a href="lists.php"><img src="images/projects.png"> Lists</a>
            <div class="options-down">
                <a href="settings.php">Settings</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <div class="user-infos">
            <h2>Dashboard</h2>
                        
            <div class="cards">
        <div class="card">
            <div class="card-content">
                <p>Total Users</br></br>
                <b><?php echo htmlspecialchars($total_users_current); ?></b></p>
                <div class="stat">
                    <img src="images/<?php echo ($users_difference >= 0) ? 'up.png' : 'down.png'; ?>" alt="Stat Icon">
                    <span><?php echo abs($users_difference); ?> <?php echo ($users_difference >= 0) ? 'Up' : 'Down'; ?> from last month</span>
                </div>
            </div>
            <div class="icon">
                <img src="images/icon.png" alt="User Icon">
            </div>
        </div>

       
        <div class="card">
            <div class="card-content">
                <p>Total Orders</br></br>
                <b><?php echo htmlspecialchars($total_orders_current); ?></b></p>
                <div class="stat">
                    <img src="images/<?php echo ($orders_difference >= 0) ? 'up.png' : 'down.png'; ?>" alt="Stat Icon">
                    <span><?php echo abs($orders_difference); ?> <?php echo ($orders_difference >= 0) ? 'Up' : 'Down'; ?> from last month</span>
                </div>
            </div>
            <div class="icon">
                <img src="images/order.png" alt="Order Icon">
            </div>
        </div>

    
        <div class="card">
            <div class="card-content">
                <p>Total Sales</br></br>
                <b>Rs. <?php echo htmlspecialchars($total_sales_current); ?></b></p>
                <div class="stat">
                    <img src="images/<?php echo ($sales_difference >= 0) ? 'up.png' : 'down.png'; ?>" alt="Stat Icon">
                    <span>Rs. <?php echo abs($sales_difference); ?> <?php echo ($sales_difference >= 0) ? 'Up' : 'Down'; ?> from last month</span>
                </div>
            </div>
            <div class="icon">
                <img src="images/sales.png" alt="Sales Icon">
            </div>
        </div>

     
        <div class="card">
            <div class="card-content">
                <p>Total Orders Pending</br></br>
                <b><?php echo htmlspecialchars($total_pending_current); ?></b></p>
                <div class="stat">
                    <img src="images/<?php echo ($pending_difference >= 0) ? 'up.png' : 'down.png'; ?>" alt="Stat Icon">
                    <span><?php echo abs($pending_difference); ?> <?php echo ($pending_difference >= 0) ? 'Up' : 'Down'; ?> from last month</span>
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
                        <td  class="status-icon">
                            <?php 
                                if($row['Status'] == 'Delivered') { 
                                    echo '<img src="images/delivered.png">';
                                } else if($row['Status'] == 'Pending') { 
                                    echo '<img src="images/pending.png">';
                                } else if($row['Status'] == 'Shipping') { 
                                    echo '<img src="images/shipping.png">';
                                }else if($row['Status'] == 'Rejected') { 
                                    echo '<img src="images/rejected.png">';
                                }
                            ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <?php if ($row['Status'] == 'Pending'): ?>
                                    <a href="accept.php?id=<?php echo htmlspecialchars($row['OrderID']); ?>">
                                        <button class="accept-btn">Accept</button>
                                    </a>
                                    <a href="reject.php?id=<?php echo htmlspecialchars($row['OrderID']); ?>">
                                        <button class="reject-btn">Reject</button>
                                    </a>
                                <?php elseif ($row['Status'] == 'Shipping'): ?>
                                    <a href="confirm_delivery.php?id=<?php echo htmlspecialchars($row['OrderID']); ?>">
                                        <button class="confirm-btn">Confirm</button>
                                    </a>
                                <?php else: ?>
                                    <button class="disabled-btn">No Actions</button>
                                <?php endif; ?>
                            </div>
                        </td>

                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>

</body>
</html>

