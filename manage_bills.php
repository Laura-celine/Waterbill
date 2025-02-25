<?php
session_start(); // Start session for authentication

include("config.php"); // Database connection

// Redirect if admin is not logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: index.php");
    exit();
}

// Handle form submission for adding a new bill
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_bill"])) {
    $user_id = $_POST["user_id"];
    $amount = $_POST["amount"];
    $due_date = $_POST["due_date"];
    $status = $_POST["status"];

    $insertQuery = "INSERT INTO bills (user_id, amount, due_date, status) 
                    VALUES ('$user_id', '$amount', '$due_date', '$status')";
    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('Bill added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding bill: " . $conn->error . "');</script>";
    }
}

// Handle bill deletion
if (isset($_GET["delete_id"])) {
    $bill_id = $_GET["delete_id"];
    $deleteQuery = "DELETE FROM bills WHERE bill_id = '$bill_id'";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('Bill deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting bill: " . $conn->error . "');</script>";
    }
}

// Fetch all bills from the database
$billsQuery = "SELECT bills.bill_id, users.full_name, bills.amount, bills.due_date, bills.status 
               FROM bills JOIN users ON bills.user_id = users.user_id 
               ORDER BY bills.due_date DESC";
$billsResult = $conn->query($billsQuery);

// Fetch all users for the dropdown in the add bill form
$usersQuery = "SELECT user_id, full_name FROM users";
$usersResult = $conn->query($usersQuery);

// Calculate total payments
$totalPaymentsQuery = "SELECT SUM(amount) AS total_payments FROM bills WHERE status = 'Paid'";
$totalPaymentsResult = $conn->query($totalPaymentsQuery);
$totalPayments = $totalPaymentsResult->fetch_assoc()["total_payments"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Bills</title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="css/manage_bills.css">
</head>
<body>
    <!-- Sidebar -->
    <!-- Sidebar -->
    <div class="sidebar">
    <div class="logo">
            <img src="images/logo.png" alt="">
        </div>
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_bills.php" class="active">Manage Bills</a></li>
            <li><a href="view_payments.php">View Payments</a></li>
            <li><a href="reports.php">Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <div class="top-nav">
            <h2>Manage Bills</h2>
            <!-- Button to open the add bill form -->
            <button id="openAddBillModal" class="add-btn">Add Bill</button>
        </div>

        <!-- Add Bill Form (Hidden by default) -->
        <div id="addBillModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Add New Bill</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="user_id">User:</label>
                <select name="user_id" id="user_id" required>
                    <?php while ($user = $usersResult->fetch_assoc()): ?>
                        <option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name']; ?></option>
                    <?php endwhile; ?>
                </select>
                <label for="amount">Amount ($):</label>
                <input type="number" name="amount" id="amount" step="0.01" required>
                <label for="due_date">Due Date:</label>
                <input type="date" name="due_date" id="due_date" required>
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                    <option value="Overdue">Overdue</option>
                </select>
                <button type="submit" name="add_bill">Add Bill</button>
                <button type="button" id="closeAddBillForm">Cancel</button>
            </form>
        </div>
        </div>

         <!-- Edit Bill Modal -->
         <div id="editBillModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Edit Bill</h3>
                <form id="editBillForm" action="update_bill.php" method="POST">
                    <input type="hidden" name="bill_id" id="edit_bill_id">
                    <label for="edit_user_id">User:</label>
                    <select name="user_id" id="edit_user_id" required>
                        <?php
                        $usersResult->data_seek(0); // Reset the result pointer
                        while ($user = $usersResult->fetch_assoc()): ?>
                            <option value="<?php echo $user['user_id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                    <label for="edit_amount">Amount ($):</label>
                    <input type="number" name="amount" id="edit_amount" step="0.01" required>
                    <label for="edit_due_date">Due Date:</label>
                    <input type="date" name="due_date" id="edit_due_date" required>
                    <label for="edit_status">Status:</label>
                    <select name="status" id="edit_status" required>
                        <option value="Paid">Paid</option>
                        <option value="Pending">Pending</option>
                        <option value="Overdue">Overdue</option>
                    </select>
                    <button type="submit">Update Bill</button>
                </form>
            </div>
        </div>

        <!-- Dashboard Statistics -->
        <div class="dashboard-cards">
            <!-- Card for Total Payments -->
            <div class="card">
                <h3>Total Payments</h3>
                <p>$<?php echo number_format($totalPayments, 2); ?></p>
            </div>
        </div>

        <!-- Table to Display Bills -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Amount ($)</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($bill = $billsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($bill['full_name']); ?></td>
                            <td><?php echo number_format($bill['amount'], 2); ?></td>
                            <td><?php echo date("d M Y", strtotime($bill['due_date'])); ?></td>
                            <td>
                                <span class="status <?php echo strtolower($bill['status']); ?>">
                                    <?php echo $bill['status']; ?>
                                </span>
                            </td>
                            <td>
                                <button class="edit-btn" onclick="openEditModal(<?php echo $bill['bill_id']; ?>)">Edit</button>
                                <a href="?delete_id=<?php echo $bill['bill_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this bill?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Link to external JavaScript -->
    <script src="js/manage_bills.js"></script>
</body>
</html>