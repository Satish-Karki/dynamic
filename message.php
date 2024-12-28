<?php
session_start();
include "databaseconn.php";

if (!isset($_SESSION['user_login'])) {
    header("location: login.php");
    exit();
}

$currentUserId = $_SESSION['user_login'];

$conversationId = $_GET['conversation_id'] ?? null;
$withUserId = $_GET['with'] ?? null;

if (!$conversationId || !$withUserId) {
    header("location: inbox.php");
    exit();
}


$currentUserType = $_SESSION['user_type'];


$sql = "
    SELECT 
        conversations.ConversationID, 
        conversations.Messages, 
        conversations.Date, 
        users.Name AS SenderName,
         conversations.SenderID
     
    FROM 
        conversations
    INNER JOIN 
        users 
    ON 
        conversations.SenderID = users.UserID
   
    WHERE 
        conversations.ConversationID = $conversationId
    ORDER BY 
        conversations.Date ASC";

$result = mysqli_query($conn, $sql);

$sqlUser = "SELECT Name FROM users WHERE UserID = $withUserId";
$userResult = mysqli_query($conn, $sqlUser);
$otherUser = mysqli_fetch_assoc($userResult);
$otherUserName = $otherUser['Name'] ?? 'Unknown User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation</title>
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="message.css">
    
</head>
<body>
    <?php include "navbar.php"; ?>

    <div class="chat-container">

        <h1><a href="inbox.php">Go back</a>
        <h1 class="chat-header">Conversation with <?php echo htmlspecialchars($otherUserName); ?></h1>
        <div class="messages">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php 
                    $isCurrentUser = ($row['SenderID'] == $currentUserId); 
                    $messageClass = $isCurrentUser ? "right" : "left";
                ?>
                <div class="message <?php echo $messageClass; ?>">
                    <div class="message-content">
                        <?php echo nl2br(htmlspecialchars($row['Messages'])); ?>
                    </div>
                    <div class="message-date">
                        <?php echo date('d M Y, H:i', strtotime($row['Date'])); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <form action="reply.php" method="POST" class="reply-box">
            <textarea name="message" rows="3" placeholder="Type your message..." required></textarea>
            <input type="hidden" name="conversation_id" value="<?php echo htmlspecialchars($conversationId); ?>">
            <input type="hidden" name="to_user" value="<?php echo htmlspecialchars($withUserId); ?>">
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>
