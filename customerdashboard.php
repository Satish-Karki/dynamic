<?php
session_start();
if ($_SESSION['user_type'] != "Customer") {
    header("location:login.php");
}

include "navbar.php";
include "databaseconn.php";

$id = $_SESSION['user_login'];

$sql_total_paid = "
    SELECT SUM(Amount) AS TotalPaid 
    FROM orderdetails 
    WHERE CustomerID = $id AND Status = 'Delivered'
";
$result_total_paid = mysqli_query($conn, $sql_total_paid);
$row_total_paid = mysqli_fetch_assoc($result_total_paid);
$total_paid = $row_total_paid['TotalPaid'] ?? 0;

$sql_address_payment = "
    SELECT Location
    FROM orderdetails 
    WHERE CustomerID = $id 
    LIMIT 1
";
$result_address_payment = mysqli_query($conn, $sql_address_payment);
$row_address_payment = mysqli_fetch_assoc($result_address_payment);
$address = $row_address_payment['Location'] ?? 'No address found';
$payment_type = 'Cash on delivery' ?? 'N/A';

$sql_order_summary = "
    SELECT SUM(Amount) AS PendingAmount 
    FROM orderdetails 
    WHERE CustomerID = $id AND Status IN ('Pending', 'Shipping')
";

$result_order_summary = mysqli_query($conn, $sql_order_summary);
$row_order_summary = mysqli_fetch_assoc($result_order_summary);
$pending_amount = $row_order_summary['PendingAmount'] ?? 0;
if($row_order_summary['PendingAmount']=='')
{
    $shipping_amount=0;
}
else{
    $shipping_amount=800;
}
$tax = round(($pending_amount + $shipping_amount) * 0.13, 2);
$total_amount = $pending_amount + $shipping_amount + $tax;

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="customerdashboard.css">
    <link rel="stylesheet" href="dashboarde.css">
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
<div class="contents">
    <div class="options">
        <h2>DashStack</h2>
        <a href="customerdashboard.php" id="dash"><img src="images/ndashboard.png"> Orders</a>
        <a href="inboxc.php"><img src="images/inbox.png">Inbox</a>
        <div class="options-down">
            <a href="settingsc.php">Settings</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="order-details">
        <h1>Orders:</h1>

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

        <div class="order-summary">
            <div class="column">
                <h3>Total Paid Amount</h3>
                <div class="info">
                    <p>Rs. <?php echo $total_paid; ?></p>
                </div>
                <h3>Need Help</h3>
                <div class="info">
                    <a href="support.php">Contact Support</a>
                </div>
            </div>
            <div class="column">
                <h3>Delivery</h3>
                <div class="info">
                    <p>Address</p>
                    <p><?php echo htmlspecialchars($address); ?></p>
                </div>
                <h3>Payment</h3>
                <div class="info">
                    <p><?php echo htmlspecialchars($payment_type); ?></p>
                </div>
            </div>
            <div class="column">
                <h3>Order Summary</h3>
                <div class="info">
                    <p>Pending Products</p>
                    <p>Rs. <?php echo $pending_amount; ?></p>
                </div>
                <div class="info">
                    <p>Shipping</p>
                    <p>Rs. <?php echo  $shipping_amount;?></p>
                </div>
                <div class="info">
                    <p>Tax</p>
                    <p>Rs. <?php echo $tax; ?></p>
                </div>
                <div class="total">
                    <p>Total Amount</p>
                    <p>Rs. <?php echo $total_amount; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
<?php include "footer.php"; ?>
</html>
