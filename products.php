<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="products.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="footer.css">

    </head>
</html>
<body>
   <?php  
        if(!isset($_SESSION['user_login'])&&$_SESSION['usertype']!='Vendor'){
                    header("location:login.php");
                }
                include "navbar.php";?>
    <div class="all-container">
        <div class="options">
            <h2>DashStack</h2>
            <a href="dashboard.php" ><img src="images/dashboard.png"> Dashboard</a>
            <a href="products.php" id="dash"><img src="images/projects.png"> Products</a>
            <a href="#"><img src="images/projects.png">Product Stock</a>
            <a href="#"><img src="images/inbox.png">Inbox</a>
            <a href="lists.php"><img src="images/projects.png"> Lists</a>
            <div class="options-down">
                <a href="#">Settings</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="add-container">
           <form action="add.php" method="POST" name="form">
                <p>Product Information</p>
                <div class="productimgs">
                    <img src="./pic/top door.jpg">
                    <img src="./pic/top door.jpg">
                    <img src="./pic/top door.jpg">
                    <img src="./pic/top door.jpg">
                </div>
                <label> Name </label>
                <input type="text"  name="name" value="" requried>
                <label> Description </label>
                <input type="textarea" rowspan="30" columnspan="30" name="description" value="" requried>
                <div class="nitems">
                    <div class="low">
                        <label>   Price </label>
                        <input type="text"  id="half" name="price" value="" requried>
                    </div>
                    <div class="low">
                        <label> Quantity </label>
                        <input type="text" id="half" name="stock" value="" requried>
                    </div>
                </div>
                <div class="nitems">
                    <div class="low">
                        <label>Category</label>
                        <select  name="options" >
                            <option value="Top Freeze Refrigerator">Top Freeze Refrigerator</option>
                            <option value="Door-in-Door">Door-in-Door</option>
                            <option value="Side by Side Refrigerator">Side by Side Refrigerator</option>
                            <option value="InstaView Door-in-Door">InstaView Door-in-Door</option>
                        </select>
                    </div>
                    <div class="low">
                        <label> Capacity </label>
                        <input type="text" id="half" name="capacity" value="" requried>
                    </div>
                </div>
               
                <button input type="submit" name="submit" >Submit</button>
            </form>
        </div>
    </div>
</body>
    <?php include "footer.php";?>
</html>
