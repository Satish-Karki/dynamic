
        document.getElementById('signup-form').addEventListener('submit', function (e) {
            e.preventDefault(); 

            const username = document.getElementById('uname').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('cpwd').value;
            const options = document.getElementById('options').value;
            const terms = document.getElementById('terms').checked;

            let errors = [];

        
            if (username === '') {
                errors.push('Username is required.');
            } else if (username.length < 3) {
                errors.push('Username must be at least 3 characters.');
            }

      
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '') {
                errors.push('Email is required.');
            } else if (!emailRegex.test(email)) {
                errors.push('Invalid email format.');
            }

           
            if (password === '') {
                errors.push('Password is required.');
            } else if (password.length < 8) {
                errors.push('Password must be at least 8 characters.');
            }

            if (confirmPassword === '') {
                errors.push('Confirm Password is required.');
            } else if (password !== confirmPassword) {
                errors.push('Passwords do not match.');
            }

      
            if (options === '') {
                errors.push('You must select an option.');
            }

    
            if (!terms) {
                errors.push('You must accept the terms and privacy policy.');
            }

    
            if (errors.length > 0) {
                alert(errors.join('\n'));
            } else {
                alert('Form submitted successfully!');
                e.target.submit();
            }
        });
 
