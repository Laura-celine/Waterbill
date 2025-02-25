// Function to toggle sidebar visibility
function toggleSidebar() {
    let sidebar = document.getElementById('sidebar');
    let content = document.getElementById('main-content');

    //toggle class "hidden" to show/hide sidebar
    sidebar.classList.toggle('hidden');

    //adjustcontent width when sidebar is hidden
    if (sidebar.classList.contains('hidden')) {
        content.style.marginLeft = "0";
    } else {
        content.style.marginLeft = "260px";
    }
}