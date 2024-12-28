<?php 
session_start();
include "navbar.php";
include "databaseconn.php";

if (!isset($_SESSION['user_login'])) {
    header("location:login.php");
    exit;
}

$customerID = $_SESSION['user_login']; 


$sql = "
    SELECT  
        wishlists.WishlistID,
        products.ProductID,
        products.Name AS ProductName, 
        products.Price AS UnitPrice,
        products.Category,
        products.image1
    FROM wishlists
    INNER JOIN products ON wishlists.ProductID = products.ProductID
    WHERE wishlists.CustomerID = $customerID
";

$result = mysqli_query($conn, $sql);
$wishlists = [];
while ($row = mysqli_fetch_assoc($result)) {
    $wishlists[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="wishlists.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Your Wishlists</h1>
        
        <?php if (!empty($wishlists)): ?>
            <div id="wishlist-items">
                <?php foreach ($wishlists as $row): ?>
                    <div class="wishlist-item">">
                    <img src="<?php echo htmlspecialchars($row['image1']); ?>">
                        <div class="wishlist-item-details">
                            <h2 class="wishlist-item-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                    
                            <p class="wishlist-item-category">Category: <?php echo htmlspecialchars($row['Category']); ?></p>
                            <a href="removewishlist.php?id=<?php echo $row['WishlistID']; ?>" class="wishlist-item-remove">Remove</a>
                        </div>
                <?php endforeach; ?>
            </div>
           
        <?php else: ?>
            <p>Your Wishlist is empty. </p>
        <?php endif; ?>

        <div class="bottomactions">
            <div class="actions">
            <a href="cart.php"><button class="button" id="continue-cart">Go to cart</button></a>
                <a href="clearwishlist.php"><button class="button" id="clear-wishlist">Clear Wishlist</button></a>
            </div>
        </div>
    </div>
    <script src="wishlist.js"></script>
</body>
</html>
