<?php
session_start();
include "databaseconn.php";


$id =  $_GET['id'];
$sql = "SELECT * FROM products WHERE productid='$id'";
$res = mysqli_query($conn, $sql);

if (!$res || mysqli_num_rows($res) === 0) {
    header("Location: shop.php");
    exit();
}

$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="productdetails.css">
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <?php include "navbar.php"; ?>
    <main class="main-container">
        <div class="product">
            <div class="image-gallery">
                
                <div class="thumbnail selected"><img src="<?php echo htmlspecialchars($row['image1']); ?>"></div>
                <div class="thumbnail"><img src="<?php echo htmlspecialchars($row['image2']); ?>"></div>
                <div class="thumbnail"><img src="<?php echo htmlspecialchars($row['image3']); ?>"></div>
                <div class="thumbnail"><img src="<?php echo htmlspecialchars($row['image4']); ?>"></div>
            </div>
            <div class="main-image"><img src="<?php echo htmlspecialchars($row['image1']); ?>"></div>
            <div class="details">
                <p><strong>Availability:</strong> <?php echo htmlspecialchars($row['Stock']); ?> in stock</p>
                <h1><?php echo htmlspecialchars($row['Name']); ?></h1>
                <b>Rating: <?php echo htmlspecialchars($row['Rating']);?></b>
                <p><?php echo htmlspecialchars($row['Description']); ?></p>
      
                <p class="price">
                    <span class="current-price">Rs. <?php echo htmlspecialchars($row['Price']); ?></span>
                </p>
                <div class="actions">
                <form action="checkout.php" method="GET" class="buy-now-form">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['ProductID']); ?>">
                    <label>Quantity</label>
                    <input 
                        type="number" 
                        name="quantity" 
                        value="1" 
                        class="quantity" 
                        min="1" 
                        max="<?php echo htmlspecialchars($row['Stock']); ?>" 
                        required
                    >
                    <button type="submit" class="buy-now">Buy Now</button>
                </form>

                <a href="addtocart.php?id=<?php echo $row['ProductID']?>&source=productdetails" class="add-to" id="add-to-cart">
                    <button class="cart-btn">
                        <span class="cart-text">Add to Cart</span>
                        <img src="pic/anothercart.png" alt="Cart Icon" class="cart-icon">
                    </button>
                </a>
                <a href="addtowishlist.php?id=<?php echo $row['ProductID']?>&source=productdetails" class="add-to" id="add-to-wishlist">
                    <button class="wishlist-btn">
                        <span class="wishlist-text">Wishlist</span>
                        <img src="images/wishlist.png" alt="Wishlist Icon" class="wishlist-icon">
                    </button>
                </a>
            </div>

            </div>
        </div>
     
        <div class="tabs">
            <button class="tab active" data-tab="reviews"> <h2>Reviews</h2></button>
        </div>
        <div class="tab-content">
                
                <form action="review.php" method="POST" name="review-box" class="review-form">
                    <div class="review-box-container">
                      
                        <label>Rate this product:</label>
                        <div class="star-rating">
                           
                            <input type="radio" id="star5" name="rating" value="5" required>
                            <label for="star5" title="5 stars">&#9733;</label>

                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4" title="4 stars">&#9733;</label>

                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3" title="3 stars">&#9733;</label>

                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2" title="2 stars">&#9733;</label>

                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1" title="1 star">&#9733;</label>
                        </div>
                      
                    </div>
                    <textarea id="reviewText" name="reviewtext" rows="3" cols="40" placeholder="Write your review here..." ></textarea>
                    <div class="review-btn">
                    <button type="submit" class="btn" name="submit">Submit Review</button>
                    </div>
                    <input type="hidden" name="productid" value="<?php echo $id; ?>">
                </form>



                <button id="toggleReviewsBtn" class="btn">See Reviews</button>
 
                <div class="reviewList" id="reviewList" style="display: none;">
                    <?php
                    $sql = "SELECT reviews.*, users.Name
                            FROM reviews
                            INNER JOIN users ON reviews.CustomerID = users.UserID
                            WHERE reviews.ProductID = $id
                            ORDER BY reviews.ReviewedAt DESC";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='review'>
                                <div class='upper'>
                                    <span><strong>" . htmlspecialchars($row['Name']) . "</strong></span>
                                    <span class='review-stars'>";
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $row['Rating'] ? "&#9733;" : "&#9734;";
                                    }

                        echo "</span>
                                    <span class='review-date'>" . htmlspecialchars($row['ReviewedAt']) . "</span>
                                </div>
                                <div class='lower'>
                                    <p>" . nl2br(htmlspecialchars($row['ReviewText'])) . "</p>
                                </div>
                            </div>
                            <hr>";
                    }
                    ?>
                </div>

      
    </main>
    <script src="productdetails.js"></script>
    <?php include "footer.php"; ?>
</body>
</html>
