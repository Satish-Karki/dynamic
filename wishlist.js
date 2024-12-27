
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