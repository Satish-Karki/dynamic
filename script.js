const quantitySelect = document.getElementById('quantity');
const categorySelect = document.getElementById('category');

quantitySelect.addEventListener('change', function() {
  const selectedValue = this.value;
  
  switch (selectedValue) {
    case 'top-freezer':
      console.log('Top Freezer refrigerator selected');
      break;
    case 'door-in-door':
      console.log('Door-in-Door selected');
      break;
    case 'side-by-side':
      console.log('Side by Side Refrigerator selected');
      break;
    case 'instaview':
      console.log('InstaView Door in Door selected');
      break;
    default:
      console.log('No refrigerator type selected');
  }
});

categorySelect.addEventListener('change', function() {
  const selectedOptions = Array.from(this.selectedOptions).map(option => option.value);
  console.log('Selected categories:', selectedOptions);
});