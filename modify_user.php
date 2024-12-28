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
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #000; /* Black background */
            color: #fff; /* White text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #1a1a1a; /* Dark gray */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 22px;
            border-bottom: 1px solid #fff;
            padding-bottom: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            text-align: left;
        }

        input, textarea {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #333;
            color: #fff;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #fff;
        }

        button {
            padding: 10px 20px;
            font-size: 14px;
            background-color: #fff;
            color: #000;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        button:hover {
            background-color: #000;
            color: #fff;
            border: 1px solid #fff;
        }

        .message {
            margin-top: 10px;
            font-size: 14px;
        }

        .success {
            color: #4CAF50;
        }

        .error {
            color: #FF5252;
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
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required>

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
