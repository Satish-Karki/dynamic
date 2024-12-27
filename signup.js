document.getElementById('signup-form').addEventListener('submit', function (e) {
  

    const username = document.getElementById('uname').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('cpwd').value;
    const options = document.getElementById('options').value;

    let errors = [];

    if (username === '') errors.push('Username is required.');
    if (email === '') errors.push('Email is required.');
    if (password === '') errors.push('Password is required.');
    if (confirmPassword !== password) errors.push('Passwords do not match.');
    if (options === '') errors.push('You must select an option.');

    if (errors.length > 0) {
        e.preventDefault(); 
        alert(errors.join('\n')); 
    } else {
        console.log('Form is valid and submitting...');
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
