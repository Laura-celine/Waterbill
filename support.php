<?php
session_start(); // Start session to manage user authentication

include("config.php"); // Include database connection


// Redirect user to login page if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION["user_id"]; // Get logged-in user ID

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    // Insert support request into database
    $query = "INSERT INTO support_tickets (user_id, subject, message, status, created_at) VALUES (?, ?, ?, 'Pending', NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $user_id, $subject, $message);

    if ($stmt->execute()) {
        $success_message = "Your support request has been submitted successfully!";
    } else {
        $error_message = "Error submitting request. Please try again.";
    }
}
?>

<?php include("header.php"); ?> <!-- Include header -->
<link rel="stylesheet" href="css/support.css"> <!-- Link to support CSS -->

<div class="support-container">
    <h2>Contact Support</h2>

    <!-- Display success or error message -->
    <?php if (isset($success_message)) echo "<p class='success'>$success_message</p>"; ?>
    <?php if (isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>

    <form id="support-form" method="POST">
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Submit Request</button>
    </form>
</div>

<?php include("footer.php"); ?> <!-- Include footer -->
<script src="js/support.js"></script> <!-- Link to JavaScript file -->