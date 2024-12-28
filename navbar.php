<?php
include "databaseconn.php";

$query = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';

if ($query) {
    $sql = "SELECT ProductID as id, Name as name,  image1 as imagel
            FROM products 
            WHERE Name LIKE '%$query%' 
            LIMIT 10";
    $result = mysqli_query($conn, $sql);

    $suggestions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row;
    }
   
} 
?>
<div class="navbar">
        <div class="navbar-left">
            <a href="home.php">Home</a>
            <a href="shop.php">Shop</a>
            <a href="contactus.php">Support</a>
            <a href="about.php">About</a>
            <div class="navbar-center">
            <input type="text" id="search-bar" placeholder="Search">
            <div id="search-results" class="search-results"></div>
        </div>
        </div>
       

        <div class="navbar-right">

            <a href="cart.php"><img src="https://img.icons8.com/ios-filled/50/ffffff/shopping-cart.png" alt="Cart">
            <a href="checkuser.php" ><img src="https://img.icons8.com/ios-filled/50/ffffff/user-male-circle.png" alt="User"></a>
            <!-- <img src="https://img.icons8.com/ios-filled/50/ffffff/menu--v1.png" alt="Menu"> -->
        </div>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
    const searchBar = document.getElementById("search-bar");
    const searchResults = document.getElementById("search-results");

   
    const basePath = '/projects/';

    searchBar.addEventListener("input", function () {
        const query = searchBar.value.trim();
        if (query.length > 0) {
            fetch(`search.php?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Log data for debugging
                    if (data.length > 0) {
                        searchResults.style.display = "block";
                        searchResults.innerHTML = data
                            .map(item => `
                                <a href="productdetails.php?id=${item.id}">
                                    <img src="${basePath}${item.imagel}" alt="${item.name}">
                                    <span>${item.name}</span>
                                </a>
                            `)
                            .join("");
                    } else {
                        searchResults.style.display = "none";
                        searchResults.innerHTML = "";
                    }
                })
                .catch(error => console.error("Error fetching search results:", error));
        } else {
            searchResults.style.display = "none";
            searchResults.innerHTML = "";
        }
    });

    document.addEventListener("click", function (e) {
        if (!searchResults.contains(e.target) && e.target !== searchBar) {
            searchResults.style.display = "none";
        }
    });
});


</script>
    