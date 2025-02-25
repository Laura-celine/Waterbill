document.addEventListener("DOMContentLoaded", function() {
    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let statusCell = row.querySelector("td:nth-child(4)"); // Get the status column
        let statusText = statusCell.textContent.trim().toLowerCase();

        // Highlight overdue bills
        if (statusText === "overdue") {
            row.style.backgroundColor = "#ffdddd"; // Light red background
        }
    });
});