<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="customerdashboard.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
<?php
session_start();
if ($_SESSION['user_type'] != "Customer") {
    header("location:login.php");
}
include "navbar.php";
include "databaseconn.php";

$id = $_SESSION['user_login'];

// Base SQL query
$sql = "
    SELECT 
        orderdetails.OrderID, 
        orderdetails.CustomerID,
        orderdetails.Quantity, 
        orderdetails.Amount, 
        orderdetails.Status,  
        orderdetails.DateTime,
        users.Name AS VendorName,
        products.image1 AS image,
        products.Name AS ProductName
    FROM orderdetails
    INNER JOIN users ON orderdetails.VendorID = users.UserID
    INNER JOIN products ON orderdetails.ProductID = products.ProductID
    WHERE orderdetails.CustomerID = $id
";

// Apply filters based on GET parameters
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    $start_date = $_GET['start_date'] ?? '';
    $end_date = $_GET['end_date'] ?? '';

    if ($filter == 'daily') {
        $sql .= " AND DATE(orderdetails.DateTime) = CURDATE()";
    } elseif ($filter == 'weekly') {
        $sql .= " AND YEARWEEK(orderdetails.DateTime, 1) = YEARWEEK(CURDATE(), 1)";
    } elseif ($filter == 'monthly') {
        $sql .= " AND MONTH(orderdetails.DateTime) = MONTH(CURDATE()) AND YEAR(orderdetails.DateTime) = YEAR(CURDATE())";
    } elseif ($filter == 'custom' && $start_date && $end_date) {
        $sql .= " AND DATE(orderdetails.DateTime) BETWEEN '$start_date' AND '$end_date'";
    }
}


$res = mysqli_query($conn, $sql);
?>

<div class="contents">
<div class="options">
            <h2>DashStack</h2>
            <a href="customerdashboard.php"  id="dash"><img src="images/ndashboard.png"> Orders</a>
            <a href="inboxc.php"><img src="images/inbox.png">Inbox</a>
       
            <div class="options-down">
                <a href="settingsc.php">Settings</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    <div class="order-details">
        <h1>Orders: </h1>
        <div class="filter">
            <form method="GET" action="customerdashboard.php" id="filter-form">
                <label for="filter-range">Filter By Date: </label>
                <select id="filter-range" name="filter" onchange="document.getElementById('filter-form').submit()">
                    <option value="all" <?= (isset($_GET['filter']) && $_GET['filter'] == 'all') ? 'selected' : '' ?>>All</option>
                    <option value="daily" <?= (isset($_GET['filter']) && $_GET['filter'] == 'daily') ? 'selected' : '' ?>>Daily</option>
                    <option value="weekly" <?= (isset($_GET['filter']) && $_GET['filter'] == 'weekly') ? 'selected' : '' ?>>Weekly</option>
                    <option value="monthly" <?= (isset($_GET['filter']) && $_GET['filter'] == 'monthly') ? 'selected' : '' ?>>Monthly</option>
                    <option value="custom" <?= (isset($_GET['filter']) && $_GET['filter'] == 'custom') ? 'selected' : '' ?>>Custom</option>
                </select>

                <!-- Custom Date Range Inputs -->
                <div id="custom-date-fields" style="display: <?= (isset($_GET['filter']) && $_GET['filter'] == 'custom') ? 'block' : 'none' ?>">
                    <input 
                        type="date" 
                        name="start_date" 
                        id="custom-start-date" 
                        value="<?= $_GET['start_date'] ?? '' ?>" 
                        onchange="document.getElementById('filter-form').submit()"
                    >
                    <input 
                        type="date" 
                        name="end_date" 
                        id="custom-end-date" 
                        value="<?= $_GET['end_date'] ?? '' ?>" 
                        onchange="document.getElementById('filter-form').submit()"
                    >
                </div>
            </form>
        </div>

        <div class="order-items" id="order-items">
            <?php while ($row = mysqli_fetch_assoc($res)): ?>
            <div class="item">
                <div class="image">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Item Image">
                </div>
                <div class="description">
                    <div><?php echo htmlspecialchars($row['ProductName']); ?></div>
                    <div>Vendor: <?php echo htmlspecialchars($row['VendorName']); ?></div>
                </div>
                <div class="description1">
                    <div>Total: Rs. <?php echo htmlspecialchars($row['Amount']); ?></div>
                    <div>Status: <?php echo htmlspecialchars($row['Status']); ?></div>
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

<script>
    // Show/Hide custom date fields
    document.getElementById('filter-range').addEventListener('change', function () {
        const customFields = document.getElementById('custom-date-fields');
        if (this.value === 'custom') {
            customFields.style.display = 'block';
        } else {
            customFields.style.display = 'none';
        }
    });
</script>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
<?php include "footer.php" ?>
</html>
