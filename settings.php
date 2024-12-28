<?php
session_start();
$user = $_SESSION['user_login']; 
if (!isset($_SESSION['user_login'])) {
    header("location:login.php");
    exit;
}
$user_type = $_SESSION['user_type']; 
if($user_type!='Vendor')
{
    header("location:settingsc.php");
}
include "databaseconn.php";

$sql = "SELECT Name, PhoneNumber, Email, Address FROM users WHERE UserID = $user";
$res = mysqli_query($conn, $sql);

if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="settings.css">
    <link rel="stylesheet" href="dashboarde.css">
</head>
<body>
    <?php include "navbar.php";?>

    <div class="profile">

    <div class="options">
            <h2>DashStack</h2>
            <a href="dashboard.php" ><img src="images/ndashboard.png"> Dashboard</a>
            <a href="products.php"><img src="images/projects.png"> Products</a>
            <a href="productstock.php"><img src="images/projects.png">Product Stock</a>
            <a href="inbox.php"><img src="images/inbox.png">Inbox</a>
            <a href="lists.php"><img src="images/projects.png"> Lists</a>
            <div class="options-down">
                <a href="settings.php"  id="dash">Settings</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    <div class="user-info">
        <h2>Your Profile</h2>
        <div class="info-item">
            <label >Name:</label>
            <span class="value"><?php echo htmlspecialchars($row['Name']); ?></span>
        </div>
        <div class="info-item">
            <label class="label">Phone:</label>
            <span class="value"><?php echo htmlspecialchars($row['PhoneNumber']); ?></span>
        </div>
        <div class="info-item">
            <label class="label">Email:</label>
            <span class="value"><?php echo htmlspecialchars($row['Email']); ?></span>
        </div>
        <div class="info-item">
            <label class="label">Address:</label>
            <span class="value"><?php echo htmlspecialchars($row['Address']); ?></span>
        </div>
        <button class="modify-btn" onclick="location.href='modify_user.php';">Modify Information</button>
    </div>
</div>

</body>
</html>
<?php
} else {
    echo "<p style='color: #fff; text-align: center;'>No user information found.</p>";
}
?>
