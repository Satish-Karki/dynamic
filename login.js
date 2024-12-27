document.getElementById('login').addEventListener('submit', function (e) {
   
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    let errors = [];
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === '') {
        errors.push('Email is required.');
    } else if (!emailRegex.test(email)) {
        errors.push('Invalid email format.');
    }

    if (password === '') {
        errors.push('Password is required.');
    } 
  
    if (errors.length > 0) {
        alert(errors.join('\n')); 
        e.preventDefault();
    
    } else {
        this.submit();
        
    }
});
document.addEventListener('DOMContentLoaded', function() {
 
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    if (message) {
        alert(decodeURIComponent(message));

        urlParams.delete('message');

       
        const newUrl = window.location.origin + window.location.pathname + '?' + urlParams.toString();
    
       
        window.history.replaceState(null, null, newUrl);
    }
 
    
});