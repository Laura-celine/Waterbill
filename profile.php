<?php
session_start(); // Start session to manage user authentication

include("config.php"); // Include database connection


// Redirect user to login page if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"]; // Get logged-in user ID

// Fetch user details from the database
$query = "SELECT full_name, email, phone, address FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<?php include("header.php"); ?> <!-- Include header -->
<link rel="stylesheet" href="css/profile.css"> <!-- Link to profile CSS -->

<div class="profile-container">
    <h2>User Profile</h2>

    <form id="profile-form" action="update_profile.php" method="POST">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly> <!-- Email should not be editable -->

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>

        <button type="submit">Update Profile</button>
    </form>
</div>

<?php include("footer.php"); ?> <!-- Include footer -->
<script src="js/profile.js"></script> <!-- Link to JavaScript file -->