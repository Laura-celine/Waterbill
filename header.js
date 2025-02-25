document.addEventListener("DOMContentLoaded", function() {
    // Highlight the active menu item
    let currentPage = window.location.pathname.split("/").pop();
    let menuItems = document.querySelectorAll(".nav-menu ul li a");

    menuItems.forEach(item => {
        if (item.getAttribute("href") === currentPage) {
            item.style.borderBottom = "2px solid yellow"; // Highlight active page
        }
    });
});