<?php
// Start session to manage user data
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once "config.php";

// Get the logged-in user's ID
$user_id = $_SESSION["user_id"];

// Fetch user details from the database
$stmt = $conn->prepare("SELECT full_name, email, phone, address FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $phone, $address);
$stmt->fetch();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated input values
    $new_full_name = trim($_POST["full_name"]);
    $new_phone = trim($_POST["phone"]);
    $new_address = trim($_POST["address"]);

    // Validate the inputs
    if (empty($new_full_name) || empty($new_phone) || empty($new_address)) {
        $error = "All fields are required.";
    } else {
        // Update user details in the database
        $stmt = $conn->prepare("UPDATE users SET full_name = ?, phone = ?, address = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $new_full_name, $new_phone, $new_address, $user_id);

        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
            // Update session with new full name
            $_SESSION["full_name"] = $new_full_name;
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="css/update_profile.css"> <!-- Link external CSS -->
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>

        <!-- Display error or success messages -->
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p class='success'>$success</p>"; } ?>

        <form action="" method="POST" onsubmit="return validateForm()">
            <label>Full Name</label>
            <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>

            <label>Email (Cannot be changed)</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" disabled>

            <label>Phone</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

            <label>Address</label>
            <textarea name="address" id="address" required><?php echo htmlspecialchars($address); ?></textarea>

            <button type="submit">Update Profile</button>
        </form>

        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>

    <script src="js/update_profile.js"></script> <!-- Link JavaScript file -->
</body>
</html>