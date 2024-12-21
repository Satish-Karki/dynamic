<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="productdetails.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <?php include "navbar.php";?>
    <?php include "databaseconn.php";
        $id=$_GET['id'];
        $sql= "SELECT * from products WHERE productid='$id'";
        $res=mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($res);
    ?>
    
    <main class="main-container">
        <div class="product">
            <div class="image-gallery">
                <div class="thumbnail selected"><img src="images/samsung700L.png"></div>
                <div class="thumbnail"><img src="images/thumbnail2.png"></div>
                <div class="thumbnail"><img src="images/thumbnail3.png"></div>
                <div class="thumbnail"><img src="images/thumbnail4.png"></div>
            </div>
            <div class="main-image"><img src="images/samsung700L.png"></div>
            <div class="details">
               
                <p><strong>Availability:</strong> <?php echo htmlspecialchars($row['Stock']); ?> in stock</p>
                <h1><?php echo htmlspecialchars($row['Name']); ?></h1>
                <ul class="features">
                    <li><?php echo htmlspecialchars($row['Features']); ?></li>
                    <li>DoorCooling+™</li>
                    <li>UltraSleek Door</li>
                    <li>Large Capacity</li>
                    <li>Smart Inverter Compressor™</li>
                </ul>
                <p class="price">
                    <span class="current-price"><?php echo htmlspecialchars($row['Price']); ?></span>
                </p>
                <div class="actions">
                    <input type="number" value="1" class="quantity">
                    <button class="buy-now">Buy Now</button>
                    <a href="addtocart.php?id=<?php echo$row['ProductID']; ?>" class="btn"> <button >Add to Cart</button></a>
                </div>
            </div>
        </div>
        <div class="tabs">
            <button class="tab active" data-tab="description">Description</button>
            <button class="tab" data-tab="specification">Specification</button>
            <button class="tab" data-tab="reviews">Reviews</button>
        </div>
        <div class="tab-content">
            <div class="tab-panel" id="description">
                <p><?php echo htmlspecialchars($row['Description']); ?></p>
            </div>
            <div class="tab-panel hidden" id="specification">
                <p>Specifications: <br> Energy Rating: 5 Star <br> Power Consumption: 200W <br> Cooling Technology: SpaceMax™</p>
            </div>
            <div class="tab-panel hidden" id="reviews">
                <p>Customer Reviews: <br> 1. Excellent product! - 5/5 <br> 2. Value for money - 4/5</p>
            </div>
        </div>
    </main>
    <?php include "footer.php"; ?>
</body>
</html>

