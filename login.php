<?php
// Start the session to store user login data
session_start();

// Include the database configuration
require_once "config.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form input and sanitize
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Validate input fields
    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        // Query to check if user exists
        $stmt = $conn->prepare("SELECT user_id, full_name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $full_name, $hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Store user session data
                $_SESSION["user_id"] = $user_id;
                $_SESSION["full_name"] = $full_name;
                $_SESSION["logged_in"] = true;

                // Redirect to user dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "No account found with that email.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="css/login.css"> <!-- External CSS -->
</head>
<body>
    <div class="container">
    <div class="logo">
            <img src="images/login.png" alt="Water Bill Management System Logo">
        </div>
        <h2>User Login</h2>

        <!-- Display errors -->
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

        <form action="" method="POST">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>