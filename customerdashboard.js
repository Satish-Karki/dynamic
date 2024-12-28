   // Show or hide custom date fields based on the selected filter
   document.getElementById('filter-range').addEventListener('change', function () {
    const customDateFields = document.getElementById('custom-date-fields');
    customDateFields.style.display = this.value === 'custom' ? 'block' : 'none';
});