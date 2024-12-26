<?php
include "databaseconn.php";

    $sql = "SELECT ProductID as id, Name as name,  TRIM(image1) as image1
            FROM products 
            WHERE Name LIKE 'd%' 
            LIMIT 10";
    $result = mysqli_query($conn, $sql);

    $suggestions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row;
    }

    var_dump($suggestions);
