<?php
session_start(); // Start session for authentication

include("config.php"); // Include database connection

// Redirect if admin is not logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bill_id"])) {
    // Retrieve form data
    $bill_id = $_POST["bill_id"];
    $user_id = $_POST["user_id"];
    $amount = $_POST["amount"];
    $due_date = $_POST["due_date"];
    $status = $_POST["status"];

    // Validate input (optional but recommended)
    if (empty($user_id) || empty($amount) || empty($due_date) || empty($status)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }

    // Update bill in the database
    $updateQuery = "UPDATE bills 
                    SET user_id = '$user_id', amount = '$amount', due_date = '$due_date', status = '$status' 
                    WHERE bill_id = '$bill_id'";
    if ($conn->query($updateQuery)) {
        echo "<script>alert('Bill updated successfully!'); window.location.href = 'manage_bills.php';</script>";
    } else {
        echo "<script>alert('Error updating bill: " . $conn->error . "'); window.history.back();</script>";
    }
} else {
    // Redirect if the form is not submitted
    header("Location: manage_bills.php");
    exit();
}
?>