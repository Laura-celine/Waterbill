document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function(event) {
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        const errorMessage = document.getElementById("error-message");

        // Basic form validation
        if (email.trim() === "" || password.trim() === "") {
            errorMessage.textContent = "All fields are required!";
            event.preventDefault(); // Prevent form submission
            return;
        }

        // Additional validation can be added here
        errorMessage.textContent = ""; // Clear error if valid
    });
});

