<?php
    $conn = new mysqli("localhost", "root", "", "canon");
    if(!$conn) die("Oops! Database connection failed.");