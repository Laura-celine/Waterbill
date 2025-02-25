function validateForm() {
    // Get form fields
    let fullName = document.getElementById("full_name").value;
    let phone = document.getElementById("phone").value;
    let address = document.getElementById("address").value;

    // Validate full name (minimum 3 characters)
    if (fullName.length < 3) {
        alert("Full Name must be at least 3 characters long.");
        return false;
    }

    // Validate phone number (only digits, 10-15 characters)
    let phonePattern = /^[0-9]{10,15}$/;
    if (!phone.match(phonePattern)) {
        alert("Please enter a valid phone number (10-15 digits).");
        return false;
    }

    // Validate address (minimum 5 characters)
    if (address.length < 5) {
        alert("Address must be at least 5 characters long.");
        return false;
    }

    return true;
}