<?php
session_start();
include "databaseconn.php";

if (!isset($_SESSION['user_login'])) {
    header("location: login.php");
    exit();
}

$currentUserId = $_SESSION['user_login'];
$conversationId = $_POST['conversation_id'] ?? null;
$toUserId = $_POST['to_user'] ?? null;
$message = $_POST['message'] ?? null;



if (!$conversationId || !$toUserId || !$message) {
    header("location: inbox.php");
    exit();
}


$currentUserType=$_SESSION['user_type'];
if($currentUserType=='Vendor'){

$sql = "
    INSERT INTO conversations ( ConversationID,SenderID,CustomerID, VendorID, Messages, Date) 
    VALUES (
          $conversationId,
           $currentUserId, 
        $toUserId,
         $currentUserId, 
        '" . mysqli_real_escape_string($conn, $message) . "', 
        NOW()
    )";
}
else{
    $sql = "
    INSERT INTO conversations (ConversationID,SenderID, CustomerID, VendorID, Messages, Date) 
    VALUES (
    $conversationId,   
     $currentUserId,  
          $currentUserId, 
        $toUserId, 
        '" . mysqli_real_escape_string($conn, $message) . "', 
        NOW()
    )";
}
mysqli_query($conn, $sql);  

header("location: message.php?conversation_id=$conversationId&with=$toUserId");
exit();
