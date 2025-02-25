document.addEventListener("DOMContentLoaded", function() {
    // Dynamically update the footer copyright year
    let yearSpan = document.querySelector(".footer p");
    if (yearSpan) {
        let currentYear = new Date().getFullYear();
        yearSpan.innerHTML = `&copy; ${currentYear} Water Bill Management System. All Rights Reserved.`;
    }
});