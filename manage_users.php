<?php
session_start(); // Start session for authentication

include("config.php"); // Include database connection

// Redirect if admin is not logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: index.php");
    exit();
}

// Handle form submission for adding a new user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    $insertQuery = "INSERT INTO users (full_name, email, phone, address) 
                    VALUES ('$full_name', '$email', '$phone', '$address')";
    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('User added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding user: " . $conn->error . "');</script>";
    }
}

// Handle user deletion
if (isset($_GET["delete_id"])) {
    $user_id = $_GET["delete_id"];
    $deleteQuery = "DELETE FROM users WHERE user_id = '$user_id'";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('User deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $conn->error . "');</script>";
    }
}

// Fetch all users from the database
$usersQuery = "SELECT user_id, full_name, email, phone, address FROM users ORDER BY full_name ASC";
$usersResult = $conn->query($usersQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/manage_users.css"> <!-- Link to external CSS -->
    <script src="js/manage_users.js" defer></script> <!-- JavaScript for interactivity -->
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
    <div class="logo">
            <img src="images/logo.png" alt="">
        </div>
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage_users.php" class="active">Manage Users</a></li>
            <li><a href="manage_bills.php">Manage Bills</a></li>
            <li><a href="view_payments.php">View Payments</a></li>
            <li><a href="reports.php">Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-nav">
            <h2>Manage Users</h2>
            <!-- Button to open the add user modal -->
            <button id="openAddUserModal" class="add-btn">Add User</button>
        </div>

        <!-- Add User Modal -->
        <div id="addUserModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Add New User</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" required>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" id="phone" required>
                    <label for="address">Address:</label>
                    <input type="text" name="address" id="address" required>
                    <button type="submit" name="add_user">Add User</button>
                </form>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div id="editUserModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Edit User</h3>
                <form id="editUserForm" action="update_user.php" method="POST">
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <label for="edit_full_name">Full Name:</label>
                    <input type="text" name="full_name" id="edit_full_name" required>
                    <label for="edit_email">Email:</label>
                    <input type="email" name="email" id="edit_email" required>
                    <label for="edit_phone">Phone:</label>
                    <input type="text" name="phone" id="edit_phone" required>
                    <label for="edit_address">Address:</label>
                    <input type="text" name="address" id="edit_address" required>
                    <button type="submit">Update User</button>
                </form>
            </div>
        </div>

        <!-- Table to Display Users -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $usersResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td><?php echo htmlspecialchars($user['address']); ?></td>
                            <td>
                                <button class="edit-btn" onclick="openEditModal(<?php echo $user['user_id']; ?>, '<?php echo $user['full_name']; ?>', '<?php echo $user['email']; ?>', '<?php echo $user['phone']; ?>', '<?php echo $user['address']; ?>')">Edit</button>
                                <a href="?delete_id=<?php echo $user['user_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>