function applyFilter() {
    const filterValue = document.getElementById("filter-range").value;
    const startDate = document.getElementById("custom-start-date").value;
    const endDate = document.getElementById("custom-end-date").value;

    if (filterValue === "custom" && (!startDate || !endDate)) {
        alert("Please select both start and end dates for a custom filter.");
        return;
    }


    let query = `filter=${filterValue}`;
    if (filterValue === "custom") {
        query += `&start_date=${startDate}&end_date=${endDate}`;
    }

    fetch(`filterOrders.php?${query}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById("order-items").innerHTML = data;

            // Update the total and pending orders
            const totalOrders = document.getElementById("totalOrdersCount").value;
            const pendingOrders = document.getElementById("pendingOrdersCount").value;
            document.getElementById("total-orders").textContent = totalOrders;
            document.getElementById("pending-orders").textContent = pendingOrders;
        })
        .catch(error => console.error("Error fetching filtered orders:", error));
}

document.getElementById("filter-range").addEventListener("change", () => {
    const filterValue = document.getElementById("filter-range").value;
    const customDates = document.querySelectorAll(".custom-date");
    if (filterValue === "custom") {
        customDates.forEach(input => (input.style.display = "inline-block"));
    } else {
        customDates.forEach(input => (input.style.display = "none"));
    }
});