<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Bill Management System</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS -->
</head>
<body>
    <div class="container">
        <h1>Welcome to Water Bill Management System</h1>
        <p>Select your role to proceed:</p>
        
        <!-- Buttons to navigate to User and Admin login pages -->
        <div class="buttons">
            <a href="user/login.php" class="btn user-btn">User Login</a>
            <a href="admin/login.php" class="btn admin-btn">Admin Login</a>
        </div>
    </div>

    <script src="script.js"></script> <!-- Link to external JS -->
</body>
</html>