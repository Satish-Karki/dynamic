<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="global.css">
<body>
    <?php include "navbar.php";?>
    <section class="hero">
        <h1>Refrigerators</h1>
        <p>Our refrigerators redefine freshness and convenience, blending state-of-the-art cooling technology with stylish designs, energy efficiency, and spacious interiors to perfectly meet the needs of modern households.</p>
    </section>
    <section class="highlight">
        <div class="highlight-content">
            <h2>Keep Fresher, Cool, Faster Save More</h2>
            <p>Our Inverter Linear Compressor Keeps food at the peak of freshness with less energy consumed.</p>
            <button class="btn-buy-now" id="shop"> BUY NOW</button>
        </div>
    </section>
    <section class="product-category" id="product-category">
        <h2>Our Top Rated</h2>
        <p>Discover our latest arrivals<br> innovative refrigerators with advanced features,<br> elegant designs, and unmatched performance, crafted to elevate your kitchen experience.</p>
        <button class="btn-shop-all" id="shop"> Shop All</button>
        <div class="product-container">
            <div id="down" class="product-item" style="background-image: url('./pic/top door.jpg');">Top Freezer Refrigerator</div>
            <div class="product-item" style="background-image:url('./pic/door\ in\ door.jpg'); ">Door-in-Door</div>
            <div id="down" class="product-item" style="background-image:url('./pic/side\ by\ side.jpg'); ">Side by Side Refrigerator</div>
            <div class="product-item" style="background-image:url('./pic/instaview.jpg'); ">InstaView Door-in-Door</div>
        </div>
    </section>
    <script src="home.js"></script>
</body>
<?php include "footer.php";?>
</html>

