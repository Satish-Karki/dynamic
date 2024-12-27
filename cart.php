<?php 
session_start();
include "navbar.php";
include "databaseconn.php";

if (!isset($_SESSION['user_login'])) {
    header("location:login.php");
    exit;
}

$customerID = intval($_SESSION['user_login']); 


$sql = "
    SELECT 
        carts.CartID, 
        carts.Quantity, 
        products.ProductID,
        products.Name AS ProductName,
        users.Name AS VendorName, 
        products.Price AS UnitPrice,
        products.Category,
        products.Stock,
        products.image1
    FROM carts
    INNER JOIN products ON carts.ProductID = products.ProductID
    INNER JOIN users ON products.VendorID = users.UserID
    WHERE carts.CustomerID = $customerID
";

$result = mysqli_query($conn, $sql);
$cartItems = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cartItems[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Your Cart</h1>
        <p class="subtitle">Not ready to checkout? <a href="shop.php" style="text-decoration: underline;">Continue Shopping</a></p>
        
        <?php if (!empty($cartItems)): ?>
            <div id="cart-items">
                <?php foreach ($cartItems as $row): ?>
                    <div class="cart-item" data-cart-id="<?php echo $row['CartID']; ?>" data-unit-price="<?php echo $row['UnitPrice']; ?>">
                    <img src="<?php echo htmlspecialchars($row['image1']); ?>">
                        <div class="cart-item-details">
                            <h2 class="cart-item-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                            <p class="cart-item-vendor">Vendor: <?php echo htmlspecialchars($row['VendorName']); ?></p>
                            <p class="cart-item-category">Category: <?php echo htmlspecialchars($row['Category']); ?></p>
                            <a href="remove.php?id=<?php echo $row['CartID']; ?>" class="cart-item-remove">Remove</a>
                        </div>
                        <div class="unit">
                        <div class="unit-pr">
                            <h3>Unit Price</h3>
                            <p class="cart-item-price">Rs.<?php echo number_format($row['UnitPrice'], 2); ?></p>
                        </div>
                        <div class="cart-item-quantity">
                            <h3>Quantity</h3>
                            
                            <div class="quantity-container">
                            <form method="POST" action="update_cart.php" class="cart-update-form">
                                        <input 
                                            type="hidden" 
                                            name="cartID" 
                                            value="<?php echo $row['CartID']; ?>"
                                        >
                                        <button class="quantity-button" data-action="decrease" type="submit" name="action" value="decrease">-</button>
                                        <input 
                                            type="number" 
                                            name="quantity" 
                                            value="<?php echo $row['Quantity']; ?>" 
                                            class="quantity-input" 
                                            min="1" 
                                            max="<?php echo htmlspecialchars($row['Stock']); ?>" 
                                        >
                                        <button class="quantity-button" data-action="increase" type="submit" name="action" value="increase">+</button>
                                    </form>
                            
                            </div>
                           
                        </div>
                        <div class="total-price">
                            <h3>Total Price</h3>
                            <p class="cart-item-total">Rs.<?php echo number_format($row['UnitPrice'] * $row['Quantity'], 2); ?></p>
                        </div>
                         </div>
                    </div>
                    
                <?php endforeach; ?>
            </div>
            <div class="grand-total">
                <h2>Total: Rs.<span id="grand-total">0.00</span></h2>
            </div>
        <?php else: ?>
            <p>Your cart is empty. <a href="shop.php">Start shopping now!</a></p>
        <?php endif; ?>

        <div class="bottomactions">
            <div class="actions">
              <a href="wishlist.php">  <button class="button" id="continue-shopping">Check Wishlist</button></a>
                <a href="clearcart.php"><button class="button" id="clear-cart">Clear Cart</button></a>
            </div>
            <div class="proceedcheckout">
                <?php if (!empty($cartItems)): ?>
                    <a href="checkout.php?from=cart"><button class="button primary">Proceed to Checkout</button></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="cart.js"></script>
</body>
</html>
