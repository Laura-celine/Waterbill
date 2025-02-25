// Open Add Bill Modal
document.getElementById("openAddBillModal").addEventListener("click", function () {
    document.getElementById("addBillModal").style.display = "flex";
});

// Close Add Bill Modal
document.querySelector("#addBillModal .close").addEventListener("click", function () {
    document.getElementById("addBillModal").style.display = "none";
});

// Open Edit Bill Modal
function openEditModal(billId, userId, amount, dueDate, status) {
    document.getElementById("edit_bill_id").value = billId;
    document.getElementById("edit_user_id").value = userId;
    document.getElementById("edit_amount").value = amount;
    document.getElementById("edit_due_date").value = dueDate;
    document.getElementById("edit_status").value = status;
    document.getElementById("editBillModal").style.display = "flex";
}

// Close Edit Bill Modal
document.querySelector("#editBillModal .close").addEventListener("click", function () {
    document.getElementById("editBillModal").style.display = "none";
});

// Close modals when clicking outside the modal content
window.addEventListener("click", function (event) {
    if (event.target.classList.contains("modal")) {
        event.target.style.display = "none";
    }
});