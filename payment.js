document.addEventListener("DOMContentLoaded", function() {
    let form = document.getElementById("payment-form");

    form.addEventListener("submit", function(event) {
        let checkedBills = document.querySelectorAll("input[name='bills[]']:checked");

        if (checkedBills.length === 0) {
            alert("Please select at least one bill to pay.");
            event.preventDefault();
        }
    });
});