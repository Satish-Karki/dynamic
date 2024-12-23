<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link rel="stylesheet" href="shop.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
   <?php include "navbar.php"?>
    <div class="container">
        <div class="filters">
            <h2>Filters</h2>
            <button class="clear-filters" id="clear-filters">Clear filters</button>
            <div class="filter-category">
                <h3>Type</h3>
                <ul>
                    <li>
                        <input type="checkbox" id="TopFreezeRefrigerator" name="type" value="Top Freeze Refrigerator">
                        <label for="TopFreezeRefrigerator">Top Freeze Refrigerator</label>
                    </li>
                    <li>
                        <input type="checkbox" id="SideBySide" name="type" value="side-by-side">
                        <label for="SideBySide">Side by Side Refrigerator</label>
                    </li>
                    <li>
                        <input type="checkbox" id="OneDoor" name="type" value="one-door">
                        <label for="OneDoor">One Door Fridge</label>
                    </li>
                    <li>
                        <input type="checkbox" id="InstaView" name="type" value="instaview">
                        <label for="InstaView">InstaView™ Door-in-Door®</label>
                    </li>
                    <li>
                        <input type="checkbox" id="DoorInDoor" name="type" value="door-in-door">
                        <label for="DoorInDoor">Door-in-Door®</label>
                    </li>
                    <li>
                        <input type="checkbox" id="MultiDoor" name="type" value="multi-door">
                        <label for="MultiDoor">Multi Door Refrigerator</label>
                    </li>
                    <li>
                        <input type="checkbox" id="DoubleDoor" name="type" value="double-door">
                        <label for="DoubleDoor">Double Door Refrigerator</label>
                    </li>
                </ul>
            </div>

            <div class="filter-category">
                <h3>Features</h3>
                <ul>
                    <li>
                        <input type="checkbox" id="HygieneFresh" name="features" value="hygiene-fresh">
                        <label for="HygieneFresh">Hygiene Fresh</label>
                    </li>
                    <li>
                        <input type="checkbox" id="IceWater" name="features" value="ice-water">
                        <label for="IceWater">Ice & Water Dispenser</label>
                    </li>
                    <li>
                        <input type="checkbox" id="InstaViewDoor" name="features" value="instaview-door">
                        <label for="InstaViewDoor">InstaView™ Door-in-Door®</label>
                    </li>
                    <li>
                        <input type="checkbox" id="DoorCooling" name="features" value="door-cooling">
                        <label for="DoorCooling">Door Cooling+</label>
                    </li>
                    <li>
                        <input type="checkbox" id="SmartDiagnosis" name="features" value="smart-diagnosis">
                        <label for="SmartDiagnosis">Smart Diagnosis™</label>
                    </li>
                </ul>
            </div>

            <div class="filter-category">
                <h3>Smart Technology</h3>
                <ul>
                    <li>
                        <input type="checkbox" id="ThinQ" name="smart-tech" value="thinq">
                        <label for="ThinQ">ThinQ(Wi-Fi)</label>
                    </li>
                </ul>
            </div>

            <div class="filter-category">
                <h3>Capacity</h3>
                <ul>
                    <li>
                        <input type="checkbox" id="600LOrMore" name="capacity" value="600l-more">
                        <label for="600LOrMore">600L or more</label>
                    </li>
                    <li>
                        <input type="checkbox" id="400to600L" name="capacity" value="400-600">
                        <label for="400to600L">400-600L</label>
                    </li>
                </ul>
            </div>
        </div>

        <div class="product-grid">
            <?php 
            include "databaseconn.php"; 
            $sql = "SELECT ProductID, Name, Category, Features, Capacity, Price, VendorID FROM products";
            $res = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($res)):    
               ?>
            
                
                <div class="product-card" 
                    data-type="<?php echo htmlspecialchars($row['Category']); ?>" 
                    data-features="<?php echo htmlspecialchars($row['Features']); ?>" 
                    data-capacity="<?php echo htmlspecialchars($row['Capacity']); ?>-more">
                    
                    <a href="productdetails.php?id=<?php echo $row['ProductID']; ?>">
                        <img src="./pic/674l.jpg" alt="674L Side by Side Fridge">
                    </a>
                    <h3>
                        <a href="productdetails.php?id=<?php echo $row['ProductID']; ?>">
                            <?php echo htmlspecialchars($row['Name']); ?>
                        </a>
                    </h3>
                    <p>Price: $<?php echo htmlspecialchars($row['Price']); ?></p>
                    <a href="addtowishlist.php?id=<?php echo $row['ProductID']?>&source=shop" class="add-to" id="add-to-wishlist">Wishlist</a>
                    <a href="addtocart.php?id=<?php echo $row['ProductID']?>&source=shop" class="add-to" id="add-to-cart">Add to Cart</a>
                </div>
            <?php endwhile; ?>    
        </div>

    </div>
    <script src="shop.js"></script>
</body>
</html>
