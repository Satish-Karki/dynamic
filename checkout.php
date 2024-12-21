<?php 
session_start();

if (!isset($_SESSION['user_login'])) {
    header("Location: login.php");
    exit();
}

include "databaseconn.php";

$productID = isset($_GET['id']) ? intval($_GET['id']) : null;
$product = null;

if ($productID) {
    $sql = "SELECT ProductID, Name, Price FROM products WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    $stmt->close();

   
    if (!$product) {
        header("Location: home.php");
        exit();
    }
}

if (!$productID) {
    header("Location: home.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="checkout-form">
            <h1>Checkout</h1>
            <form action="place_order.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($productID ?? ''); ?>">
                <div class="section">
                    <h2>Address & Payment</h2>
                    <label for="Name">Name</label>
                    <input type="text" id="Name" name="name" placeholder="Your Name" required>
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Address" required>
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" placeholder="City" required>
                    <label for="country">Country</label>
                    <select id="country" name="country" required>
                        <option value="usa">USA</option>
                        <option value="canada">Canada</option>
                        <option value="uk">United Kingdom</option>
                        <option value="nepal">Nepal</option>
                    </select>
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" placeholder="Zipcode" required>
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" placeholder="Phone Number" required>
                </div>
                <button type="submit" class="btn" name="submit" aria-label="Place your order">Place Order</button>
            </form>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
