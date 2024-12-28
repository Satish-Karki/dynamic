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
        const productCapacity = parseInt(product.dataset.capacity, 10);

        const typeMatch = !activeFilters.type.length || activeFilters.type.includes(productType);
        const featureMatch = !activeFilters.features.length || activeFilters.features.some(f => productFeatures.includes(f));
        const capacityMatch = checkCapacityFilter(productCapacity, activeFilters.capacity);

        if (typeMatch && featureMatch && capacityMatch) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

function checkCapacityFilter(productCapacity, capacityFilters) {
    if (!capacityFilters.length) {
        return true;
    }

    return capacityFilters.some(filter => {
        if (filter === "400-600") {
            return productCapacity >= 400 && productCapacity <= 600;
        } else if (filter === "6000+") {
            return productCapacity >= 600;
        }
        return false;
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const scrollPosition = new URLSearchParams(window.location.search).get("scroll");
    if (scrollPosition) {
        window.scrollTo(0, parseInt(scrollPosition));
    }

    document.querySelectorAll("a.add-to").forEach(link => {
        link.addEventListener("click", (e) => {
            const yOffset = window.scrollY;
            const href = new URL(link.href);
            href.searchParams.set("scroll", yOffset);
            link.href = href.toString();
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    if (message) {
        alert(decodeURIComponent(message));

        const newUrl = window.location.origin + window.location.pathname;
        window.history.replaceState(null, null, newUrl);
    }
});
