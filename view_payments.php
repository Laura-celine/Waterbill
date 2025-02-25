<?php
session_start();
include("config.php"); // Include database connection

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: index.php");
    exit();
}

// Fetch all payments from the database
$paymentsQuery = "SELECT payments.payment_id, users.full_name, payments.amount, payments.payment_date, payments.payment_status 
                  FROM payments JOIN users ON payments.user_id = users.user_id ORDER BY payments.payment_date DESC";
$paymentsResult = $conn->query($paymentsQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - View Payments</title>
    <link rel="stylesheet" href="css/view_payments.css"> <!-- Link to external CSS -->
    <script src="js/view_payments.js" defer></script> <!-- Link to JavaScript -->
</head>
<body>

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
            <li><a href="view_payments.php" class="active">View Payments</a></li>
            <li><a href="reports.php">Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-nav">
            <h2>View Payments</h2>
        </div>

        <!-- Search Filter -->
        <input type="text" id="searchPayments" placeholder="Search payments..." onkeyup="filterPayments()">

        <!-- Payments Table -->
        <div class="table-container">
            <table id="paymentsTable">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Amount ($)</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($payment = $paymentsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($payment["full_name"]); ?></td>
                            <td><?php echo number_format($payment["amount"], 2); ?></td>
                            <td><?php echo date("d M Y", strtotime($payment["payment_date"])); ?></td>
                            <td>
                                <span class="status <?php echo strtolower($payment['status']); ?>">
                                    <?php echo $payment['status']; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>