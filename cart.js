document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    if (message) {
        alert(decodeURIComponent(message));

        urlParams.delete('message');

       
        const newUrl = window.location.origin;
    
       
        window.history.replaceState(null, null, newUrl);
    }
    const cartItems = document.querySelectorAll(".cart-item");
    const grandTotalEl = document.getElementById("grand-total");

    const updateItemTotal = (cartItem) => {
        const quantityInput = cartItem.querySelector(".quantity-input");
        const unitPrice = parseFloat(cartItem.dataset.unitPrice);
        const totalPriceEl = cartItem.querySelector(".cart-item-total");

        const totalPrice = unitPrice * parseInt(quantityInput.value);
        totalPriceEl.textContent = `$${totalPrice.toFixed(2)}`;
    };

    const updateGrandTotal = () => {
        let grandTotal = 0;
        cartItems.forEach((cartItem) => {
            const quantityInput = cartItem.querySelector(".quantity-input");
            const unitPrice = parseFloat(cartItem.dataset.unitPrice);
            grandTotal += unitPrice * parseInt(quantityInput.value);
        });
        grandTotalEl.textContent = grandTotal.toFixed(2);
    };

    cartItems.forEach((cartItem) => {
        const quantityInput = cartItem.querySelector(".quantity-input");
        const decreaseButton = cartItem.querySelector("[data-action='decrease']");
        const increaseButton = cartItem.querySelector("[data-action='increase']");

        decreaseButton.addEventListener("click", () => {
            let currentQuantity = parseInt(quantityInput.value);
            if (currentQuantity > 1) {
                quantityInput.value = currentQuantity - 1;
                updateItemTotal(cartItem);
                updateGrandTotal();
            }
        });

        increaseButton.addEventListener("click", () => {
            let currentQuantity = parseInt(quantityInput.value);
            quantityInput.value = currentQuantity + 1;
            updateItemTotal(cartItem);
            updateGrandTotal();
        });
    });

    updateGrandTotal();

    
});
