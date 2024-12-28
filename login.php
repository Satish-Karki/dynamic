
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="login.css">
   
    
</head>
<body>
    
    <div class="contents">
        <form action="check.php" method="POST" id="login" name="login-box">
            <h2>Log in</h2>

            <div class="input-fields">
                <label for="email"><b>Email</b></label>
                <input type="email" name="email" id="email" placeholder="Your email" >
                <label for="password"><b>Password</b></label>
                <input type="password" name="password" id="password" placeholder="Password" >
            </div>
            <div class="other-inputs">
                <label class="custom-checkbox">
                    <input type="checkbox"> Remember me
                </label>
                <a href="forgot.php">Forgot Password?</a>
            </div>
            <button type="submit" name="submit" class="btn">Login</button>
            <div class="others">
                <p>OR</p>
                <a href="signup.php">or create an account</a>
            </div>
        </form>
    </div>
    <script src="login.js"></script>
</body>
</html>