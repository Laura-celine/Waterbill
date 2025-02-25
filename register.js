function validateForm() {
    // Get form fields
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm_password").value;

    // Check if passwords match
    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
    }

    return true;
}