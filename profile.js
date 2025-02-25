document.addEventListener("DOMContentLoaded", function() {
    let form = document.getElementById("profile-form");

    form.addEventListener("submit", function(event) {
        let phone = document.getElementById("phone").value.trim();
        let address = document.getElementById("address").value.trim();

        // Validate phone number (should be at least 10 digits)
        if (phone.length < 10 || isNaN(phone)) {
            alert("Please enter a valid phone number.");
            event.preventDefault();
        }

        // Ensure address is not empty
        if (address === "") {
            alert("Address cannot be empty.");
            event.preventDefault();
        }
    });
});