<?php

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Bill Management System</title>
    <link rel="stylesheet" href="css/header.css"> <!-- Link to external CSS -->
    <script src="js/header.js" defer></script> <!-- Link to JavaScript -->
</head>
<body>

<!-- Header Section -->
<header class="header">
    <div class="container">
        <h1>Water Bill Management System</h1>
        <nav class="nav-menu">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="bill_history.php">Bill History</a></li>
                <li><a href="payment.php">Payment</a></li>
                <li><a href="support.php">Support</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>