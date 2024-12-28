document.addEventListener('DOMContentLoaded', function() {
   
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.querySelector('.main-image img');

   
    const toggleReviewsBtn = document.getElementById('toggleReviewsBtn');
    const reviewList = document.getElementById('reviewList');

    toggleReviewsBtn.addEventListener('click', () => {
       
        if (reviewList.style.display === 'none' || reviewList.style.display === '') {
            reviewList.style.display = 'block';
            toggleReviewsBtn.textContent = 'Hide Reviews';
        } else {
            reviewList.style.display = 'none';
            toggleReviewsBtn.textContent = 'See Reviews';
        }
    });
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            thumbnails.forEach(thumbnail => thumbnail.classList.remove('selected'));
            this.classList.add('selected'); 
            mainImage.src = this.querySelector('img').src;
        });
    });
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    if (message) {
        alert(decodeURIComponent(message));

        urlParams.delete('message');

       
        const newUrl = window.location.origin + window.location.pathname + '?' + urlParams.toString();
    
       
        window.history.replaceState(null, null, newUrl);
    }
 
    
});
function checkMax(input) {
    const max = parseInt(input.max, 10);
    const value = parseInt(input.value, 10);

    if (value > max) {
        input.value = max;
        alert(`You cannot select more than ${max} items.`);
    }
}

