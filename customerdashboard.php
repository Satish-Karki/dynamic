<?php include "navbar.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="customerdashboard.css">
</head>

<body>
    <div class="contents">
        <div class="order-details">
            <h1>Orders: </h1>

            <div class="filter">
                <label for="filter-range">Filter By Date: </label>
                <select id="filter-range" onchange="applyFilter()">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="custom">Custom</option>
                </select>
                <input type="date" id="custom-start-date" class="custom-date" style="display:none;" placeholder="Start Date">
                <input type="date" id="custom-end-date" class="custom-date" style="display:none;" placeholder="End Date">
            </div>

            <div class="status">
                <div class="step completed">
                    <div class="icon"><i class="fas fa-check"></i></div>
                    <div>Order Confirmed</div>
                    <div>Wed, 21st Nov</div>
                </div>
                <div class="step completed">
                    <div class="icon"><i class="fas fa-shipping-fast"></i></div>
                    <div>Shipped</div>
                    <div>Wed, 21st Nov</div>
                </div>
                <div class="step">
                    <div class="icon"><i class="fas fa-box"></i></div>
                    <div>Delivered</div>
                    <div>Expected by, 26th Nov</div>
                </div>
            </div>

            <div class="order-items" id="order-items">
                <div class="item">
                    <div class="image">
                        <img src="https://via.placeholder.com/60" alt="Item Image">
                    </div>
                    <div class="description">
                        <div>Whirlpool Icemagic 185 Litres Single Door Refrigerator (200 IMPC Prm Sapphire Linnea)</div>
                        <div>Vendor: Cannon Appliance</div>
                    </div>
                    <div>Rs 30,000</div>
                </div>
                <div class="item">
                    <div class="image">
                        <img src="https://via.placeholder.com/60" alt="Item Image">
                    </div>
                    <div class="description">
                        <div>SAMSUNG RS72R5011SL - 700 Litres Inverter Side By Side Refrigerator With SpaceMax Technology</div>
                        <div>Vendor: Cannon Appliance</div>
                    </div>
                    <div>Rs 300,000</div>
                </div>
            </div>

            <p>Total Orders: <span id="total-orders">4</span></p>
            <p>Pending orders: <span id="pending-orders">2</span></p>

            <div class="transactions">
                <h2>Transactions History:</h2>
                <div id="transaction-history">
                    <p>22 DEC 2023 - Rs. 220,000</p>
                </div>
            </div>

            <div class="order-summary">
                <div class="column">
                    <h3>Payment</h3>
                    <div class="info">
                        <p>Visa **56</p>
                    </div>
                    <h3>Need Help</h3>
                    <div class="info">
                        <p>Order Issues</p>
                    </div>
                    <div class="info">
                        <p>Delivery Info</p>
                    </div>
                    <div class="info">
                        <p>Returns</p>
                    </div>
                </div>
                <div class="column">
                    <h3>Delivery</h3>
                    <div class="info">
                        <p>Address</p>
                        <p>Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
                <div class="column">
                    <h3>Order Summary</h3>
                    <div class="info">
                        <p>Discount</p>
                        <p>0</p>
                    </div>
                    <div class="info">
                        <p>Delivery</p>
                        <p>Rs 800</p>
                    </div>
                    <div class="info">
                        <p>Tax</p>
                        <p>Rs 5,000</p>
                    </div>
                    <div class="total">
                        <p>Total</p>
                        <p>Rs 5,800</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="customerdashboard.js"></script>
</body>
</html>
<?php include "footer.php" ?>