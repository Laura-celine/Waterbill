// Open Add User Modal
document.getElementById("openAddUserModal").addEventListener("click", function () {
    document.getElementById("addUserModal").style.display = "flex";
});

// Close Add User Modal
document.querySelector("#addUserModal .close").addEventListener("click", function () {
    document.getElementById("addUserModal").style.display = "none";
});

// Open Edit User Modal
function openEditModal(userId, fullName, email, phone, address) {
    document.getElementById("edit_user_id").value = userId;
    document.getElementById("edit_full_name").value = fullName;
    document.getElementById("edit_email").value = email;
    document.getElementById("edit_phone").value = phone;
    document.getElementById("edit_address").value = address;
    document.getElementById("editUserModal").style.display = "flex";
}

// Close Edit User Modal
document.querySelector("#editUserModal .close").addEventListener("click", function () {
    document.getElementById("editUserModal").style.display = "none";
});

// Close modals when clicking outside the modal content
window.addEventListener("click", function (event) {
    if (event.target.classList.contains("modal")) {
        event.target.style.display = "none";
    }
});