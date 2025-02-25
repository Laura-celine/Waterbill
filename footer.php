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
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <!-- Footer Section -->
<footer class="footer">
    <div class="container">
        <p>&copy; <?php echo date("Y"); ?> Water Bill Management System. All Rights Reserved.</p>
        <nav class="footer-nav">
            <a href="index.php">Home</a>
            <a href="support.php">Support</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</footer>

<!-- Link to external JavaScript file -->
<script src="js/footer.js"></script>
    
</body>
</html>