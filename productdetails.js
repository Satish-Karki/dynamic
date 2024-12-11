document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab');
    const panels = document.querySelectorAll('.tab-panel');
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.querySelector('.main-image img');

   
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active')); 
            tab.classList.add('active'); 

            panels.forEach(panel => panel.classList.add('hidden')); 
            const panelId = tab.getAttribute('data-tab'); 
            document.getElementById(panelId).classList.remove('hidden');
        });
    });

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            thumbnails.forEach(thumbnail => thumbnail.classList.remove('selected'));
            this.classList.add('selected'); 
            mainImage.src = this.querySelector('img').src;
        });
    });
});
