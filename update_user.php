<?php
session_start(); // Start session for authentication

include("config.php"); // Include database connection

// Redirect if admin is not logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    // Retrieve form data
    $user_id = $_POST["user_id"];
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    // Validate input (optional but recommended)
    if (empty($full_name) || empty($email) || empty($phone) || empty($address)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }

    // Update user in the database
    $updateQuery = "UPDATE users 
                    SET full_name = '$full_name', email = '$email', phone = '$phone', address = '$address' 
                    WHERE user_id = '$user_id'";
    if ($conn->query($updateQuery)) {
        echo "<script>alert('User updated successfully!'); window.location.href = 'manage_users.php';</script>";
    } else {
        echo "<script>alert('Error updating user: " . $conn->error . "'); window.history.back();</script>";
    }
} else {
    // Redirect if the form is not submitted
    header("Location: manage_users.php");
    exit();
}
?>