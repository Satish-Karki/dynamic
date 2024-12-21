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
    <?php 
    session_start();
    if(!isset($_POST['submit']))
    {
        header("location:login.php");
    }
    include "navbar.php";
    include "databaseconn.php";
   
    ?>

    <div class="container">
        <div class="checkout-form">
            <h1>Checkout</h1>
            <form action="place_order.php" method="POST" name="checkout">
                <div class="section">
                    <div class="sectionone">
                        <h2>Address & Payment</h2>
                    </div>
                    <label for="Name">Name</label>
                    <input type="text" id="Name" name="name" placeholder="Your Name" value="" required>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" placeholder="Address" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" placeholder="City" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select id="country" name="country" required>
                            <option value="usa">USA</option>
                            <option value="canada">Canada</option>
                            <option value="uk">United Kingdom</option>
                            <option value="nepal">Nepal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="zipcode">Zipcode</label>
                        <input type="text" id="zipcode" name="zipcode" placeholder="Zipcode" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" placeholder="Phone Number" value="" required>
                    </div>
                </div>
                <button type="submit" class="btn" name="submit">Place Order</button>
            </form>
        </div>
    </div>
</body>
<?php include "footer.php"; ?>
</html>