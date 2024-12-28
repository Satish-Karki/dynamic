<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="products.css">
    <link rel="stylesheet" href="dashboarde.css">
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    </head>
</html>
<body>
    <?php
        session_start();
        if (!isset($_SESSION['user_login']) || $_SESSION['user_type'] != 'Vendor') {
            header("location:login.php");
            exit(); 
        }
        
        include "navbar.php";?>
    <div class="all-container">
        <div class="options">
            <h2>DashStack</h2>
            <a href="dashboard.php" ><img src="images/ndashboard.png"> Dashboard</a>
            <a href="products.php" id="dash"><img src="images/projects.png"> Products</a>
            <a href="productstock.php"><img src="images/projects.png">Product Stock</a>
            <a href="inbox.php"><img src="images/inbox.png">Inbox</a>
            <a href="lists.php"><img src="images/projects.png"> Lists</a>
            <div class="options-down">
                <a href="settings.php">Settings</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="add-container">
           <form action="add.php" method="POST" id="add" name="form" enctype="multipart/form-data">
                <p>Product Information</p>
                <div class="productimgs">
                <label class="custom-file-upload">
                    <input type="file" name="image1" accept="image/* " onchange="previewImage(this, 0)">
                   
                    <img src="images/plus-icon.png" alt="Upload" id="preview-0">
                </label>
                <label class="custom-file-upload">
                    <input type="file" name="image2" accept="image/*" onchange="previewImage(this, 1)">
                    <img src="images/plus-icon.png" alt="Upload" id="preview-1">
                </label>
                <label class="custom-file-upload">
                    <input type="file" name="image3" accept="image/*" onchange="previewImage(this, 2)">
                    <img src="images/plus-icon.png" alt="Upload" id="preview-2">
                </label>
                <label class="custom-file-upload">
                    <input type="file" name="image4" accept="image/*" onchange="previewImage(this, 3)">
                    <img src="images/plus-icon.png" alt="Upload" id="preview-3">
                </label>
            </div>

                <label> Name </label>
                <input type="text"  id="name" name="name" value="" >
                <label> Description </label>
                <textarea name="description" id="description" rows="5" cols="50" placeholder="Enter description here" ></textarea>

                <div class="nitems">
                    <div class="low">
                        <label>   Price (in Rs.) </label>
                        <input type="text"  class="half" id="price" name="price" value="" >
                    </div>
                    <div class="low">
                        <label> Quantity </label>
                        <input type="text" class="half" id="quantity" name="stock" value="" >
                    </div>
                </div>
                <div class="nitems">
                    <div class="low">
                        <label>Category</label>
                        <select  name="options" >
                            <option value="Top Freeze Refrigerator">Top Freeze Refrigerator</option>
                            <option value="Door in Door">Door-in-Door</option>
                            <option value="Side by Side Refrigerator">Side by Side Refrigerator</option>
                            <option value="InstaView Door in Door">InstaView Door-in-Door</option>
                            <option value="One Door Fridge">Top Freeze Refrigerator</option>
                            <option value="Multi Door Refrigerator">Door-in-Door</option>
                            <option value="Double Door Refrigerator">Side by Side Refrigerator</option>
                            
                        </select>
                    </div>
                    <div class="low">
                        <label> Capacity (in litres)</label>
                        <input type="text" class="half" id="capacity" name="capacity" value="" >
                    </div>
                </div>
             
                <button input type="submit" name="submit" >Submit</button>
            </form>
        </div>
    </div>
    <script src="products.js"></script>
</body>
</html>
