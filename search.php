<?php
include "databaseconn.php";

$query = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';

if ($query) {
    $sql = "SELECT ProductID as id, Name as name
            FROM products 
            WHERE Name LIKE '%$query%' 
            LIMIT 10";
    $result = mysqli_query($conn, $sql);

    $suggestions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = $row;
    }

    echo json_encode($suggestions);
} else {
    echo json_encode([]);
}
?>
