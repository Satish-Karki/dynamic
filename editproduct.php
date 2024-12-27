<?php session_start();
    if(isset($_SESSION['user_login']) && $_SESSION['user_type']=="Vendor")
    {
        include "navbar.php";
        include "databaseconn.php";
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT Name,Category,Capacity,Description,Price,Stock FROM products WHERE ProductID=$id";
            $res = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($res)): 
                $name = isset($row['Name']) ? $row['Name'] : '';
                $category = isset($row['Category']) ? $row['Category'] : '';
                $description = isset($row['Description']) ? $row['Description'] : '';
                $price = isset($row['Price']) ? $row['Price'] : '';
                $quantity = isset($row['Stock']) ? $row['Stock'] : '';
                $capacity = isset($row['Capacity']) ? $row['Capacity'] : '';
            ?>
              
<html>
    <head>
    <meta charset="UTF-8">
    <title>Canon</title>
    <link rel="stylesheet" href="products.css">
    </head>
</html>
<body>

    <div class="all-container">
        <div class="options">
            <h2>DashStack</h2>
            <a href="dashboard.php" ><img src="images/ndashboard.png"> Dashboard</a>
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
           <form action="update.php" method="POST" name="form" enctype="multipart/form-data">
                <p>Edit Product Information</p>
                <div class="productimgs">
                <label class="custom-file-upload">
                    <input type="file" name="image1" accept="image/*">
                    <span>+</span>
                </label>
                <label class="custom-file-upload">
                    <input type="file" name="image2" accept="image/*">
                    <span>+</span>
                </label>
                <label class="custom-file-upload">
                    <input type="file" name="image3" accept="image/*">
                    <span>+</span>
                </label>
                <label class="custom-file-upload">
                    <input type="file" name="image4" accept="image/*">
                    <span>+</span>
                </label>
            </div>
                <input type="hidden" value=<?php echo $id?> name="id">
                <label> Name </label>
                <input type="text"  name="name" value="<?php echo $name; ?>" >
                <label> Description </label>
                <input type="textarea" rowspan="30" columnspan="30" name="description" value="<?php echo $description; ?>" >
                <div class="nitems">
                    <div class="low">
                        <label for="Price">   Price </label>
                        <input type="text"  id="half" name="price" value="<?php echo $price; ?>">
                    
                    </div>
                    <div class="low">
                        <label> Quantity </label>
                        <input type="text" id="half" name="stock" value="<?php echo $quantity; ?>" >
                    </div>
                </div>
                
                    <div class="nitems">
                    <div class="low">
                    <label>Category</label>
                <select name="options" >
                    <option value="Top Freeze Refrigerator" <?php if ($category == "Top Freeze Refrigerator") echo "t"; ?>>
                        Top Freeze Refrigerator
                    </option>
                    <option value="Door-in-Door" <?php if ($category == "Door-in-Door") echo "selected"; ?>>
                        Door-in-Door
                    </option>
                    <option value="Side by Side Refrigerator" <?php if ($category == "Side by Side Refrigerator") echo "selected"; ?>>
                        Side by Side Refrigerator
                    </option>
                    <option value="InstaView Door-in-Door" <?php if ($category == "InstaView Door-in-Door") echo "selected"; ?>>
                        InstaView Door-in-Door
                    </option>
                    </select>
                    </div>
                    <div class="low">
                        <label> Capacity </label>
                        <input type="text" id="half" name="capacity"value="<?php echo $capacity; ?>" >
                       
                    </div>
                </div>
             

                <button input type="submit" name="submit" >Update</button>
            </form>
        </div>
    </div>
</body>
</html>

            <?php endwhile;
            include "footer.php"; 
    }else{
            header("location: ./lists.php");
    }}
         ?>
          