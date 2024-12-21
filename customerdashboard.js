function applyFilter() {
            const filter = document.getElementById("filter-range").value;
            const customStartDate = document.getElementById("custom-start-date");
            const customEndDate = document.getElementById("custom-end-date");

            if (filter === "custom") {
                customStartDate.style.display = "inline-block";
                customEndDate.style.display = "inline-block";
            } else {
                customStartDate.style.display = "none";
                customEndDate.style.display = "none";
                filterOrders(filter);
            }
        }

        function filterOrders(filter) {
           
            const orders = document.getElementById("order-items");
            const transactions = document.getElementById("transaction-history");

            if (filter === "daily") {
                orders.innerHTML = "<p>No orders for today</p>";
                transactions.innerHTML = "<p>No transactions for today</p>";
            } else if (filter === "weekly") {
                orders.innerHTML = "<p>Displaying weekly orders...</p>";
                transactions.innerHTML = "<p>Displaying weekly transactions...</p>";
            } else if (filter === "monthly") {
                orders.innerHTML = "<p>Displaying monthly orders...</p>";
                transactions.innerHTML = "<p>Displaying monthly transactions...</p>";
            }
        }