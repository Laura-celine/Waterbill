<?php
session_start(); // Start the session to check user authentication

include("config.php"); // Include database connection


// Redirect user to login page if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION["user_id"]; // Get logged-in user ID

// Fetch bill history for the user
$query = "SELECT bill_id, amount, due_date, status, created_at FROM bills WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<?php include("header.php"); ?> <!-- Include header -->
<link rel="stylesheet" href="css/bill_history.css"> <!-- Link to bill history CSS -->

<div class="bill-history-container">
    <h2>Your Bill History</h2>

    <!-- Table to display bill history -->
    <table>
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Amount ($)</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Generated On</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["bill_id"]); ?></td>
                    <td><?php echo number_format($row["amount"], 2); ?></td>
                    <td><?php echo date("F j, Y", strtotime($row["due_date"])); ?></td>
                    <td class="<?php echo strtolower($row["status"]); ?>">
                        <?php echo htmlspecialchars($row["status"]); ?>
                    </td>
                    <td><?php echo date("F j, Y", strtotime($row["created_at"])); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

<?php include("footer.php"); ?> <!-- Include footer -->
<script src="js/bill_history.js"></script> <!-- Link to JavaScript file -->