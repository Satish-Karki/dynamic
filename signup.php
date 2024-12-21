<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="global.css">
</head>
<body>
   <?php include "navbar.php";?>
    <div class="contents">
        <form action="register.php" method="POST" name="signup-box">
            <h2>Sign Up</h2>
            <div class="input-fields">
                <label for="uname"><b>Username</b></label>
                <input type="text" name="uname" id="uname" placeholder="Your username">
                <label for="email"><b>Email</b></label>
                <input type="email" name="email" id="email" placeholder="Your email">
                <label for="password"><b>Password</b></label>
                <input type="password" name="password" id="password" placeholder="Password">
                <label for="cpwd"><b>Confirm Password</b></label>
                <input type="password" name="cpwd" id="cpwd" placeholder="Confirm Password">
                <label for="options"><b>Sign Up as:</b></label>
                <select id="options" name="options">
                    <option value="Vendor">Vendor</option>
                    <option value="Customer">Customer</option>
                </select>
            </div>
            <label class="custom-checkbox">
                <input type="checkbox" id="terms"> I accept the terms and privacy policy
            </label>
            <button type="submit" class="btn" name="submit">Sign up</button>
            <div class="others">
                <p>Already have an account?</p>
                <a href="login.php"><b>Login</b></a>
            </div>
        </form>
    </div>
    <script src="signup.js"></script>
</body>

</html>
