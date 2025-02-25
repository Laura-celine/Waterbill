<?php
// Start a session to manage user data
session_start();

include("config.php"); // Include database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs and sanitize them
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);

    // Validate inputs
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password) || empty($phone) || empty($address)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            // Insert new user into database
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $full_name, $email, $hashed_password, $phone, $address);
            
            if ($stmt->execute()) {
                $success = "Registration successful! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="css/register.css"> <!-- Link external CSS -->
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>

        <!-- Display errors or success messages -->
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form action="" method="POST" onsubmit="return validateForm()">
            <label>Full Name</label>
            <input type="text" name="full_name" id="full_name" required>

            <label>Email</label>
            <input type="email" name="email" id="email" required>

            <label>Password</label>
            <input type="password" name="password" id="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <label>Phone</label>
            <input type="text" name="phone" id="phone" required>

            <label>Address</label>
            <textarea name="address" id="address" required></textarea>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script src="js/register.js"></script> <!-- Link to JavaScript file -->
</body>
</html>