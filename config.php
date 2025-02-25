<?php
// Start a session to manage user login


// Database connection credentials
$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "water_bill_system";

// Create a new connection to the MySQL database
$conn = new mysqli($host, $user, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>