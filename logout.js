document.addEventListener("DOMContentLoaded", function() {
    let countdownElement = document.getElementById("countdown");
    let countdown = 5;

    let interval = setInterval(function() {
        countdown--;
        countdownElement.textContent = countdown;

        if (countdown === 0) {
            clearInterval(interval);
            window.location.href = "login.php"; // Redirect to login page
        }
    }, 1000);
});