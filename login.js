 function validateForm(event) {
            event.preventDefault();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

   
            if (!email) {
                alert("Please enter your email.");
                return false;
            } else if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

          
            if (!password) {
                alert("Please enter your password.");
                return false;
            } else if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }

         
            document.forms["login-box"].submit();
        }