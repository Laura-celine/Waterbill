document.addEventListener("DOMContentLoaded", function() {
    let form = document.getElementById("support-form");

    form.addEventListener("submit", function(event) {
        let subject = document.getElementById("subject").value.trim();
        let message = document.getElementById("message").value.trim();

        // Ensure subject and message are not empty
        if (subject === "" || message === "") {
            alert("Please fill out all fields before submitting.");
            event.preventDefault();
        }
    });
});