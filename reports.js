// Toggle sidebar visibility
document.getElementById('toggleSidebar').addEventListener('click', function () {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('collapsed');
});

// Optional: Collapse sidebar by default on smaller screens
window.addEventListener('resize', function () {
    const sidebar = document.querySelector('.sidebar');
    if (window.innerWidth < 768) {
        sidebar.classList.add('collapsed');
    } else {
        sidebar.classList.remove('collapsed');
    }
});

// Trigger resize event on page load
window.dispatchEvent(new Event('resize'));

// Function to export report as CSV
function exportReport() {
    alert("Export feature coming soon!");
}