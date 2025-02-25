<?php
session_start();
include("config.php"); // Include database connection

// Redirect to login page if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION["user_id"];
$userQuery = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();

// Fetch total bills, pending bills, and total payments
$billQuery = "SELECT COUNT(*) AS total_bills, 
                     SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_bills,
                     SUM(amount) AS total_payments 
              FROM bills WHERE user_id = ?";
$stmt = $conn->prepare($billQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$billResult = $stmt->get_result();
$billStats = $billResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css"> <!-- Link to external CSS -->
    <script src="dashboard.js" defer></script> <!-- JavaScript for interactivity -->
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="logo">
            <img src="images/logo.png" alt="#">
        </div>
        <h2>Water Bill System</h2>
        <ul>
            <li><a href="dashboard.php" class="active">Dashboard</a></li>
            <li><a href="bill_history.php">Bill History</a></li>
            <li><a href="payment.php">Make Payment</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="support.php">Support</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-nav">
            <h2>Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h2>
        </div>

        <!-- Dashboard Statistics -->
        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Bills</h3>
                <p><?php echo $billStats['total_bills']; ?></p>
            </div>
            <div class="card">
                <h3>Pending Bills</h3>
                <p><?php echo $billStats['pending_bills']; ?></p>
            </div>
            <div class="card">
                <h3>Total Payments</h3>
                <p>$<?php echo number_format($billStats['total_payments'], 2); ?></p>
            </div>
        </div>
    </div>

</body>
</html>