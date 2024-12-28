<?php
session_start();
include "databaseconn.php";

if (!isset($_SESSION['user_login'])) {
    header("location: login.php");
    exit();
}

$currentUserId = $_SESSION['user_login'];

$currentUserType = $_SESSION['user_type'];
if($currentUserType!='Customer'){
    header("location:inbox.php");
}
if ($currentUserType == 'Vendor') {
    $sql = "
        SELECT 
            inbox.InboxID AS InboxID,
            inbox.Messages AS Messages,
            inbox.ProductID AS ProductID,
            MAX(inbox.Date) AS Date,
            conversations.ConversationID AS ConversationID,
            users.Name AS Name,
            users.UserID AS UserID
        FROM 
            inbox
        INNER JOIN 
            users 
        ON 
            inbox.CustomerID = users.UserID
        LEFT JOIN 
            conversations 
        ON 
            inbox.CustomerID = conversations.CustomerID 
            AND inbox.VendorID = conversations.VendorID
        WHERE 
            inbox.VendorID = $currentUserId
        GROUP BY 
            conversations.ConversationID

        UNION

        SELECT 
            NULL AS InboxID,
            NULL AS Messages,
            NULL AS ProductID,
            MAX(conversations.Date) AS Date,
            conversations.ConversationID AS ConversationID,
            users.Name AS Name,
            users.UserID AS UserID
        FROM 
            conversations
        INNER JOIN 
            users 
        ON 
            users.UserID = conversations.CustomerID
        WHERE 
            conversations.VendorID = $currentUserId
        GROUP BY 
            conversations.ConversationID

        ORDER BY Date DESC";
} else {
    $sql = "
        SELECT 
            inbox.InboxID AS InboxID,
            inbox.Messages AS Messages,
            inbox.ProductID AS ProductID,
            MAX(inbox.Date) AS Date,
            conversations.ConversationID AS ConversationID,
            users.Name AS Name,
            users.UserID AS UserID
        FROM 
            inbox
        INNER JOIN 
            users 
        ON 
            inbox.VendorID = users.UserID
        LEFT JOIN 
            conversations 
        ON 
            inbox.CustomerID = conversations.CustomerID 
            AND inbox.VendorID = conversations.VendorID
        WHERE 
            inbox.CustomerID = $currentUserId
        GROUP BY 
            conversations.ConversationID

        UNION

        SELECT 
            NULL AS InboxID,
            NULL AS Messages,
            NULL AS ProductID,
            MAX(conversations.Date) AS Date,
            conversations.ConversationID AS ConversationID,
            users.Name AS Name,
            users.UserID AS UserID
        FROM 
            conversations
        INNER JOIN 
            users 
        ON 
            users.UserID = conversations.VendorID
        WHERE 
            conversations.CustomerID = $currentUserId
        GROUP BY 
            conversations.ConversationID

        ORDER BY Date DESC";
}



$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="inbox.css">
    <link rel="stylesheet" href="dashboarde.css">
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="big-container">
    <div class="options">
            <h2>DashStack</h2>
            <a href="customerdashboard.php" ><img src="images/ndashboard.png"> Orders</a>
            <a href="inboxc.php" id="dash"><img src="images/inbox.png">Inbox</a>
       
            <div class="options-down">
                <a href="#">Settings</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    <div class="inbox-container">
        <h1 class="inbox-header">Inbox</h1>
        <div class="message-list">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="message-item" 
                     onclick="location.href='message.php?conversation_id=<?php echo urlencode($row['ConversationID'] ?? $row['InboxID']); ?>&with=<?php echo urlencode($row['UserID']); ?>'">
                    <div class="message-info">
                        <strong><?php echo htmlspecialchars($row['Name']); ?></strong>
                        <p><?php echo htmlspecialchars(substr($row['Messages'], 0, 50)) . '...'; ?></p>
                    </div>
                    <div class="message-date">
                        <?php echo date('d M Y, H:i', strtotime($row['Date'] ?? '')); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
            </div>
</body>
</html>
