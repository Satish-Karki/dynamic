<?php
session_start();
include "databaseconn.php";

// Check if user is logged in
if (!isset($_SESSION['user_login'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_login'];

// Fetch current user details
$sql = "SELECT Name, PhoneNumber, Email, Address FROM users WHERE UserID = $user_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "<p style='color: white; text-align: center;'>Error fetching user information.</p>";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(($_POST['name']));
    $phone = htmlspecialchars(($_POST['phone']));
    $email = htmlspecialchars(($_POST['email']));
    $address = htmlspecialchars(($_POST['address']));


    if (!empty($name) && !empty($phone) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($address)) {
        $update_sql = "UPDATE users 
                       SET Name = '$name', PhoneNumber = '$phone', Email = '$email', Address = '$address' 
                       WHERE UserID = $user_id";

        if (mysqli_query($conn, $update_sql)) {
            $message = "Updated successfully!";
            header("location:modify_user.php?message=$message");
            exit;
        } else {
            $message = "Update failed!";
            header("location:modify_user.php?message=$message");
        }
    } else {
     
        $message = "Please fill out all fields correctly.!";
        header("location:modify_user.php?message=$message");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify User Information</title>
    <style>
        body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: linear-gradient(145deg, #000000, #1a1a1a);
    min-height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    padding: 20px;
}

.container {
    background: rgba(26, 26, 26, 0.95);
    width: 100%;
    max-width: 420px;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
}

.container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #fff, rgba(255,255,255,0.1));
}

h2 {
    margin: 0 0 20px;
    font-size: 22px;
    font-weight: 600;
    text-align: center;
    letter-spacing: -0.5px;
    position: relative;
    padding-bottom: 12px;
}

h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 2px;
    background: #fff;
    border-radius: 2px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.input-group {
    position: relative;
    transition: transform 0.3s ease;
}

.input-group:hover {
    transform: translateX(5px);
}

label {
    display: block;
    margin-bottom: 5px;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.8);
}

input, textarea {
    width: 100%;
    padding: 10px 12px;
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
    font-size: 14px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

input:focus, textarea:focus {
    outline: none;
    border-color: rgba(255, 255, 255, 0.5);
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
}

textarea {
    resize: vertical;
    min-height: 80px;
}

button {
    margin-top: 15px;
    padding: 12px 24px;
    border: 2px solid #fff;
    border-radius: 8px;
    background: transparent;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
}

button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: #fff;
    transition: transform 0.3s ease;
    z-index: -1;
}

button:hover {
    color: #000;
}

button:hover::before {
    transform: translateX(100%);
}

.message {
    margin-top: 15px;
    padding: 10px;
    border-radius: 6px;
    font-weight: 500;
    text-align: center;
    animation: slideIn 0.3s ease;
    font-size: 13px;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.success {
    background: rgba(76, 175, 80, 0.1);
    border: 1px solid #4CAF50;
    color: #4CAF50;
}

.error {
    background: rgba(255, 82, 82, 0.1);
    border: 1px solid #FF5252;
    color: #FF5252;
}

a {
    display: inline-block;
    margin-top: 15px;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 13px;
    transition: all 0.3s ease;
    position: relative;
}

a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 1px;
    background: #fff;
    transition: width 0.3s ease;
}

a:hover {
    color: #fff;
}

a:hover::after {
    width: 100%;
}

@media (max-width: 480px) {
    .container {
        padding: 20px;
        margin: 10px;
    }
    
    button {
        width: 100%;
    }

    input, textarea {
        padding: 8px 10px;
    }
}
    </style>
</head>
<body>
    <div class="container">
        <h2>Modify User Information</h2>
        <?php if (isset($success_message)): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required>
            </div>
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['PhoneNumber']); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>

            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" required><?php echo htmlspecialchars($user['Address']); ?></textarea>

            <button type="submit">Update Information</button>
        </form>
        <a href="settings.php">Go back</a>
    </div>
</body>
</html>
