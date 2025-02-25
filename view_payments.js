// Search Payments
function filterPayments() {
    let input = document.getElementById("searchPayments");
    let filter = input.value.toLowerCase();
    let table = document.getElementById("paymentsTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td")[0]; // Get Full Name Column
        if (td) {
            let txtValue = td.textContent || td.innerText;
            tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
        }
    }
}