 const filters = document.querySelectorAll('.filters input[type="checkbox"]');
    const clearFiltersButton = document.getElementById('clear-filters');
    const products = document.querySelectorAll('.product-card');

    filters.forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });

    clearFiltersButton.addEventListener('click', () => {
        filters.forEach(filter => (filter.checked = false));
        applyFilters();
    });

    function applyFilters() {
        const activeFilters = {
            type: [],
            features: [],
            capacity: []
        };

        filters.forEach(filter => {
            if (filter.checked) {
                const category = filter.name;
                activeFilters[category].push(filter.value);
            }
        });

        products.forEach(product => {
            const productType = product.dataset.type;
            const productFeatures = product.dataset.features;
            const productCapacity = product.dataset.capacity;

            const typeMatch = !activeFilters.type.length || activeFilters.type.includes(productType);
            const featureMatch = !activeFilters.features.length || activeFilters.features.some(f => productFeatures.includes(f));
            const capacityMatch = !activeFilters.capacity.length || activeFilters.capacity.includes(productCapacity);

            if (typeMatch && featureMatch && capacityMatch) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    }