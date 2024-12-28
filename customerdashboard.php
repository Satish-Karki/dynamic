<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="customerdashboard.css">
    <link rel="stylesheet" href="global.css">
<body>
<?php 
        session_start();
        if($_SESSION['user_type']!="Customer"){
            header("location:login.php");
        }
        include "navbar.php";   
        include "databaseconn.php";

        $id = $_SESSION['user_login'];
    

    ?>

    <div class="contents">
    <div class="order-details">
    <h1>Orders: </h1>

    <div class="filter">
                <label for="filter-range">Filter By Date: </label>
                <select id="filter-range" onchange="applyFilter()">
                    <option value="all">All</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="custom">Custom</option>
                </select>
                <input type="date" id="custom-start-date" class="custom-date" style="display:none;" placeholder="Start Date">
                <input type="date" id="custom-end-date" class="custom-date" style="display:none;" placeholder="End Date">
            </div>


    <div class="order-items" id="order-items">
        <?php           
            $sql = "
            SELECT 
                orders.OrderID, 
                orders.CustomerID,
                orders.ProductName, 
                orders.Quantity, 
                orders.TotalAmount, 
                orders.OrderStatus,  
                orders.OrderedAt,
                users.Name AS VendorName,
                products.image1 AS image
            FROM orders
            INNER JOIN users ON orders.VendorID = users.UserID
            INNER JOIN products ON orders.ProductID = products.ProductID
            WHERE orders.CustomerID = $id
        ";
            $res=mysqli_query($conn,$sql);

            while($row=mysqli_fetch_assoc($res)):
        ?>
        <div class="item">
            <div class="image">
                <img src="<?php echo htmlspecialchars($row['image']);?>" alt="Item Image">
            </div>
            <div class="description">
                <div><?php echo htmlspecialchars($row['ProductName']);?></div>
                <div>Vendor: <?php echo htmlspecialchars($row['VendorName']);?></div>
            </div>
            <div class="description1">
            <div>Total: Rs. <?php echo htmlspecialchars($row['TotalAmount']);?></br></div>
               
                <div>Status: <?php echo htmlspecialchars($row['OrderStatus']);?></div>
            </div>
        </div>
        
        <?php endwhile; ?>
    </div>


            <div class="transactions">
                <h2>Transactions History:</h2>
                <div id="transaction-history">
                    <p>22 DEC 2023 - Rs. 220,000</p>
                </div>
            </div>

            <div class="order-summary">
                <div class="column">
                    <h3>Payment</h3>
                    <div class="info">
                        <p>Cash on Delivery</p>
                    </div>
                    <h3>Need Help</h3>
                    <div class="info">
                        <p>Order Issues</p>
                    </div>
                    <div class="info">
                        <p>Delivery Info</p>
                    </div>
                    <div class="info">
                        <p>Returns</p>
                    </div>
                </div>
                <div class="column">
                    <h3>Delivery</h3>
                    <div class="info">
                        <p>Address</p>
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
                <div class="column">
                    <h3>Order Summary</h3>
                    <div class="info">
                        <p>Discount</p>
                        <p>0</p>
                    </div>
                    <div class="info">
                        <p>Delivery</p>
                        <p>Rs 800</p>
                    </div>
                    <div class="info">
                        <p>Tax</p>
                        <p>Rs 5,000</p>
                    </div>
                    <div class="total">
                        <p>Total</p>
                        <p>Rs 5,800</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="customerdashboard.js"></script>
</body>
<?php include "footer.php" ?>
</html>