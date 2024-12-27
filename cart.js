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

    const checkMax = (input) => {
        const max = parseInt(input.max, 10);
        const value = parseInt(input.value, 10);

        if (value > max) {
            input.value = max; 
            alert(`Only ${max} are available in stock right now.`);
        } else if (value < 1) {
            input.value = 1; 
        }
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
            let maxQuantity = parseInt(quantityInput.max);

            if (currentQuantity < maxQuantity) {
                quantityInput.value = currentQuantity + 1;
                updateItemTotal(cartItem);
                updateGrandTotal();
            } else {
                alert(`Only ${maxQuantity} are available in stock right now.`);
            }
        });

       
        quantityInput.addEventListener("input", () => {
            checkMax(quantityInput);
            updateItemTotal(cartItem);
            updateGrandTotal();
        });
    });

    updateGrandTotal();
});
document.addEventListener('DOMContentLoaded', () => {
    const cartItems = document.querySelectorAll('.cart-item');

   
    const forms = document.querySelectorAll('.cart-update-form');
    forms.forEach(form => {
        form.addEventListener('submit', (event) => {
          
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });
    });


    const savedScrollPosition = sessionStorage.getItem('scrollPosition');
    if (savedScrollPosition) {
        window.scrollTo(0, savedScrollPosition);
        sessionStorage.removeItem('scrollPosition');
    }
});
