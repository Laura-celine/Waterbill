<?php
session_start();
include("config.php"); // Include database connection

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: index.php");
    exit();
}

// Get total users
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()["total_users"];

// Get total payments
$totalPaymentsQuery = "SELECT SUM(amount) AS total_payments FROM payments WHERE payment_status = 'Paid'";
$totalPaymentsResult = $conn->query($totalPaymentsQuery);
$totalPayments = $totalPaymentsResult->fetch_assoc()["total_payments"];

// Get pending bills
$pendingBillsQuery = "SELECT SUM(amount) AS pending_bills FROM bills WHERE status = 'Pending'";
$pendingBillsResult = $conn->query($pendingBillsQuery);
$pendingBills = $pendingBillsResult->fetch_assoc()["pending_bills"];

// Get monthly revenue data
$monthlyRevenueQuery = "SELECT MONTH(payment_date) AS month, SUM(amount) AS revenue FROM payments 
                        WHERE payment_status = 'Paid' GROUP BY MONTH(payment_date)";
$monthlyRevenueResult = $conn->query($monthlyRevenueQuery);
$monthlyData = [];
while ($row = $monthlyRevenueResult->fetch_assoc()) {
    $monthlyData[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Reports</title>
    <link rel="stylesheet" href="css/reports.css"> <!-- Link to external CSS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for graphs -->
    <script src="js/reports.js" defer></script> <!-- Link to JavaScript -->
</head>
<body>

    <!-- Sidebar -->
   <!-- Sidebar -->
   <div class="sidebar">
   <div class="logo">
            <img src="images/logo.png" alt="">
        </div>
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="dashboard.php" >Dashboard</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_bills.php">Manage Bills</a></li>
            <li><a href="view_payments.php">View Payments</a></li>
            <li><a href="reports.php" class="active">Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-nav">
            <h2>Reports</h2>
        </div>

        <!-- Summary Cards -->
        <div class="report-summary">
            <div class="card">
                <h3>Total Users</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
            <div class="card">
                <h3>Total Payments ($)</h3>
                <p><?php echo number_format($totalPayments, 2); ?></p>
            </div>
            <div class="card">
                <h3>Pending Bills ($)</h3>
                <p><?php echo number_format($pendingBills, 2); ?></p>
            </div>
        </div>

        <!-- Chart for Monthly Revenue -->
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <script>
        // Monthly revenue data
        const monthlyRevenue = <?php echo json_encode($monthlyData); ?>;
        const months = monthlyRevenue.map(item => `Month ${item.month}`);
        const revenue = monthlyRevenue.map(item => item.revenue);

        // Chart.js - Monthly Revenue
        new Chart(document.getElementById("revenueChart"), {
            type: "bar",
            data: {
                labels: months,
                datasets: [{
                    label: "Monthly Revenue ($)",
                    data: revenue,
                    backgroundColor: "rgba(0, 122, 255, 0.8)"
                }]
            }
        });
    </script>

</body>
</html>